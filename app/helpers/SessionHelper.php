<?php 
 
class SessionHelper { 
    public static function isLoggedIn() { 
        return isset($_SESSION['username']); 
    } 
 
    public static function isAdmin() { 
        // Changed from user_role to role to match the session variable set in AccountController
        return isset($_SESSION['username']) && $_SESSION['role'] === 'admin';
    } 
} 
?>