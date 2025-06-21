<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['customer_id'])) {
    header("Location: ../customer/login.php");
    exit();
}

// build cart_items array
$cart_items = [];
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $query = "SELECT * FROM products WHERE id = '$product_id'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result);
            $product['quantity'] = $quantity;
            $cart_items[] = $product;
        }
    }
}

$total = 0;
foreach ($cart_items as $i) {
    $sub = $i['price'] * $i['quantity'];
    $net = $sub - ($sub * ($i['discount']/100));
    $total += $net;
}

// on POST: write orders + update summaries
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($cart_items)) {
    $customer_id = (int)$_SESSION['customer_id'];

    foreach ($cart_items as $i) {
        $pid = (int)$i['id'];
        $vid = (int)$i['vendor_id'];
        $qty = (int)$i['quantity'];
        $sub = $i['price'] * $qty;
        $net = $sub - ($sub * ($i['discount']/100));

        // 1) insert order row
        mysqli_query($conn, "
          INSERT INTO orders
            (customer_id, vendor_id, product_id, quantity, total_price)
          VALUES
            ($customer_id, $vid, $pid, $qty, $net)
        ");

        // 2) update vendor summary
        mysqli_query($conn, "
          UPDATE vendors
             SET total_earnings   = total_earnings   + $net,
                 total_items_sold = total_items_sold + $qty
           WHERE id = $vid
        ");

        // 3) update customer summary
        mysqli_query($conn, "
          UPDATE customers
             SET total_spent  = total_spent  + $net,
                 total_orders = total_orders + 1
           WHERE id = $customer_id
        ");
    }

    // clear cart & redirect
    unset($_SESSION['cart']);
    header("Location: payment_confirmation.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Checkout</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
  <h2 class="text-center mb-4">Checkout</h2>

  <?php if (empty($cart_items)): ?>
    <p class="text-center">Your cart is empty. <a href="../products/index.php">Browse Products</a></p>
  <?php else: ?>
    <table class="table">
      <thead><tr>
        <th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th>
      </tr></thead>
      <tbody>
        <?php foreach ($cart_items as $i):
          $sub = $i['price'] * $i['quantity'];
          $net = $sub - ($sub * ($i['discount']/100));
        ?>
          <tr>
            <td><?=htmlspecialchars($i['title'])?></td>
            <td>$<?=number_format($i['price'],2)?></td>
            <td><?=$i['quantity']?></td>
            <td>$<?=number_format($net,2)?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <h4>Total: $<?=number_format($total,2)?></h4>
    <form method="POST" class="mt-3">
      <button type="submit" class="btn btn-success w-100">Pay Now</button>
    </form>
  <?php endif; ?>
</div>
</body>
</html>
