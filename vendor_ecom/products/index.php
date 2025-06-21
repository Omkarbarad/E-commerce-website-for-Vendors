<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['customer_id'])) {
    header("Location: ../customer/login.php");
    exit();
}

// Handle Search Query
$search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// If search query exists, fetch products based on search, else fetch all products
if ($search_query) {
    $products = mysqli_query($conn, "SELECT * FROM products WHERE title LIKE '%$search_query%' OR description LIKE '%$search_query%'");
} else {
    $products = mysqli_query($conn, "SELECT * FROM products");
}

// Get cart message if available
$cart_message = isset($_SESSION['cart_message']) ? $_SESSION['cart_message'] : '';
unset($_SESSION['cart_message']); // Clear the message after displaying it
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">

    <!-- Show Success Message if Product Added to Cart -->
    <?php if ($cart_message): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $cart_message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <h2 class="mb-4 text-center">Welcome, <?= $_SESSION['customer_name'] ?> 👋</h2>
    <h4 class="mb-4 text-center">Explore Products</h4>

    <!-- Search Form -->
    <form method="GET" action="" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search products..." value="<?= htmlspecialchars($search_query) ?>" required>
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($products)) : ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="../<?= $row['image'] ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?= $row['title'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['title'] ?></h5>
                        <p class="card-text"><?= $row['description'] ?></p>
                        <p>
                            <strong>Price: </strong> $<?= $row['price'] ?><br>
                            <strong>Discount: </strong> <?= $row['discount'] ?>%<br>
                            <strong>Quantity: </strong> <?= $row['quantity'] ?>
                        </p>

                        <form method="POST" action="../cart/add_to_cart.php">
                            <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-success w-100">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <a href="../cart/view_cart.php" class="btn btn-warning mt-3">🛒 View Cart</a>
    <a href="../index.php" class="btn btn-danger mt-3 float-end">Logout</a>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
