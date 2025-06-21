<?php
$host = 'localhost';
$user = 'root';
$password = ''; // use your own password if set
$db = 'vendor_ecom_db';

$conn = mysqli_connect($host, $user, $password, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
