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

    // Fetch current order details
    $query = "SELECT * FROM orders WHERE id = '$order_id'";
    $result = mysqli_query($conn, $query);
    $order = mysqli_fetch_assoc($result);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $status = $_POST['status'];

        // Update order status
        $update_query = "UPDATE orders SET status = '$status' WHERE id = '$order_id'";
        if (mysqli_query($conn, $update_query)) {
            header("Location: manage_orders.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Order Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="text-center">Update Order Status</h2>

    <form method="POST">
        <div class="mb-3">
            <label for="status" class="form-label">Order Status</label>
            <select name="status" class="form-control">
                <option value="Pending" <?= $order['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="Shipped" <?= $order['status'] == 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                <option value="Delivered" <?= $order['status'] == 'Delivered' ? 'selected' : '' ?>>Delivered</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Status</button>
    </form>
</div>

</body>
</html>
