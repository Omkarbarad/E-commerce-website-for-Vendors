<?php
session_start();
include('../config/db.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Fetch customer data from the database
$query = "SELECT * FROM customers";
$customers_result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Customers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="text-center">Manage Customers</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($customer = mysqli_fetch_assoc($customers_result)) : ?>
                <tr>
                    <td><?= $customer['name'] ?></td>
                    <td><?= $customer['email'] ?></td>
                    <td><?= $customer['phone'] ?></td>
                    <td>
                        <a href="view_customer.php?id=<?= $customer['id'] ?>" class="btn btn-info btn-sm">View</a>
                        <a href="delete_customer.php?id=<?= $customer['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
