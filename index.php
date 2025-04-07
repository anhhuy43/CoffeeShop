<?php 
session_start(); 
require_once 'app/models/ProductModel.php'; 
require_once 'app/helpers/SessionHelper.php'; 
require_once 'app/config/database.php';
require_once 'app/controllers/ProductApiController.php';
require_once 'app/controllers/CategoryApiController.php';
require_once 'app/controllers/HomeController.php';

$url = $_GET['url'] ?? ''; 
$url = rtrim($url, '/'); 
$url = filter_var($url, FILTER_SANITIZE_URL); 
$url = explode('/', $url); 
 
// Kiểm tra phần đầu tiên của URL để xác định controller 
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' : 
'DefaultController'; 
 
// Kiểm tra phần thứ hai của URL để xác định action 
$action = isset($url[1]) && $url[1] != '' ? $url[1] : 'index'; 

// Định tuyến các yêu cầu API
if ($controllerName === 'ApiController' && isset($url[1])) {
    $apiControllerName = ucfirst($url[1]) . 'ApiController';
    if (file_exists('app/controllers/' . $apiControllerName . '.php')) {
        require_once 'app/controllers/' . $apiControllerName . '.php';
        $controller = new $apiControllerName();
        
        $method = $_SERVER['REQUEST_METHOD'];
        $id = $url[2] ?? null;
        
        switch ($method) {
            case 'GET':
                if ($id) {
                    $action = 'show';
                } else {
                    $action = 'index';
                }
                break;
            case 'POST':
                $action = 'store';
                break;
            case 'PUT':
                if ($id) {
                    $action = 'update';
                }
                break;
            case 'DELETE':
                if ($id) {
                    $action = 'destroy';
                }
                break;
            default:
                http_response_code(405);
                echo json_encode(['message' => 'Method Not Allowed']);
                exit;
        }
        
        if (method_exists($controller, $action)) {
            if ($id) {
                call_user_func_array([$controller, $action], [$id]);
            } else {
                call_user_func_array([$controller, $action], []);
            }
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Action not found']);
        }
        exit;
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'Controller not found']);
        exit;
    }
}

// Special routing for Admin controller
if ($url[0] === 'Admin') {
    switch($url[1] ?? '') {
        case 'order':
            require_once 'app/controllers/AdminOrderController.php';
            $controller = new AdminOrderController();
            
            if (isset($url[2]) && $url[2] === 'details') {
                $controller->details($url[3]);
            } else {
                $controller->index();
            }
            exit;
        case 'user':
            require_once 'app/controllers/AdminUserController.php';
            $controller = new AdminUserController();
            
            if (isset($url[2])) {
                switch($url[2]) {
                    case 'edit':
                        $controller->edit($url[3]);
                        break;
                    case 'update':
                        $controller->update();
                        break;
                    case 'delete':
                        $controller->delete($url[3]);
                        break;
                    default:
                        $controller->index();
                }
            } else {
                $controller->index();
            }
            exit;
        case 'statistics':
            require_once 'app/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->statistics();
            exit;
            break;
        default:
            die('Invalid admin route');
    }
}

// Add a route for the admin user management page
if ($controllerName === 'AdminUserController' && $action === 'index') {
    require_once 'app/controllers/AdminUserController.php';
    $controller = new AdminUserController();
    $controller->index();
    exit;
}

// Add a route for the admin user management page
if ($controllerName === 'Admin' && $action === 'user') {
    require_once 'app/controllers/AdminUserController.php';
    $controller = new AdminUserController();
    $controller->index();
    exit;
}

// Add a route for the account controller
if ($controllerName === 'AccountController' || $url[0] === 'account') {
    require_once 'app/controllers/AccountController.php';
    $controller = new AccountController();
    
    switch ($action) {
        case 'login':
            $controller->login();
            break;
        case 'register':
            $controller->register();
            break;
        case 'save':
            $controller->save();
            break;
        case 'checkLogin':
            $controller->checkLogin();
            break;
        case 'logout':
            $controller->logout();
            break;
        case 'forgotPassword':
            $controller->forgotPassword();
            break;
        case 'processForgotPassword':
            $controller->processForgotPassword();
            break;
        default:
            $controller->login(); // Default to login page
    }
    exit;
}

// Tạo đối tượng controller tương ứng cho các yêu cầu không phải API
if (file_exists('app/controllers/' . $controllerName . '.php')) {
    require_once 'app/controllers/' . $controllerName . '.php';
    $controller = new $controllerName();
} else {
    die('Controller not found');
}

// Kiểm tra và gọi action
if (method_exists($controller, $action)) {
    switch ($controllerName) {
        case 'Product':
            require_once 'app/controllers/ProductController.php';
            $controller = new ProductController();
            switch ($action) {
                case 'checkout':
                    $controller->checkout();
                    break;
                case 'placeOrder':
                    $controller->placeOrder();
                    break;
                case 'removeFromCart':
                    $controller->removeFromCart();
                    break;
                case 'orderConfirmation':
                    require_once 'app/views/product/orderConfirmation.php';
                    break;
                case 'momoPayment':
                    require_once 'app/views/product/momopay.php';
                    break;
                case 'updateCart':
                    $controller->updateCart();
                    break;
                case 'updateCartBatch':
                    $controller->updateCartBatch();
                    break;
                // ... các case khác ...
            }
            break;
        case 'Promotion':
            require_once 'app/controllers/PromotionController.php';
            $controller = new PromotionController();
            $controller->index();
            break;
        default:
            call_user_func_array([$controller, $action], array_slice($url, 2));
    }
} else {
    die('Action not found');
}
?>