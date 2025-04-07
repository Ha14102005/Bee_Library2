<?php

class CommentController {
    public $commentModel;

    public function __construct() {
        $this->commentModel = new AdminDonHang(); // Model xử lý bình luận
    }

    // Hiển thị danh sách bình luận
    public function listComments() {
        $comments = $this->commentModel->getAllComments(); // Lấy tất cả bình luận
        require_once './view/comment/list.php'; // Gọi view hiển thị danh sách bình luận
    }

    // Xóa bình luận
    public function deleteComment() {
        if (isset($_GET['id_comment'])) {
            $id = $_GET['id_comment']; // Lấy ID bình luận từ URL
            $this->commentModel->deleteComment($id); // Gọi model để xóa bình luận
            header('location: ' . BASE_URL_ADMIN . '?act=binh-luan'); // Quay lại danh sách bình luận
            exit();
        } else {
            header('location: ' . BASE_URL_ADMIN . '?act=binh-luan'); // Nếu không có ID, quay lại danh sách
            exit();
        }
    }
}
?>