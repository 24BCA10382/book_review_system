<?php
$servername = "localhost";
$username = "root";  // default for XAMPP
$password = "";      // leave blank unless you set one
$database = "book_review_db"; // 👈🏽 replace with the exact name of your new database

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
