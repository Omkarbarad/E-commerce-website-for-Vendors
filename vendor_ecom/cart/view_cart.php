<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['customer_id'])) {
    header("Location: ../customer/login.php");
    exit();
}

// Get product details for each product in the cart
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

// Remove item from cart
if (isset($_GET['remove'])) {
    $product_id = $_GET['remove'];
    unset($_SESSION['cart'][$product_id]);
    header("Location: view_cart.php");
    exit();
}

$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="text-center mb-4">Your Shopping Cart</h2>

    <?php if (empty($cart_items)): ?>
        <p class="text-center">Your cart is empty. <a href="../products/index.php">Browse Products</a></p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                    <?php
                    $subtotal = $item['price'] * $item['quantity'];
                    $discounted_price = $subtotal - ($subtotal * ($item['discount'] / 100));
                    $total += $discounted_price;
                    ?>
                    <tr>
                        <td><?= $item['title'] ?></td>
                        <td>$<?= number_format($item['price'], 2) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>$<?= number_format($discounted_price, 2) ?></td>
                        <td>
                            <a href="?remove=<?= $item['id'] ?>" class="btn btn-danger btn-sm">Remove</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h4>Total: $<?= number_format($total, 2) ?></h4>

        <div class="mt-3">
            <a href="../checkout/checkout.php" class="btn btn-primary w-100">Proceed to Checkout</a>
        </div>
    <?php endif; ?>

    <a href="../products/index.php" class="btn btn-warning mt-3">Continue Shopping</a>
</div>

</body>
</html>
