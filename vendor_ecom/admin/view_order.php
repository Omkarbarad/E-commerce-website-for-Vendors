<?php
session_start();
include('../config/db.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Fetch order details
    $query = "SELECT * FROM orders WHERE id = '$order_id'";
    $order_result = mysqli_query($conn, $query);
    $order = mysqli_fetch_assoc($order_result);

    // Fetch order items (products)
    $query_items = "SELECT * FROM order_items WHERE order_id = '$order_id'";
    $order_items_result = mysqli_query($conn, $query_items);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="text-center">Order Details</h2>

    <h4>Customer Information</h4>
    <p><strong>Name:</strong> <?= $order['customer_name'] ?></p>
    <p><strong>Email:</strong> <?= $order['customer_email'] ?></p>
    <p><strong>Phone:</strong> <?= $order['customer_phone'] ?></p>

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
</div>

</body>
</html>
