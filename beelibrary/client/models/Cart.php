<?php
require_once dirname(__DIR__, 2) . '/commons/env.php';
require_once dirname(__DIR__, 2) . '/commons/function.php';

class Cart {
    private $db;

    public function __construct() {
        $this->db = connectDB();
    }

    public function getCartByUserId($user_id) {
        $query = "SELECT cart_id FROM cart WHERE user_id = :user_id AND status = 'pending'";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getCartItemByBookId($cart_id, $book_id) {
        $query = "SELECT id, quantity FROM cart_item WHERE cart_id = :cart_id AND book_id = :book_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cart_id', $cart_id);
        $stmt->bindValue(':book_id', $book_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createCart($user_id) {
        $query = "INSERT INTO cart (user_id, status, created_at) VALUES (:user_id, 'pending', NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function addItemToCart($cart_id, $book_id, $quantity) {
        $query = "INSERT INTO cart_item (cart_id, book_id, quantity, price) VALUES (:cart_id, :book_id, :quantity, (SELECT price FROM books WHERE book_id = :book_id))";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cart_id', $cart_id);
        $stmt->bindValue(':book_id', $book_id);
        $stmt->bindValue(':quantity', $quantity);
        $stmt->execute();
    }

    public function getCartItemsByUserId($user_id) {
        $query = "SELECT ci.id, ci.book_id, p.title, p.image, ci.quantity, ci.price FROM cart_item ci
          JOIN cart c ON ci.cart_id = c.cart_id
          JOIN books p ON ci.book_id = p.book_id
          WHERE c.user_id = :user_id AND c.status = 'pending'";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function completeCart($cart_id) {
        $query = "UPDATE cart SET status = 'completed' WHERE cart_id = :cart_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cart_id', $cart_id);
        $stmt->execute();
    }
    public function removeItemFromCart($cart_item_id) {
        $query = "DELETE FROM cart_item WHERE id = :cart_item_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cart_item_id', $cart_item_id);
        $stmt->execute();
    }

    public function updateCartItemQuantity($cart_item_id, $quantity) {
        $query = "UPDATE cart_item SET quantity = :quantity WHERE id = :cart_item_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':cart_item_id', $cart_item_id);
        $stmt->bindValue(':quantity', $quantity);
        $stmt->execute();
    }
    
}
?>
