<?php

class BookController
{
    public $bookQuery;
    public $Category;


    public function __construct()
    {
        $this->bookQuery = new BookQuery();
        $this->Category = new AdminDanhMuc();
    }

    public function __destruct() {}

    public function showList()
    {
        $bookList = $this->bookQuery->all();
        require_once "./view/book/listSach.php";
    }

    public function showCreate()
    {
        $book = new Book();
        $thongBaoLoi = "";
        $thongBaoThanhCong = "";
        $listDanhMuc = $this->Category->getAllDanhMuc();


        if (isset($_POST["submitForm"])) {
            $book->category_id = trim($_POST["category_id"]);
            $book->title = trim($_POST["title"]);
            $book->author = trim($_POST["author"]);
            $book->description = trim($_POST["description"]);
            $book->price = trim($_POST["price"]);
            $book->stock = trim($_POST["stock"]);
            $book->published_date = trim($_POST["published_date"]);

            if ($book->title === "" || $book->author === "" || $book->description === "" || $book->price === "" || $book->stock === "" || $book->published_date === "") {
                $thongBaoLoi = "Hãy nhập đầy đủ thông tin";
            }

            // Xử lý upload file
            if (!empty($_FILES["file_upload"]["tmp_name"])) {
                $uploadDir = __DIR__ . "/../upload/"; // Lùi một cấp ra khỏi controller để đến admin/upload/
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileName = basename($_FILES["file_upload"]["name"]);
                $filePath = $uploadDir . $fileName;

                // Kiểm tra định dạng file hợp lệ
                $allowedTypes = ["image/jpeg", "image/png", "image/gif"];
                $fileType = mime_content_type($_FILES["file_upload"]["tmp_name"]);

                if (!in_array($fileType, $allowedTypes)) {
                    $thongBaoLoi = "Chỉ cho phép tải lên file ảnh (JPG, PNG, GIF)";
                } else {
                    if (move_uploaded_file($_FILES["file_upload"]["tmp_name"], $filePath)) {
                        $book->image = "upload/" . $fileName;
                    } else {
                        $thongBaoLoi = "Kết nối file thất bại";
                    }
                }
            }
           

            if ($thongBaoLoi === "") {
                $dataCreate = $this->bookQuery->insert($book);

                if ($dataCreate === "ok") {
                    header("Location: ?act=list-book");
                    exit();
                }
            }
        }
        include "./view/book/create.php";
    }

    public function showDetail($id)
    {
        if ($id !== "") {
            $book = $this->bookQuery->find($id);
            include "./view/book/detail.php";
        } else {
            echo "Lỗi: Không nhận được thông tin ID. Mời bạn kiểm tra lại. <hr>";
        }
    }

    public function showUpdate($id)
    {
        if ($id !== "") {
            $book = $this->bookQuery->find($id);
            $thongBaoLoi = "";
            $thongBaoThanhCong = "";
            $listDanhMuc = $this->Category->getAllDanhMuc();


            if (isset($_POST["submitForm"])) {
                $book->title = trim($_POST["title"]);
                $book->author = trim($_POST["author"]);
                $book->description = trim($_POST["description"]);
                $book->price = trim($_POST["price"]);
                $book->stock = trim($_POST["stock"]);
                $book->published_date = trim($_POST["published_date"]);
                $oldImage = $_POST["image"] ?? ""; // Nếu không có ảnh cũ, gán chuỗi rỗng


                if (isset($_FILES["file_upload"]) && $_FILES["file_upload"]["error"] === UPLOAD_ERR_OK) {
                    $uploadDir = __DIR__ . "/../upload/"; // Lưu vào thư mục admin/upload/

                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true); // Tạo thư mục nếu chưa có
                    }

                    $fileName = basename($_FILES["file_upload"]["name"]);
                    $filePath = $uploadDir . $fileName;

                    // Kiểm tra định dạng file hợp lệ
                    $allowedTypes = ["image/jpeg", "image/png", "image/gif"];
                    $fileType = mime_content_type($_FILES["file_upload"]["tmp_name"]);

                    if (!in_array($fileType, $allowedTypes)) {
                        $thongBaoLoi = "Chỉ cho phép tải lên file ảnh (JPG, PNG, GIF)";
                    } else {
                        if (move_uploaded_file($_FILES["file_upload"]["tmp_name"], $filePath)) {
                            // Nếu upload thành công, cập nhật ảnh mới
                            $book->image = "upload/" . $fileName;
                            // Nếu có ảnh cũ, xóa ảnh cũ để tránh rác
                            if (!empty($oldImage) && file_exists(__DIR__ . "/../" . $oldImage)) {
                                unlink(__DIR__ . "/../" . $oldImage);
                            }
                        } else {
                            $thongBaoLoi = "Lưu file thất bại.";
                        }
                    }
                } else {
                    // Nếu không có ảnh mới, giữ nguyên ảnh cũ
                    $book->image = $oldImage;
                }


                if ($book->title === "" || $book->author === "" || $book->description === "" || $book->price === "" || $book->stock === "" || $book->published_date === "") {
                    $thongBaoLoi = "Tiêu đề, Tác giả, Giá, và Ngày xuất bản là bắt buộc. Hãy nhập đầy đủ.";
                }

                if ($thongBaoLoi === "") {
                    $dataUpdate = $this->bookQuery->update($id, $book);

                    if ($dataUpdate) {
                        header("Location: ?act=list-book");
                        exit();
                    }
                }
            }
            include "./view/book/update.php";
        } else {
            echo "Lỗi: Không nhận được thông tin ID. Mời bạn kiểm tra lại. <hr>";
        }
    }

    public function delete($id)
    {
        if ($id !== "") {
            $dataDelete = $this->bookQuery->delete($id);
            if ($dataDelete === "success") {
                header("Location: ?act=list-book");
            }
        } else {
            echo "Lỗi thông tin ID trống, hãy kiểm tra lại";
        }
    }
}
//ABCcccccc