<?php
require_once dirname(__DIR__, 2) . '/commons/env.php';
require_once dirname(__DIR__, 2) . '/commons/function.php';
require_once dirname(__DIR__, 2) . '/client/models/Cart.php';

class CartController
{
    private $cartModel;

    public function __construct()
    {
        $this->cartModel = new Cart();
    }

    public function addToCart($params)
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "index.php?controller=User&action=login");
            exit();
        }
  
        $book_id = $params['book_id'];
        $quantity = $params['quantity'];
        $user_id = $_SESSION['user_id'];

        $cart = $this->cartModel->getCartByUserId($user_id);
        if ($cart) {
            $cart_id = $cart['cart_id'];
        } else {
            $cart_id = $this->cartModel->createCart($user_id);
        }

        $this->cartModel->addItemToCart($cart_id, $book_id, $quantity);
        header("Location: " . BASE_URL . "index.php?controller=Cart&action=viewCart");
    }

    public function viewCart()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "index.php?controller=User&action=login");
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $cart_items = $this->cartModel->getCartItemsByUserId($user_id);

        require_once dirname(__DIR__, 2) . '/client/views/cart.php';
    }
    public function index()
    {

        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "index.php?controller=User&action=login");
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $cart_items = $this->cartModel->getCartItemsByUserId($user_id);

        // Hiển thị trang giỏ hàng
        include __DIR__ . '/../views/cart.php';
    }
    public function remove()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "index.php?controller=User&action=login");
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $cartModel = new Cart();
        $cart = $cartModel->getCartByUserId($user_id);

        if ($cart && isset($_GET['id'])) {
            $cart_item_id = $_GET['id'];
            $cartModel->removeItemFromCart($cart_item_id);
        }

        header("Location: " . BASE_URL . "index.php?controller=Cart&action=viewCart");
        exit();
    }

    public function update()
    {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'User not logged in']);
            exit();
        }

        if (isset($_GET['id']) && isset($_GET['quantity'])) {
            $cart_item_id = $_GET['id'];
            $quantity = (int)$_GET['quantity'];

            // Đảm bảo số lượng không nhỏ hơn 1
            if ($quantity < 1) {
                $quantity = 1;
            }

            $this->cartModel->updateCartItemQuantity($cart_item_id, $quantity);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
        }
        exit();
    }
}
