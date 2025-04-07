<?php
class OrderModel {
    private $conn;
    private $table_name = "orders";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createOrder($orderData, $orderDetails) {
        try {
            $this->conn->beginTransaction();
            
            // Thêm đơn hàng mới
            $sql = "INSERT INTO orders (name, phone, email, address, note, total_amount, status) 
                   VALUES (:name, :phone, :email, :address, :note, :total_amount, :status)";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':name' => $orderData['name'],
                ':phone' => $orderData['phone'],
                ':email' => $orderData['email'],
                ':address' => $orderData['address'],
                ':note' => $orderData['note'],
                ':total_amount' => $orderData['total_amount'],
                ':status' => 'pending'
            ]);
            
            $orderId = $this->conn->lastInsertId();
            
            // Thêm chi tiết đơn hàng
            $sql = "INSERT INTO order_details (order_id, product_id, quantity, price) 
                   VALUES (:order_id, :product_id, :quantity, :price)";
            
            $stmt = $this->conn->prepare($sql);
            
            foreach ($orderDetails as $item) {
                $stmt->execute([
                    ':order_id' => $orderId,
                    ':product_id' => $item['id'],
                    ':quantity' => $item['quantity'],
                    ':price' => $item['price']
                ]);
            }
            
            $this->conn->commit();
            return $orderId;
            
        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    public function getAllOrders() {
        try {
            $query = "SELECT o.*, 
                      (SELECT SUM(od.quantity * od.price) 
                       FROM order_details od 
                       WHERE od.order_id = o.id) as total_amount
                     FROM " . $this->table_name . " o
                     ORDER BY o.created_at DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch(PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [];
        }
    }

    public function getOrderDetails($orderId) {
        try {
            $query = "SELECT od.*, p.name as product_name
                     FROM order_details od
                     JOIN product p ON od.product_id = p.id
                     WHERE od.order_id = :order_id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':order_id', $orderId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch(PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [];
        }
    }
}
?>