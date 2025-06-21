<?php
session_start();
include('../config/db.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Fetch vendor data from the database
$query = "SELECT * FROM vendors";
$vendors_result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Vendors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="text-center">Manage Vendors</h2>

    <a href="add_vendor.php" class="btn btn-success mb-3">Add New Vendor</a>

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
            <?php while ($vendor = mysqli_fetch_assoc($vendors_result)) : ?>
                <tr>
                    <td><?= $vendor['name'] ?></td>
                    <td><?= $vendor['email'] ?></td>
                    <td><?= $vendor['phone'] ?></td>
                    <td>
                        <a href="edit_vendor.php?id=<?= $vendor['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_vendor.php?id=<?= $vendor['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
