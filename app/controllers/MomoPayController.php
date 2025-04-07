<?php
require_once(__DIR__ . '/../config/database.php');
require_once(__DIR__ . '/../models/OrderModel.php');

class MomoPayController {
    private $orderModel;
    private $db;

    public function __construct() {
        if (!isset($_SESSION['last_order_id']) || !isset($_SESSION['total_amount'])) {
            header('Location: /DA_MaNguonMo/Product/cart');
            exit;
        }
        
        $this->db = (new Database())->getConnection();
        $this->orderModel = new OrderModel($this->db);
    }

    public function index() {
        $data = [
            'order_id' => $_SESSION['last_order_id'],
            'total_amount' => $_SESSION['total_amount']
        ];
        
        require 'app/views/product/momopay.php';
    }

    public function processPayment() {
        if (!isset($_SESSION['last_order_id']) || !isset($_SESSION['total_amount'])) {
            header('Location: /DA_MaNguonMo/Product/cart');
            exit;
        }

        // Process successful payment
        $_SESSION['payment_success'] = true;
        
        // Clean up session variables
        unset($_SESSION['last_order_id']);
        unset($_SESSION['total_amount']);

        // Redirect to success page
        header('Location: /DA_MaNguonMo/Product');
        exit;
    }
}
?>
