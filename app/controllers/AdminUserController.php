<?php
require_once(__DIR__ . '/../models/UserModel.php');
require_once(__DIR__ . '/../helpers/SessionHelper.php');
require_once(__DIR__ . '/../config/Database.php');

class AdminUserController {
    private $userModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        if (!$this->db) {
            die("Could not connect to database.");
        }
        $this->userModel = new UserModel($this->db);
    }

    public function index() {
        // Kiểm tra quyền admin
        if (!SessionHelper::isAdmin()) {
            header('Location: /DA_MaNguonMo/account/login');
            exit;
        }

        // Fetch all users from the database
        $users = $this->userModel->getAllUsers();
        
        // Specific path from the project root
        require 'app/views/admin/users/index.php';
    }

    public function edit($id) {
        if (!SessionHelper::isAdmin()) {
            header('Location: /DA_MaNguonMo/account/login');
            exit;
        }

        $user = $this->userModel->getUserById($id);
        if ($user) {
            require 'app/views/admin/users/edit.php';
        } else {
            header('Location: /DA_MaNguonMo/Admin/user');
        }
    }

    public function update() {
        if (!SessionHelper::isAdmin()) {
            header('Location: /DA_MaNguonMo/account/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $username = $_POST['username'];
            $role = $_POST['role'];

            $result = $this->userModel->updateUser($id, $username, $role);
            if ($result) {
                header('Location: /DA_MaNguonMo/Admin/user');
            } else {
                echo "Cập nhật thất bại";
            }
        }
    }

    public function delete($id) {
        if (!SessionHelper::isAdmin()) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        $result = $this->userModel->deleteUser($id);
        
        header('Content-Type: application/json');
        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete user']);
        }
        exit;
    }
}