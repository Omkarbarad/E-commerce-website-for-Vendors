<?php
session_start();
include('../config/db.php');

// Check if the cart exists
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: view_cart.php");
    exit();
}

// Calculate total order amount
$total_amount = 0;
foreach ($_SESSION['cart'] as $product) {
    $total_amount += $product['price'] * $product['quantity'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Simulate payment processing (dummy payment)
    $payment_status = 'success';  // This would be updated based on the real payment gateway

    // Create an order
    $customer_name = $_SESSION['customer_name'];
    $customer_email = $_SESSION['customer_email'];

    // Insert order into the database
    $query = "INSERT INTO orders (customer_name, customer_email, total_amount, status) 
              VALUES ('$customer_name', '$customer_email', '$total_amount', 'Pending')";
    mysqli_query($conn, $query);
    $order_id = mysqli_insert_id($conn);

    // Insert ordered products into the order_items table
    foreach ($_SESSION['cart'] as $product) {
        $product_name = $product['name'];
        $quantity = $product['quantity'];
        $price = $product['price'];
        $total = $price * $quantity;

        $query_item = "INSERT INTO order_items (order_id, product_name, quantity, price, total) 
                       VALUES ('$order_id', '$product_name', '$quantity', '$price', '$total')";
        mysqli_query($conn, $query_item);
    }

    // Clear the cart after payment
    unset($_SESSION['cart']);

    // Redirect to the order confirmation page
    header("Location: order_confirmation.php?order_id=$order_id");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="text-center">Payment</h2>

    <h4>Order Summary</h4>
    <p><strong>Total Amount: </strong> $<?= $total_amount ?></p>

    <!-- Simulate payment form -->
    <form method="POST">
        <div class="mb-3">
            <label for="card_number" class="form-label">Card Number</label>
            <input type="text" name="card_number" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="expiry_date" class="form-label">Expiry Date</label>
            <input type="text" name="expiry_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="cvv" class="form-label">CVV</label>
            <input type="text" name="cvv" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Complete Payment</button>
    </form>
</div>

</body>
</html>
