<?php
require_once(__DIR__ . '/../helpers/SessionHelper.php');

class AuthMiddleware {
    public static function isAdmin() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: /DA_MaNguonMo/home');
            exit();
        }
    }

    public static function isLoggedIn() {
        if (!isset($_SESSION['username'])) {
            header('Location: /DA_MaNguonMo/account/login');
            exit();
        }
    }
}
?> 