<?php
// Require SessionHelper and other necessary files
require_once(__DIR__ . '/../config/database.php');
require_once(__DIR__ . '/../models/ProductModel.php');
require_once(__DIR__ . '/../models/CategoryModel.php');
require_once(__DIR__ . '/../middleware/AuthMiddleware.php');

class ProductController 
{
    private $productModel;
    private $db;

    public function __construct() 
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    public function index() 
    {
        $products = $this->productModel->getProducts();
        include 'app/views/product/list.php';
    }

    public function show($id) 
    {
        $product = $this->productModel->getProductById($id);

        if ($product) {
            include 'app/views/product/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function add() 
    {
        AuthMiddleware::isAdmin(); // Chỉ admin mới được thêm sản phẩm
        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/product/add.php';
    }

    public function save() 
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = "";
            }

            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image);

            if (is_array($result)) {
                $errors = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            } else {
                header('Location: /DA_MaNguonMo/Product');
            }
        }
    }

    public function edit($id) 
    {
        AuthMiddleware::isAdmin();
        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();

        if ($product) {
            // Pass the editId to the view
            $editId = $id;
            require 'app/views/product/edit.php';
        } else {
            $_SESSION['error'] = "Không tìm thấy sản phẩm";
            header('Location: /DA_MaNguonMo/Product');
        }
    }

    public function update() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $id = $_POST['id'];
                $name = $_POST['name'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category_id = $_POST['category_id'];
                $existing_image = $_POST['existing_image'] ?? null;

                // Handle image upload
                $image = null;
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $image = $_FILES['image'];
                } else {
                    $image = $existing_image;
                }

                $result = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);

                if ($result) {
                    header('Location: /DA_MaNguonMo/Product');
                    exit;
                } else {
                    throw new Exception("Cập nhật thất bại");
                }
            } catch (Exception $e) {
                http_response_code(400);
                echo json_encode(['error' => $e->getMessage()]);
                exit;
            }
        }
    }

    public function delete($id) 
    {
        AuthMiddleware::isAdmin(); // Chỉ admin mới được xóa sản phẩm
        if ($this->productModel->deleteProduct($id)) {
            header('Location: /DA_MaNguonMo/Product');
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }

    private function uploadImage($file) 
    {
        $target_dir = "uploads/";

        // Kiểm tra và tạo thư mục nếu chưa tồn tại
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Kiểm tra xem file có phải là hình ảnh không
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File không phải là hình ảnh.");
        }

        // Kiểm tra kích thước file (10 MB = 10 * 1024 * 1024 bytes)
        if ($file["size"] > 10 * 1024 * 1024) {
            throw new Exception("Hình ảnh có kích thước quá lớn.");
        }

        // Chỉ cho phép một số định dạng hình ảnh nhất định
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF.");
        }

        // Lưu file
        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
        }

        return $target_file;
    }

    public function addToCart($id) 
    {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image
            ];
        }

        header('Location: /DA_MaNguonMo/Product/cart');
    }

    public function cart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'] ?? null;
            $quantity = $_POST['quantity'] ?? 1;
            
            if ($product_id) {
                // Lấy thông tin sản phẩm
                $product = $this->productModel->getProductById($product_id);
                
                if ($product) {
                    // Khởi tạo giỏ hàng nếu chưa có
                    if (!isset($_SESSION['cart'])) {
                        $_SESSION['cart'] = [];
                    }
                    
                    // Thêm hoặc cập nhật sản phẩm trong giỏ hàng
                    if (isset($_SESSION['cart'][$product_id])) {
                        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
                    } else {
                        $_SESSION['cart'][$product_id] = [
                            'id' => $product->id,
                            'name' => $product->name,
                            'price' => $product->price,
                            'image' => $product->image,
                            'quantity' => $quantity
                        ];
                    }
                    
                    $_SESSION['success'] = 'Đã thêm sản phẩm vào giỏ hàng';
                }
            }
        }
        
        require_once 'app/views/product/cart.php';
    }

    public function checkout() {
        // Kiểm tra giỏ hàng có trống không
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            header('Location: /DA_MaNguonMo/Product/cart');
            exit();
        }
        
        require_once 'app/views/product/checkout.php';
    }

    public function placeOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Kiểm tra giỏ hàng
                if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                    throw new Exception('Giỏ hàng trống');
                }

                $db = new Database();
                $conn = $db->getConnection();
                
                if (!$conn) {
                    throw new Exception('Không thể kết nối database');
                }

                $conn->beginTransaction();

                // Insert into orders table
                $sql = "INSERT INTO orders (name, phone, address, created_at) 
                       VALUES (:name, :phone, :address, NOW())";
                
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':name' => $_POST['name'],
                    ':phone' => $_POST['phone'],
                    ':address' => $_POST['address']
                ]);

                $orderId = $conn->lastInsertId();

                // Insert order details
                $sql = "INSERT INTO order_details (order_id, product_id, quantity, price) 
                       VALUES (:order_id, :product_id, :quantity, :price)";
                
                $stmt = $conn->prepare($sql);
                $total_amount = 0;

                foreach ($_SESSION['cart'] as $item) {
                    $stmt->execute([
                        ':order_id' => $orderId,
                        ':product_id' => $item['id'],
                        ':quantity' => $item['quantity'],
                        ':price' => $item['price']
                    ]);
                    $total_amount += $item['price'] * $item['quantity'];
                }

                $conn->commit();

                // Store order info in session
                $_SESSION['order_info'] = [
                    'order_id' => $orderId,
                    'total_amount' => $total_amount,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                
                // Clear cart
                unset($_SESSION['cart']);

                // Redirect to MomoPay
                header('Location: /DA_MaNguonMo/Product/momoPayment');
                exit();

            } catch (Exception $e) {
                if (isset($conn)) {
                    $conn->rollBack();
                }
                error_log("Order Error: " . $e->getMessage());
                $_SESSION['error'] = 'Có lỗi xảy ra khi đặt hàng';
                header('Location: /DA_MaNguonMo/Product/checkout');
                exit();
            }
        }
    }

    public function orderConfirmation() {
        if (!isset($_SESSION['order_info']['order_id'])) {
            header('Location: /DA_MaNguonMo/Product/cart');
            exit();
        }
        include 'app/views/product/orderConfirmation.php';
    }

    public function momoPayment() {
        if (!isset($_SESSION['order_info'])) {
            header('Location: /DA_MaNguonMo/Product/cart');
            exit();
        }
        include 'app/views/product/momopay.php';
    }

    public function removeFromCart() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Đọc dữ liệu JSON từ request
            $data = json_decode(file_get_contents('php://input'), true);
            $productId = $data['product_id'] ?? null;
            
            if ($productId && isset($_SESSION['cart'][$productId])) {
                // Xóa sản phẩm khỏi giỏ hàng
                unset($_SESSION['cart'][$productId]);
                
                // Nếu giỏ hàng trống, xóa luôn session cart
                if (empty($_SESSION['cart'])) {
                    unset($_SESSION['cart']);
                }
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Đã xóa sản phẩm khỏi giỏ hàng'
                ]);
                exit;
            }
        }
        
        echo json_encode([
            'success' => false,
            'message' => 'Không thể xóa sản phẩm'
        ]);
    }

    public function updateCart() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $productId = $data['product_id'] ?? null;
            $quantity = $data['quantity'] ?? null;
            
            if ($productId && $quantity && isset($_SESSION['cart'][$productId])) {
                // Cập nhật số lượng
                $_SESSION['cart'][$productId]['quantity'] = $quantity;
                
                // Tính tổng số sản phẩm trong giỏ
                $cartCount = 0;
                foreach ($_SESSION['cart'] as $item) {
                    $cartCount += $item['quantity'];
                }
                
                echo json_encode([
                    'success' => true,
                    'cartCount' => $cartCount,
                    'message' => 'Cập nhật thành công'
                ]);
                exit;
            }
        }
        
        echo json_encode([
            'success' => false,
            'message' => 'Cập nhật thất bại'
        ]);
    }

    public function updateCartBatch() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $data = json_decode(file_get_contents('php://input'), true);
                $quantities = $data['quantities'] ?? [];
                
                if (empty($quantities)) {
                    throw new Exception('Không có dữ liệu cập nhật');
                }
                
                foreach ($quantities as $productId => $quantity) {
                    if (isset($_SESSION['cart'][$productId])) {
                        // Đảm bảo số lượng hợp lệ
                        $quantity = max(1, intval($quantity));
                        $_SESSION['cart'][$productId]['quantity'] = $quantity;
                    }
                }
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Cập nhật giỏ hàng thành công'
                ]);
                
            } catch (Exception $e) {
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Method not allowed'
            ]);
        }
    }
}
?>