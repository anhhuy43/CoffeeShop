<?php
require_once('app/config/database.php');
require_once('app/models/AccountModel.php');

class AccountController 
{
    private $accountModel;
    private $db;

    public function __construct() 
    {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }

    public function register() 
    {
        include_once 'app/views/account/register.php';
    }

    public function login() 
    {
        $error = '';
        if (isset($_SESSION['error'])) {
            $error = $_SESSION['error'];
            unset($_SESSION['error']);
        }
        include_once 'app/views/account/login.php';
    }

    public function save() 
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';

            $errors = [];
            if (empty($username)) {
                $errors['username'] = "Vui lòng nhập username!";
            }
            if (empty($password)) {
                $errors['password'] = "Vui lòng nhập password!";
            }
            if ($password != $confirmPassword) {
                $errors['confirmPass'] = "Mật khẩu và xác nhận chưa đúng";
            }

            // Kiểm tra username đã được đăng ký chưa?
            $account = $this->accountModel->getAccountByUsername($username);
            if ($account) {
                $errors['account'] = "Tài khoản này đã có người đăng ký!";
            }

            if (count($errors) > 0) {
                include_once 'app/views/account/register.php';
            } else {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $result = $this->accountModel->save($username, $hashedPassword); // Remove redundant parameter

                if ($result) {
                    $_SESSION['success'] = "Đăng ký thành công!";
                    header('Location: /DA_MaNguonMo/account/login');
                    exit;
                } else {
                    $errors['account'] = "Có lỗi xảy ra khi đăng ký!";
                    include_once 'app/views/account/register.php';
                }
            }
        }
    }

    public function logout() 
    {
        unset($_SESSION['username']);
        unset($_SESSION['role']);

        header('Location: /DA_MaNguonMo/product');
    }

    public function checkLogin() 
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $account = $this->accountModel->getAccountByUsername($username);
            if ($account) {
                $pwd_hashed = $account->password;
                if (password_verify($password, $pwd_hashed)) {
                    // Start session if not already started
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    
                    // Set session variables
                    $_SESSION['username'] = $account->username;
                    $_SESSION['role'] = $account->role ?? 'user'; // Default to 'user' if role is null
                    $_SESSION['user_id'] = $account->id;
                    
                    // Redirect based on role
                    if ($_SESSION['role'] === 'admin') {
                        header('Location: /DA_MaNguonMo/Admin/user');
                    } else {
                        header('Location: /DA_MaNguonMo/home');
                    }
                    exit;
                }
                $_SESSION['error'] = "Mật khẩu không chính xác!";
            } else {
                $_SESSION['error'] = "Tài khoản không tồn tại!";
            }
            header('Location: /DA_MaNguonMo/account/login');
            exit;
        }
    }

    public function forgotPassword() 
    {
        $error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
        $success = isset($_SESSION['success']) ? $_SESSION['success'] : '';
        unset($_SESSION['error']);
        unset($_SESSION['success']);
        include_once 'app/views/account/forgotPassword.php';
    }

    public function processForgotPassword() 
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            
            $account = $this->accountModel->getAccountByUsername($username);
            if ($account) {
                // Generate random password
                $newPassword = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8);
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                
                // Update password in database
                if ($this->accountModel->updatePassword($username, $hashedPassword)) {
                    $_SESSION['success'] = "Mật khẩu mới của bạn là: " . $newPassword;
                } else {
                    $_SESSION['error'] = "Không thể cập nhật mật khẩu";
                }
            } else {
                $_SESSION['error'] = "Không tìm thấy tài khoản";
            }
            
            header('Location: /DA_MaNguonMo/account/forgotPassword');
            exit;
        }
    }
}
?>
