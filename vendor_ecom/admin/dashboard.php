<?php
session_start();
include('../config/db.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Get all products, vendors, and customers for management
$products = mysqli_query($conn, "SELECT * FROM products");
$vendors = mysqli_query($conn, "SELECT * FROM vendors");
$customers = mysqli_query($conn, "SELECT * FROM customers");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="text-center">Admin Dashboard</h2>

    <div class="row">
        <!-- Products Management -->
        <div class="col-md-4">
            <h4>Manage Products</h4>
            <ul>
                <li><a href="add_product.php">Add New Product</a></li>
                <li><a href="view_products.php">View All Products</a></li>
            </ul>
        </div>

        <!-- Vendors Management -->
        <div class="col-md-4">
            <h4>Manage Vendors</h4>
            <ul>
                <li><a href="view_vendors.php">View All Vendors</a></li>
            </ul>
        </div>

        <!-- Customers Management -->
        <div class="col-md-4">
            <h4>Manage Customers</h4>
            <ul>
                <li><a href="view_customers.php">View All Customers</a></li>
            </ul>
        </div>
    </div>

    <!-- View Orders (Order Management) -->
    <h4 class="mt-4">Order Management</h4>
    <ul>
        <li><a href="view_orders.php">View All Orders</a></li>
    </ul>

    <a href="logout.php" class="btn btn-danger mt-4">Logout</a>
</div>

</body>
</html>
