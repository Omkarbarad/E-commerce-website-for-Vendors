<?php
include('../config/db.php');

$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check for duplicate email
    $check = mysqli_query($conn, "SELECT * FROM vendors WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Email already exists!";
    } else {
        $query = "INSERT INTO vendors (name, email, password) VALUES ('$name', '$email', '$password')";
        if (mysqli_query($conn, $query)) {
            $success = "Registration successful. You can now <a href='login.php'>login</a>.";
        } else {
            $error = "Something went wrong!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vendor Registration</title>
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

        .registration-container {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .registration-container h2 {
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

        .alert-success {
            background-color: #d4edda;
            color: #155724;
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

<div class="registration-container">
    <h2 class="text-center mb-4">Vendor Registration</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Register</button>
        <p>Already registered? <a href="login.php">Login here</a></p>
    </form>
</div>

</body>
</html>
