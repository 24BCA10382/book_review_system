<?php
include 'connect.php'; // your DB connection file

// 1️⃣ Get book ID safely
if (isset($_GET['book_id']) && is_numeric($_GET['book_id'])) {
    $book_id = $_GET['book_id'];
} else {
    die("Invalid book ID!");
}

// 2️⃣ Fetch book info
$book_sql = "SELECT * FROM books WHERE book_id = $book_id";
$book_result = $conn->query($book_sql);

if ($book_result && $book_result->num_rows > 0) {
    $book = $book_result->fetch_assoc();
} else {
    die("Book not found!");
}

// 3️⃣ Handle review submission safely
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reviewer_name = $_POST['reviewer_name'];
    $review_text = $_POST['review_text'];
    $rating = $_POST['rating'];

    $stmt = $conn->prepare("INSERT INTO reviews (book_id, reviewer_name, review_text, rating) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issi", $book_id, $reviewer_name, $review_text, $rating);

    if ($stmt->execute()) {
        echo "<script>alert('Review added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding review: " . $stmt->error . "');</script>";
    }
}

// 4️⃣ Fetch reviews for this book
$reviews_sql = "SELECT * FROM reviews WHERE book_id = $book_id ORDER BY review_date DESC";
$reviews = $conn->query($reviews_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review - <?php echo htmlspecialchars($book['title']); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container review-page">
    <h1>📖 Review for "<?php echo htmlspecialchars($book['title']); ?>"</h1>
    <p class="author">by <?php echo htmlspecialchars($book['author']); ?></p>

    <form method="POST" class="review-form">
        <input type="text" name="reviewer_name" placeholder="Your name..." required>
        <textarea name="review_text" rows="4" placeholder="Write your review..." required></textarea>

        <label>Rating:</label>
        <div class="rating">
            <input type="radio" name="rating" value="5" required> ⭐⭐⭐⭐⭐
            <input type="radio" name="rating" value="4"> ⭐⭐⭐⭐
            <input type="radio" name="rating" value="3"> ⭐⭐⭐
            <input type="radio" name="rating" value="2"> ⭐⭐
            <input type="radio" name="rating" value="1"> ⭐
        </div>

        <button type="submit" class="btn">Submit Review 💌</button>
    </form>

    <hr>

    <h2>💬 What others said:</h2>
    <div class="reviews-list">
        <?php
        if ($reviews->num_rows > 0) {
            while($row = $reviews->fetch_assoc()) {
                echo "<div class='review-card'>";
                echo "<h3>" . htmlspecialchars($row['reviewer_name']) . "</h3>";
                echo "<p class='stars'>" . str_repeat('⭐', $row['rating']) . "</p>";
                echo "<p class='text'>" . htmlspecialchars($row['review_text']) . "</p>";
                echo "<p class='date'>Posted on " . $row['review_date'] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p class='no-reviews'>No reviews yet 🕯️ Be the first to share your thoughts!</p>";
        }
        ?>
    </div>

    <a href="view_books.php" class="btn-secondary">← Back to Books</a>
</div>
</body>
</html>
