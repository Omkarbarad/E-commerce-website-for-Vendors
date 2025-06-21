<?php
session_start();

if (!isset($_SESSION['customer_id'])) {
    header("Location: ../customer/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Initialize cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // If product already in cart, update quantity
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }

    $_SESSION['cart_message'] = "Product added to your cart successfully!";

    header("Location: ../products/index.php");
    exit();
} else {
    header("Location: ../products/index.php");
    exit();
}
