<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['vendor_id'])) {
    header("Location: login.php");
    exit();
}

$vendor_id = $_SESSION['vendor_id'];
$success = $error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $discount = intval($_POST['discount']);
    $quantity = intval($_POST['quantity']);

    // Image upload
    $image = $_FILES['image']['name'];
    $target = "../uploads/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $query = "INSERT INTO products (vendor_id, title, description, price, discount, quantity, image) 
                  VALUES ('$vendor_id', '$title', '$desc', '$price', '$discount', '$quantity', 'uploads/$image')";
        if (mysqli_query($conn, $query)) {
            $success = "Product added successfully!";
        } else {
            $error = "Database error.";
        }
    } else {
        $error = "Image upload failed.";
    }
}

// Fetch vendor products
$products = mysqli_query($conn, "SELECT * FROM products WHERE vendor_id='$vendor_id'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vendor Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
body {
    background: #f5f7fa;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    padding-bottom: 40px;
}

h2 {
    font-weight: 600;
    color: #333;
    margin-bottom: 30px;
}

.card {
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    padding: 20px;
}

.card-header {
    background-color: #007bff;
    color: white;
    font-weight: 500;
    font-size: 1.1rem;
    border-radius: 10px 10px 0 0;
    padding: 15px 20px;
}

.card-body {
    padding: 25px;
}

.card-body label {
    font-weight: 500;
    margin-bottom: 6px;
}

.card-body input,
.card-body textarea {
    border-radius: 8px;
    border: 1px solid #ced4da;
    padding: 12px;
    font-size: 15px;
}

.card-body input:focus,
.card-body textarea:focus {
    border-color: #007bff;
    box-shadow: none;
    outline: none;
}

.btn-success {
    background-color: #28a745;
    border: none;
    font-weight: 600;
    font-size: 16px;
    padding: 12px 20px;
    border-radius: 10px;
    transition: background-color 0.2s ease-in-out;
    margin-top: 20px;
}

.btn-success:hover {
    background-color: #218838;
}

.alert {
    border-radius: 8px;
    padding: 15px 20px;
    font-size: 15px;
}

.table {
    background-color: white;
    border-radius: 10px;
    overflow: hidden;
    margin-top: 30px;
}

.table th, .table td {
    vertical-align: middle !important;
    text-align: center;
    padding: 15px;
    font-size: 15px;
}

.table img {
    border-radius: 8px;
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
}

.btn-danger {
    background-color: #dc3545;
    border: none;
    font-weight: 600;
    font-size: 16px;
    padding: 12px 20px;
    border-radius: 10px;
    margin-top: 30px;
}

.btn-danger:hover {
    background-color: #c82333;
}

</style>

<body class="bg-light">
<div class="container mt-4">
    <h2 class="mb-4">Welcome, <?= $_SESSION['vendor_name'] ?> 👋</h2>

    <?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
    <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>

    <!-- Add Product Form -->
    <div class="card mb-4">
        <div class="card-header">Add New Product</div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Product Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Price ($)</label>
                        <input type="number" name="price" class="form-control" step="0.01" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Discount (%)</label>
                        <input type="number" name="discount" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" class="form-control" required>
                    </div>
                </div>
                <button class="btn btn-success mt-3 w-100">Add Product</button>
            </form>
        </div>
    </div>

    <!-- Product List -->
    <h4>Your Products</h4>
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Price ($)</th>
                <th>Discount (%)</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($p = mysqli_fetch_assoc($products)) : ?>
                <tr>
                    <td><img src="../<?= $p['image'] ?>" width="80"></td>
                    <td><?= $p['title'] ?></td>
                    <td><?= $p['price'] ?></td>
                    <td><?= $p['discount'] ?></td>
                    <td><?= $p['quantity'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="../index.php" class="btn btn-danger mt-3">Logout</a>
</div>
</body>
</html>
