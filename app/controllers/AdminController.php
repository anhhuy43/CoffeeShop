<?php
require_once(__DIR__ . '/../config/database.php');
require_once(__DIR__ . '/../helpers/SessionHelper.php');

class AdminController 
{
    private $db;

    public function __construct() 
    {
        $this->db = (new Database())->getConnection();
    }

    public function statistics() 
    {
        // Check if user is admin
        if (!SessionHelper::isAdmin()) {
            header('Location: /DA_MaNguonMo/account/login');
            exit;
        }

        // Get total orders and revenue
        $query = "SELECT 
                    COUNT(DISTINCT o.id) as total_orders,
                    SUM(od.quantity * od.price) as total_revenue,
                    SUM(od.quantity) as total_quantity,
                    AVG(od.quantity * od.price) as avg_order_value
                 FROM orders o
                 JOIN order_details od ON o.id = od.order_id";
        $stmt = $this->db->query($query);
        $summary = $stmt->fetch(PDO::FETCH_OBJ);

        $totalOrders = $summary->total_orders;
        $totalRevenue = $summary->total_revenue;
        $totalQuantity = $summary->total_quantity;
        $averageOrderValue = $summary->avg_order_value;

        // Get top selling products
        $query = "SELECT 
                    p.name,
                    SUM(od.quantity) as total_quantity,
                    SUM(od.quantity * od.price) as total_revenue
                 FROM order_details od
                 JOIN product p ON od.product_id = p.id
                 GROUP BY p.id, p.name
                 ORDER BY total_quantity DESC
                 LIMIT 10";
        $stmt = $this->db->query($query);
        $topProducts = $stmt->fetchAll(PDO::FETCH_OBJ);

        // Get recent orders
        $query = "SELECT 
                    o.id as order_id,
                    o.name as customer_name,
                    o.created_at,
                    SUM(od.quantity) as total_quantity,
                    SUM(od.quantity * od.price) as total_amount
                 FROM orders o
                 JOIN order_details od ON o.id = od.order_id
                 GROUP BY o.id, o.name, o.created_at
                 ORDER BY o.created_at DESC
                 LIMIT 10";
        $stmt = $this->db->query($query);
        $recentOrders = $stmt->fetchAll(PDO::FETCH_OBJ);

        // Load the view
        require 'app/views/admin/statistics.php';
    }
}
