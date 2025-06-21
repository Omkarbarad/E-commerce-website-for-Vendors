<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta http-equiv="refresh" content="5;url=../products/index.php"> <!-- Auto-redirect to product page after 5 seconds -->
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="text-center mb-4">Payment Successful!</h2>

    <div class="alert alert-success text-center" role="alert">
        <h4>Your payment has been successfully processed. Thank you for your purchase!</h4>
        <p>You will be redirected to the product page shortly, or you can <a href="../products/index.php">click here</a> to go back to shopping.</p>
    </div>

    <div class="text-center">
        <a href="../products/index.php" class="btn btn-primary">Continue Shopping</a>
    </div>
</div>

</body>
</html>
