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

// Handle Add Book
if (isset($_POST['add_book'])) {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $description = trim($_POST['description']);
    if ($title && $author && $description) {
        $stmt = $conn->prepare("INSERT INTO books (title, author, description) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $author, $description);
        $stmt->execute();
        $stmt->close();
    }
}

// Handle Delete Book
if (isset($_GET['delete'])) {
    $book_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM books WHERE book_id=?");
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $stmt->close();
}

// Optional: View single book
$view_id = isset($_GET['view']) ? intval($_GET['view']) : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Book Review System</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background-color: #fffaf0; font-family: 'Segoe UI', sans-serif; padding: 20px; }
header { text-align:center; margin-bottom:20px; font-size:28px; color:#8a2be2; }
.book-card { background-color: #fff0f5; padding: 20px; margin-bottom: 15px; border-radius: 12px; box-shadow:0 4px 10px rgba(0,0,0,0.1);}
.book-card h3 { color: #5a189a; }
.book-card a { margin-right:10px; text-decoration:none; color:white; padding:6px 12px; border-radius:6px; background-color:#8a2be2; }
.book-card a:hover { background-color:#5a189a; }
.form-container { background-color: #fff0f6; padding:20px; border-radius:12px; margin-bottom:20px; box-shadow:0 4px 10px rgba(0,0,0,0.1);}
</style>
</head>
<body>
<header>📚 My Book Review System</header>

<div class="container">

<!-- Add Book Form -->
<div class="form-container">
    <h4>Add New Book</h4>
    <form method="POST">
        <input class="form-control mb-2" type="text" name="title" placeholder="Book Title" required>
        <input class="form-control mb-2" type="text" name="author" placeholder="Author" required>
        <textarea class="form-control mb-2" name="description" placeholder="Description" rows="3" required></textarea>
        <button class="btn btn-primary w-100" type="submit" name="add_book">Add Book</button>
    </form>
</div>

<?php
if ($view_id) {
    $stmt = $conn->prepare("SELECT * FROM books WHERE book_id=?");
    $stmt->bind_param("i", $view_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($book = $result->fetch_assoc()) {
        echo "<div class='book-card'>";
        echo "<h3>" . htmlspecialchars($book['title']) . "</h3>";
        echo "<p><strong>Author:</strong> " . htmlspecialchars($book['author']) . "</p>";
        echo "<p><strong>Description:</strong> " . htmlspecialchars($book['description']) . "</p>";
        echo "<a href='?'>Back</a>";
        echo "</div>";
    }
    $stmt->close();
} else {
    $result = $conn->query("SELECT * FROM books ORDER BY book_id DESC");
    if ($result->num_rows > 0) {
        while ($book = $result->fetch_assoc()) {
            echo "<div class='book-card'>";
            echo "<h3>" . htmlspecialchars($book['title']) . "</h3>";
            echo "<p><strong>Author:</strong> " . htmlspecialchars($book['author']) . "</p>";
            $desc = !empty($book['description']) ? htmlspecialchars($book['description']) : "No description";
            echo "<p><strong>Description:</strong> $desc</p>";
            echo "<a href='?view=".$book['book_id']."'>View</a>";
            echo "<a href='?delete=".$book['book_id']."' onclick=\"return confirm('Are you sure?')\">Delete</a>";
            echo "</div>";
        }
    } else {
        echo "<p class='text-center'>No books found.</p>";
    }
}
$conn->close();
?>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
