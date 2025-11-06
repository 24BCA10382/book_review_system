-- 1. List all books with average rating
SELECT b.title, b.author, AVG(r.rating) AS avg_rating
FROM books b
LEFT JOIN ratings r ON b.id = r.book_id
GROUP BY b.id;

-- 2. Show reviews with book title
SELECT b.title, rv.reviewer_name, rv.rating, rv.comment
FROM reviews rv
JOIN books b ON rv.book_id = b.id
ORDER BY rv.review_date DESC;

-- 3. Count number of comments per book
SELECT b.title, COUNT(c.comment_id) AS total_comments
FROM books b
LEFT JOIN comments c ON b.id = c.book_id
GROUP BY b.id;
