<?php

require_once dirname(__DIR__, 2) . '/commons/env.php';
require_once dirname(__DIR__, 2) . '/commons/function.php';

class Review
{
    private $db;

    public function __construct()
    {
        $this->db = connectDB();
    }

    public function addReview($book_id, $user_id, $rating, $comment)
    {
        $sql = "INSERT INTO reviews (book_id, user_id, rating, comment) VALUES (:book_id, :user_id, :rating, :comment)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':book_id' => $book_id,
            ':user_id' => $user_id,
            ':rating' => $rating,
            ':comment' => $comment
        ]);
    }

    public function getReviewsByBookId($book_id)
    {
        $sql = "SELECT r.rating, r.comment, r.review_date, u.username AS user_name
                FROM reviews r
                JOIN users u ON r.user_id = u.id
                WHERE r.book_id = :book_id
                ORDER BY r.review_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':book_id' => $book_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}