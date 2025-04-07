<?php
class ProductModel 
{
    private $conn;
    private $table_name = "product";

    public function __construct($db) 
    {
        $this->conn = $db;
    }

    public function getProducts() 
    {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name as category_name 
                  FROM " . $this->table_name . " p 
                  LEFT JOIN category c ON p.category_id = c.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $result;
    }

    public function getProductById($id) 
    {
        try {
            $query = "SELECT p.*, c.name as category_name 
                      FROM " . $this->table_name . " p 
                      LEFT JOIN category c ON p.category_id = c.id 
                      WHERE p.id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            
            // Ensure the image path is complete
            if ($result && $result->image) {
                $result->image = ltrim($result->image, '/');
            }
            
            return $result;
        } catch(PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function addProduct($name, $description, $price, $category_id, $image) 
    {
        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
        }
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';
        }
        if (!is_numeric($price) || $price < 0) {
            $errors['price'] = 'Giá sản phẩm không hợp lệ';
        }
        if (count($errors) > 0) {
            return $errors;
        }

        $imagePath = null;
        if ($image && $image['tmp_name']) {
            $imagePath = 'uploads/' . uniqid() . '-' . basename($image['name']);
            move_uploaded_file($image['tmp_name'], $imagePath);
        }

        $query = "INSERT INTO " . $this->table_name . " (name, description, price, category_id, image) VALUES (:name, :description, :price, :category_id, :image)";
        $stmt = $this->conn->prepare($query);

        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = htmlspecialchars(strip_tags($price));
        $category_id = htmlspecialchars(strip_tags($category_id));

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $imagePath);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function updateProduct($id, $name, $description, $price, $category_id, $image = null) 
    {
        try {
            // If there's a new image
            if ($image && isset($image['tmp_name']) && !empty($image['tmp_name'])) {
                $query = "UPDATE " . $this->table_name . " 
                         SET name = :name, description = :description, 
                             price = :price, category_id = :category_id, 
                             image = :image 
                         WHERE id = :id";
                
                $imagePath = 'uploads/' . uniqid() . '-' . basename($image['name']);
                move_uploaded_file($image['tmp_name'], $imagePath);
                
            } else {
                // If no new image, don't update the image field
                $query = "UPDATE " . $this->table_name . " 
                         SET name = :name, description = :description, 
                             price = :price, category_id = :category_id 
                         WHERE id = :id";
            }

            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':category_id', $category_id);
            
            if ($image && isset($image['tmp_name']) && !empty($image['tmp_name'])) {
                $stmt->bindParam(':image', $imagePath);
            }

            return $stmt->execute();
        } catch(PDOException $e) {
            error_log("Update Product Error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteProduct($id) 
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
