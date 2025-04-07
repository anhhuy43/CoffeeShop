<?php
require_once(__DIR__ . '/../models/OrderModel.php');
require_once(__DIR__ . '/../helpers/SessionHelper.php');
require_once(__DIR__ . '/../config/Database.php');

class AdminOrderController {
    private $orderModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->orderModel = new OrderModel($this->db);
    }

    public function index() {
        if (!SessionHelper::isAdmin()) {
            header('Location: /DA_MaNguonMo/account/login');
            exit;
        }

        $orders = $this->orderModel->getAllOrders();
        require 'app/views/admin/orders/index.php';
    }

    public function details($id) {
        if (!SessionHelper::isAdmin()) {
            header('Location: /DA_MaNguonMo/account/login');
            exit;
        }

        $orderDetails = $this->orderModel->getOrderDetails($id);
        require 'app/views/admin/orders/details.php';
    }
}
?>
