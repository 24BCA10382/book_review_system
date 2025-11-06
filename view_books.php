<?php
// Connect to database
$connection = new mysqli("localhost", "root", "", "book_review_db");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch books
$sql = "SELECT * FROM books";
$result = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book List</title>
    <style>
        body {
            background-color: #fffaf0; /* soft pastel background */
            font-family: 'Georgia', serif;
            color: #333;
            padding: 40px;
        }

        h1 {
            color: #6b3fa0; /* purple aesthetic */
            text-align: center;
            margin-bottom: 30px;
        }

        .book {
            background-color: #fff0f5; /* soft pinkish card */
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }

        .book:hover {
            transform: scale(1.02);
        }

        .book h2 {
            margin: 0;
            color: #4b0082; /* deep purple */
        }

        .book p {
            font-size: 15px;
            line-height: 1.6;
        }

        .book .author {
            font-style: italic;
            color: #8b008b;
        }
    </style>
</head>
<body>

<h1>Our Book Collection</h1>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $title = isset($row['title']) ? $row['title'] : "Untitled Book";
        $author = isset($row['author']) ? $row['author'] : "Unknown Author";
        $description = isset($row['description']) && !empty($row['description']) ? $row['description'] : "No description available.";
        ?>

        <div class="book">
            <h2><?php echo htmlspecialchars($title); ?></h2>
            <p class="author">Author: <?php echo htmlspecialchars($author); ?></p>
            <p><?php echo htmlspecialchars($description); ?></p>
        </div>

        <?php
    }
} else {
    echo "<p>No books found.</p>";
}

$connection->close();
?>

</body>
</html>
