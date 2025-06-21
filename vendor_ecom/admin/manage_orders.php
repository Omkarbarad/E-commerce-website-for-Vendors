<?php
session_start();
include('../config/db.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Fetch all orders from the database
$query = "SELECT * FROM orders";
$orders_result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="text-center">Manage Orders</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($order = mysqli_fetch_assoc($orders_result)) : ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= $order['customer_name'] ?></td>
                    <td>$<?= $order['total_amount'] ?></td>
                    <td><?= $order['status'] ?></td>
                    <td>
                        <a href="view_order.php?id=<?= $order['id'] ?>" class="btn btn-info btn-sm">View</a>
                        <a href="update_order_status.php?id=<?= $order['id'] ?>" class="btn btn-warning btn-sm">Update Status</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
