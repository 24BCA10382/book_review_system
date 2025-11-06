<?php
// connect.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "book_review_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $description = trim($_POST['description']);

    if (!empty($title) && !empty($author) && !empty($description)) {
        $stmt = $conn->prepare("INSERT INTO books (title, author, description) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $author, $description);
        if ($stmt->execute()) {
            $success = "Book added successfully!";
        } else {
            $error = "Error adding book: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Book - Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background-color: #fdf0fb;
    font-family: 'Segoe UI', sans-serif;
}
.form-container {
    background-color: #fff0f6;
    padding: 30px;
    border-radius: 20px;
    max-width: 500px;
    margin: auto;
    margin-top: 80px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
.btn-purple { background-color: #8e24aa; color: white; }
.btn-purple:hover { background-color: #6a1b9a; }
.message { text-align:center; color:green; margin-bottom:15px; }
.error { text-align:center; color:red; margin-bottom:15px; }
</style>
</head>
<body>

<div class="form-container">
    <h2 class="text-center mb-4">Add New Book</h2>

    <?php if(isset($success)) echo "<div class='message'>$success</div>"; ?>
    <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>

    <form action="add_book.php" method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Book Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="author" class="form-label">Author</label>
            <input type="text" class="form-control" id="author" name="author" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-purple w-100">Add Book</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
