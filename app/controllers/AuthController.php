<?php

class AuthController {
    public function send_reset_link() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];

            // Kiểm tra xem email có tồn tại trong cơ sở dữ liệu không
            $user = $this->userModel->findUserByEmail($email);
            if ($user) {
                // Tạo mã token và lưu vào cơ sở dữ liệu
                $token = bin2hex(random_bytes(50));
                $this->userModel->savePasswordResetToken($user['id'], $token);

                // Gửi email với liên kết đặt lại mật khẩu
                $resetLink = "http://localhost/DA_MaNguonMo/auth/reset_password?token=" . $token;
                $subject = "Đặt lại mật khẩu của bạn";
                $message = "Nhấp vào liên kết sau để đặt lại mật khẩu của bạn: " . $resetLink;

                // Gửi email (sử dụng hàm mail hoặc thư viện gửi email)
                mail($email, $subject, $message);

                // Thông báo thành công
                echo "Một liên kết đặt lại mật khẩu đã được gửi đến email của bạn.";
            } else {
                // Thông báo lỗi nếu email không tồn tại
                echo "Email không tồn tại.";
            }
        }
    }

    public function update_password() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['token'];
            $newPassword = $_POST['new_password'];

            // Kiểm tra token và cập nhật mật khẩu
            if ($this->userModel->isValidToken($token)) {
                $this->userModel->updatePassword($token, $newPassword);
                echo "Mật khẩu đã được cập nhật thành công.";
            } else {
                echo "Token không hợp lệ.";
            }
        }
    }
} 