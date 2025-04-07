<?php
class HomeController 
{
    public function index() 
    {
        include(__DIR__ . '/../views/home/index.php');
    }

    public function contact() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $message = $_POST['message'] ?? '';

            // Handle form submission (e.g., save to database, send email, etc.)
            // For now, we'll just return a success message.
            echo json_encode(['message' => 'Contact form submitted successfully']);
        } else {
            include(__DIR__ . '/../views/home/contact.php');
        }
    }

    public function about() 
    {
        include(__DIR__ . '/../views/home/about.php');
    }
}
?>
