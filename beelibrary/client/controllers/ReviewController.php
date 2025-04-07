<?php

require_once __DIR__ . '/../models/Review.php';

class ReviewController
{
    public function addReview()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
            $book_id = $_POST['book_id'] ?? null;
            $user_id = $_SESSION['user_id'];
            $rating = $_POST['rating'] ?? null;
            $comment = trim($_POST['comment']);

            if ($book_id && $rating && $comment !== '') {
                $reviewModel = new Review();
                $reviewModel->addReview($book_id, $user_id, $rating, $comment);
                header("Location: " . BASE_URL . "index.php?controller=Home&action=productDetail&book_id=" . $book_id);
                exit();
            }
        }
        header("Location: " . BASE_URL . "index.php");
        exit();
    }
}