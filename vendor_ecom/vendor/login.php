<?php
session_start();
include('../config/db.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM vendors WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $vendor = mysqli_fetch_assoc($result);
        if (password_verify($password, $vendor['password'])) {
            $_SESSION['vendor_id'] = $vendor['id'];
            $_SESSION['vendor_name'] = $vendor['name'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid credentials!";
        }
    } else {
        $error = "Vendor not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vendor Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            font-family: 'Roboto', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            font-size: 2.2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 30px;
        }

        .form-control {
            border-radius: 25px;
            border: 1px solid #ddd;
            padding: 12px 20px;
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 5px rgba(99, 102, 241, 0.5);
        }

        .btn-primary {
            background-color: #6366f1;
            border-color: #6366f1;
            font-weight: 600;
            padding: 12px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #4f46e5;
            border-color: #4f46e5;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        }

        .alert {
            border-radius: 15px;
            padding: 10px;
            font-weight: 600;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        p {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        a {
            color: #6366f1;
            font-weight: 600;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2 class="text-center mb-4">Vendor Login</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
        <p>New here? <a href="register.php">Register as Vendor</a></p>
    </form>
</div>

</body>
</html>
