<?php
$conn = mysqli_connect("localhost", "root", "", "vendor_ecom_db");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = isset($_GET['query']) ? $_GET['query'] : '';

// Query to fetch products based on search query
if ($query != '') {
    $product_query = mysqli_query($conn, "SELECT * FROM products WHERE title LIKE '%$query%' OR description LIKE '%$query%'");
} else {
    $product_query = mysqli_query($conn, "SELECT * FROM products");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Vendor E-Commerce - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Roboto', sans-serif;
    }
    .navbar {
      background-color: #111827;
      border-bottom: 2px solid #6366f1;
    }
    .navbar-brand, .nav-link, .dropdown-item {
      color: #f9fafb !important;
      font-weight: 500;
    }
    .navbar-toggler {
      border-color: #6366f1;
    }
    .navbar-toggler-icon {
      background-color: #6366f1;
    }
    .dropdown-menu {
      background-color: #1f2937;
    }
    .dropdown-item:hover {
      background-color: #374151;
    }
    .hero-section {
      padding: 100px 0;
      background: linear-gradient(135deg, #4f46e5, #6366f1);
      color: white;
      text-align: center;
      transition: all 0.3s ease;
    }
    .hero-section h1 {
      font-size: 3.5rem;
      font-weight: bold;
      text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.4);
    }
    .hero-section p {
      font-size: 1.3rem;
      margin-top: 15px;
    }
    .btn-light {
      background-color: #f0f2f5;
      color: #111827;
      padding: 10px 25px;
      border-radius: 30px;
      font-weight: 600;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }
    .btn-light:hover {
      background-color: #6366f1;
      color: #fff;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }
    .product-card img {
      height: 300px;
      width: 300px;
      object-fit: cover;
      transition: transform 0.3s ease;
    }
    .product-card img:hover {
      transform: scale(1.1);
    }
    .product-card {
      border: none;
      height: 400x;
      width: 300px;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      transition: all 0.3s ease;
    }
    .product-card:hover {
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      transform: translateY(-5px);
    }
    .scroll-down {
      text-align: center;
      margin-top: 20px;
    }
    .scroll-down a {
      font-size: 1.5rem;
      color: #6366f1;
      text-decoration: none;
      transition: color 0.3s ease;
    }
    .scroll-down a:hover {
      color: #4f46e5;
    }
    .about-section {
      padding: 80px 20px;
      background-color: #f8f9fa;
      text-align: center;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
      margin-top: 40px;
    }
    .about-section h2 {
      font-size: 2.5rem;
      font-weight: 600;
      margin-bottom: 20px;
    }
    .about-section p {
      font-size: 1.1rem;
      color: #4b5563;
    }
    .about-section .btn {
      background-color: #6366f1;
      color: white;
      padding: 12px 30px;
      border-radius: 30px;
      font-weight: 600;
    }
    .about-section .btn:hover {
      background-color: #4f46e5;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">Vendor E-Com</a>
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">

        <!-- Login Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Login</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="customer/login.php">Customer Login</a></li>
            <li><a class="dropdown-item" href="vendor/login.php">Vendor Login</a></li>
          </ul>
        </li>

        <!-- Signup Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Sign Up</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="customer/register.php">Customer Sign Up</a></li>
            <li><a class="dropdown-item" href="vendor/register.php">Vendor Sign Up</a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#products">Products</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="#about">About</a>
        </li>

      </ul>
    </div>
  </div>
</nav>

<section class="hero-section">
  <div class="container">
    <h1>Connect Vendors with Customers</h1>
    <p>Empowering small businesses to reach global markets</p>

    <!-- Search Bar -->
    <form action="#" method="GET" class="d-flex justify-content-center mt-4">
      <input type="text" name="query" class="form-control w-50" placeholder="Search for products...">
      <button type="submit" class="btn btn-light ms-3">Search</button>
    </form>
  </div>
</section>


<div class="container mt-5" id="products">
  <h3 class="text-center mb-4">Featured Products</h3>
  <div class="row">


    <!-- Dynamic Product Cards -->
    <?php
    if (mysqli_num_rows($product_query) > 0) {
        while ($row = mysqli_fetch_assoc($product_query)) {
    ?>
        <div class="col-md-4 mb-4">
          <div class="card product-card shadow">
            <img src="<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="Product Image">
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
              <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
              <p class="card-text fw-bold">Price: ₹<?php echo htmlspecialchars($row['price']); ?></p>
              <button class="btn btn-success w-100" onclick = "window.location.href='/VENDOR_ECOM/customer/login.php';"">Add to Cart</button>
            </div>
          </div>
        </div>
    <?php
        }
    } else {
        echo "<p class='text-center'>No products found for your search query.</p>";
    }
    ?>


  </div>
</div>

<section class="about-section" id="about">
  <div class="container">
    <h2>About Vendor E-Com</h2>
    <p class="lead mt-3">
      We aim to provide a global platform for small vendors to showcase and sell their products to the world. With secure logins, vendor dashboards, and a seamless shopping experience, we support the growth of local businesses through technology.
    </p>
    <a href="#products" class="btn">Learn More</a>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
