<?php include 'app/views/shares/header.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5" style="border-radius: 20px;">
                <div class="card-header">
                    <h3 class="text-center">Đăng ký tài khoản</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($errors) && !empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="/DA_MaNguonMo/account/save" method="post">
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

                        <div class="form-group">
                            <label for="confirmpassword">Xác nhận mật khẩu:</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                        <i class="fas fa-eye" id="confirmEyeIcon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block">Đăng ký</button>
                    </form>
                    
                    <div class="text-center mt-3">
                        <p>Đã có tài khoản? <a href="/DA_MaNguonMo/account/login">Đăng nhập</a></p>
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
    background-color: rgb(255, 255, 255);
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

#togglePassword, #toggleConfirmPassword {
    border: none;
    background: none;
    padding: 0 12px;
    height: 100%;
}

#togglePassword:focus, #toggleConfirmPassword:focus {
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

.fa-eye, .fa-eye-slash {
    color: #6c757d;
}

.alert {
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 4px;
}
</style>

<script>
// Toggle password visibility for password field
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

// Toggle password visibility for confirm password field
document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
    const confirmPasswordInput = document.getElementById('confirmpassword');
    const confirmEyeIcon = document.getElementById('confirmEyeIcon');
    
    if (confirmPasswordInput.type === 'password') {
        confirmPasswordInput.type = 'text';
        confirmEyeIcon.classList.remove('fa-eye');
        confirmEyeIcon.classList.add('fa-eye-slash');
    } else {
        confirmPasswordInput.type = 'password';
        confirmEyeIcon.classList.remove('fa-eye-slash');
        confirmEyeIcon.classList.add('fa-eye');
    }
});

// Auto-hide alerts after 3 seconds
const alertElement = document.querySelector('.alert');
if (alertElement) {
    setTimeout(() => {
        alertElement.style.display = 'none';
    }, 3000);
}
</script>

<?php include 'app/views/shares/footer.php'; ?>
