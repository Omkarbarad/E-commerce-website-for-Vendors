<?php
session_start();
include('../config/db.php');

// Check if order_id is set in the URL
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Fetch order details from the database
    $query = "SELECT * FROM orders WHERE id = '$order_id'";
    $order_result = mysqli_query($conn, $query);
    $order = mysqli_fetch_assoc($order_result);

    // Fetch order items
    $query_items = "SELECT * FROM order_items WHERE order_id = '$order_id'";
    $order_items_result = mysqli_query($conn, $query_items);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="text-center">Order Confirmation</h2>

    <h4>Thank you for your order!</h4>
    <p>Your order has been successfully placed. Below are the details of your order.</p>

    <h4>Customer Information</h4>
    <p><strong>Name:</strong> <?= $order['customer_name'] ?></p>
    <p><strong>Email:</strong> <?= $order['customer_email'] ?></p>

    <h4>Ordered Products</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($item = mysqli_fetch_assoc($order_items_result)) : ?>
                <tr>
                    <td><?= $item['product_name'] ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>$<?= $item['price'] ?></td>
                    <td>$<?= $item['total'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h4>Order Summary</h4>
    <p><strong>Total Amount:</strong> $<?= $order['total_amount'] ?></p>
    <p><strong>Status:</strong> <?= $order['status'] ?></p>

    <a href="index.php" class="btn btn-success">Continue Shopping</a>
</div>

</body>
</html>
