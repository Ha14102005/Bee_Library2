<?php
class AdminDonHang
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getAllDonHang()
    {
        try {
            $sql = 'SELECT orders.*,order_status.status_name
                    FROM orders
                    INNER JOIN order_status ON orders.status_id=order_status.status_id
                ';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo 'lỗi' . $e->getMessage();
        }
    }

    public function getDetailDonHang($id)
    {
        try {
            $sql = 'SELECT orders.*,order_status.status_name,users.*
                    FROM orders
                    INNER JOIN order_status ON orders.status_id=order_status.status_id
                    INNER JOIN users ON orders.user_id=users.user_id
                    WHERE order_id =:id
                    ';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute(
                [
                    ':id' => $id
                ]
            );
            return $stmt->fetch();
        } catch (Exception $e) {
            echo 'lỗi' . $e->getMessage();
        }
    }
    public function getStatusDonHang()
    {
        try {
            $sql = 'SELECT * FROM order_status';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo 'lỗi' . $e->getMessage();
        }
    }
    public function getProductDonHang($id)
    {
        try {
            $sql = 'SELECT order_items.*, books.title, books.price,books.image
                FROM order_items
                INNER JOIN books ON order_items.book_id = books.book_id
                WHERE order_items.order_item_id = :id';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':id' => $id
            ]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo 'lỗi ' . $e->getMessage();
            return []; // Trả về mảng rỗng để tránh lỗi khi không có dữ liệu
        }
    }

    public function updateDonHang($id, $name, $phone, $email, $address, $status)
    {
        try {
            $sql = 'UPDATE orders SET `recipient_name`=:ten,`recipient_email`=:mail,`recipient_phone`=:dienthoai,`recipient_address`=:diachi,`status_id`=:trangthai WHERE `order_id`=:id';


            $stmt = $this->conn->prepare($sql);

            $stmt->execute(
                [
                    ':ten' => $name,
                    ':dienthoai' => $phone,
                    ':mail' => $email,
                    ':diachi' => $address,
                    ':id' => $id,
                    ':trangthai' => $status
                ]
            );
            return true;
        } catch (Exception $e) {
            echo 'lỗi' . $e->getMessage();
        }
    }
    public function deleteDonHang($id)
    {
        try {
            $sql = 'DELETE FROM orders WHERE order_id =:id';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute(
                [
                    ':id' => $id
                ]
            );
            return true;
        } catch (Exception $e) {
            echo 'lỗi' . $e->getMessage();
        }
    }
    public function getAllComments()
{
    try {
        $sql = "SELECT 
                    r.review_id AS comment_id, 
                    r.comment, 
                    r.rating, 
                    r.review_date, 
                    u.username AS user_name, 
                    b.title AS book_title
                FROM 
                    reviews r
                JOIN 
                    users u ON r.user_id = u.user_id
                JOIN 
                    books b ON r.book_id = b.book_id
                ORDER BY 
                    r.review_date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về danh sách bình luận
    } catch (Exception $e) {
        echo 'Lỗi: ' . $e->getMessage();
        return [];
    }
}

// filepath: c:\laragon\www\AGILE\DUAN2\beelibrary\admin\model\Order.php
public function deleteComment($id) {
    try {
        $sql = "DELETE FROM reviews WHERE review_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Gắn tham số :id với giá trị $id
        $stmt->execute();
        return true;
    } catch (Exception $e) {
        echo 'Lỗi: ' . $e->getMessage();
        return false;
    }
}
}
