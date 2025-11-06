# 📚 Book Review System

A **database-driven Book Review System** designed to manage books, reviews, ratings, and user comments efficiently. This project demonstrates the use of relational database concepts including table creation, primary and foreign keys, constraints, normalization, and SQL queries.

---

## 🧠 Problem Statement

Many book enthusiasts or small online book review platforms often rely on spreadsheets or manual tracking for books and user reviews. This approach can lead to:

- Data inconsistency and redundancy
- Difficulty tracking reviews and ratings
- No centralized view of books, user interactions, or feedback
- Lack of automated reporting for analytics

This system solves these issues by creating a **centralized relational database** to manage all book-related data while maintaining data integrity.

---

## 🎯 Project Objectives

1. Create a centralized database for books, reviews, ratings, and user comments.  
2. Ensure relationships between entities (books, users, reviews, ratings, comments) are properly maintained.  
3. Allow insertion, deletion, and retrieval of book data.  
4. Support querying and reporting for analytics like average ratings, review counts, and comment summaries.  
5. Provide a foundation for web or application integration in the future.

---

## 🧩 Database Design

The system uses a **relational schema** with the following tables:

### **1. Books**
- `id` (PK) – Unique identifier for each book  
- `title` – Book title  
- `author` – Book author  
- `review` – Book description or synopsis  
- `created_at` – Timestamp of book entry

### **2. Users**
- `user_id` (PK) – Unique identifier for each user  
- `username` – Name of the user  
- `email` – User email  
- `password` – User password (hashed in real applications)  
- `created_at` – Timestamp of account creation

### **3. Reviews**
- `review_id` (PK) – Unique review identifier  
- `book_id` (FK) – References `books.id`  
- `reviewer_name` – Name of the reviewer  
- `rating` – Rating (1-5 stars)  
- `comment` – Text review of the book  
- `review_date` – Timestamp of the review

### **4. Ratings**
- `rating_id` (PK) – Unique rating identifier  
- `book_id` (FK) – References `books.id`  
- `user_id` (FK) – References `users.user_id`  
- `rating` – Numeric rating between 1 and 5

### **5. Comments**
- `comment_id` (PK) – Unique comment identifier  
- `book_id` (FK) – References `books.id`  
- `user_id` (FK) – References `users.user_id`  
- `comment` – Text comment  
- `created_at` – Timestamp of comment

---

## 🧱 Relational Schema / ER Diagram

**Relationships:**
- **Books → Reviews**: 1-to-Many  
- **Books → Ratings**: 1-to-Many  
- **Books → Comments**: 1-to-Many  
- **Users → Ratings**: 1-to-Many  
- **Users → Comments**: 1-to-Many  

> The above structure ensures **data integrity** and avoids duplication.

---

## 🧰 Implementation Steps

### 1️⃣ Create Tables
All tables are created using `CREATE TABLE` statements with **primary keys, foreign keys, and constraints**.

### 2️⃣ Insert Sample Data
```sql
-- Books
INSERT INTO books (title, author, review) VALUES
('It Ends With Us', 'Colleen Hoover', 'A love story with emotional conflicts.'),
('It Starts With Us', 'Colleen Hoover', 'Sequel exploring relationships.');

-- Users
INSERT INTO users (username, email, password) VALUES
('Alice', 'alice@example.com', 'password123'),
('Bob', 'bob@example.com', 'password123'),
('Charlie', 'charlie@example.com', 'password123');

-- Reviews
INSERT INTO reviews (book_id, reviewer_name, rating, comment) VALUES
(1, 'Alice', 5, 'Loved it! So emotional.'),
(1, 'Bob', 4, 'Great read, a bit slow in the middle.'),
(2, 'Charlie', 5, 'Even better than the first book!');
