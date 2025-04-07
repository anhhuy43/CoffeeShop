<?php include(__DIR__ . '/../shares/header.php'); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5" style="border-radius: 20px;">
                <div class="card-header">
                    <h3 class="text-center">Đăng nhập</h3>
                </div>
                <div class="card-body">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form action="/DA_MaNguonMo/account/checkLogin" method="post">
                        <div class="form-group">
                            <label for="username">Tên đăng nhập:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Mật khẩu:</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                    </form>
                    
                    <div class="text-center mt-3">
                        <p>Chưa có tài khoản? <a href="/DA_MaNguonMo/account/register">Đăng ký ngay</a></p>
                        <p><a href="/DA_MaNguonMo/account/forgotPassword">Quên mật khẩu?</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}

.card-header {
    background-color:rgb(255, 255, 255);
    color: white;
    padding: 20px;
    border-top-left-radius: 25px !important;
    border-top-right-radius: 25px !important;
}

.card-body {
    padding: 30px;
}

.form-group {
    margin-bottom: 20px;
}

.btn-primary {
    background-color: #006837;
    border-color: #006837;
}

.btn-primary:hover {
    background-color: #005229;
    border-color: #005229;
}

/* Style cho nút toggle password */
#togglePassword {
    border: none;
    background: none;
    padding: 0 12px;
    height: 100%;
}

#togglePassword:focus {
    outline: none;
    box-shadow: none;
}

.input-group-append {
    border: 1px solid #ced4da;
    border-left: none;
    border-radius: 0 4px 4px 0;
}

.input-group-append:hover {
    background-color: #f8f9fa;
    cursor: pointer;
}

#eyeIcon {
    color: #6c757d;
}

.alert {
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 4px;
}
</style>

<script>
// Script xử lý ẩn/hiện mật khẩu
document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
});

// Tự động ẩn thông báo lỗi sau 3 giây
const alertElement = document.querySelector('.alert');
if (alertElement) {
    setTimeout(() => {
        alertElement.style.display = 'none';
    }, 3000);
}
</script>

<?php include(__DIR__ . '/../shares/footer.php'); ?>
