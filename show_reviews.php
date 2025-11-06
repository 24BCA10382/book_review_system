<?php include 'db.php';
$book_id = isset($_GET['book_id']) ? (int)$_GET['book_id'] : 0;
$book = $conn->query("SELECT * FROM books WHERE id = $book_id")->fetch_assoc();
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Reviews</title></head>
<body>
  <h2>Reviews for <?php echo htmlspecialchars($book['title'] ?? 'Unknown'); ?></h2>
  <?php
  $res = $conn->query("SELECT * FROM reviews WHERE book_id = $book_id ORDER BY id DESC");
  if ($res->num_rows == 0) echo "<p>No reviews yet.</p>";
  while ($r = $res->fetch_assoc()) {
    echo "<div style='border:1px solid #ddd; padding:8px; margin:8px 0;'>";
    echo "<p><strong>" . htmlspecialchars($r['reviewer_name']) . "</strong> (" . $r['rating'] . "/5)</p>";
    echo "<p>" . nl2br(htmlspecialchars($r['review_text'])) . "</p>";
    echo "</div>";
  }
  ?>
  <p><a href="view_books.php">Back to books</a></p>
</body>
</html>
