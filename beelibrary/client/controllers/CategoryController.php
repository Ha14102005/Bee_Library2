<?php
require_once dirname(__DIR__, 2) . '/commons/env.php';
require_once dirname(__DIR__, 2) . '/commons/function.php';

class CategoryController {
    private $db;

    public function __construct() {
        $this->db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ($this->db->connect_error) {
            die("Kết nối cơ sở dữ liệu thất bại: " . $this->db->connect_error);
        }
    }

    public function list($params) {
        if (!isset($params['category_id']) || !is_numeric($params['category_id'])) {
            die("Danh mục không hợp lệ!");
        }
        $category_id = intval($params['category_id']);
    
        $stmt = $this->db->prepare("SELECT book_id, title, author, price, stock, image FROM books WHERE category_id = ?");
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $books = $result->fetch_all(MYSQLI_ASSOC); // Đổi $products thành $books
        $stmt->close();
    
        include_once __DIR__ . "/../views/category.php";
    }
}
?>