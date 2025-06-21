<?php
session_start();
include('../config/db.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $vendor_id = $_GET['id'];

    // Fetch vendor details from the database
    $query = "SELECT * FROM vendors WHERE id = '$vendor_id'";
    $result = mysqli_query($conn, $query);
    $vendor = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Update vendor details in the database
    $query = "UPDATE vendors SET name = '$name', email = '$email', phone = '$phone' WHERE id = '$vendor_id'";
    if (mysqli_query($conn, $query)) {
        header("Location: manage_vendors.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Vendor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="text-center">Edit Vendor</h2>

    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Vendor Name</label>
            <input type="text" name="name" class="form-control" value="<?= $vendor['name'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= $vendor['email'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="<?= $vendor['phone'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Vendor</button>
    </form>
</div>

</body>
</html>
