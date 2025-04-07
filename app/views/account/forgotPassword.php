<?php include(__DIR__ . '/../shares/header.php'); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5" style="border-radius: 20px;">
                <div class="card-header">
                    <h3 class="text-center">Khôi phục mật khẩu</h3>
                </div>
                <div class="card-body">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>

                    <form action="/DA_MaNguonMo/account/processForgotPassword" method="post">
                        <div class="form-group">
                            <label for="username">Tên đăng nhập:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="username" name="username" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block">Gửi yêu cầu</button>
                    </form>
                    
                    <div class="text-center mt-3">
                        <p><a href="/DA_MaNguonMo/account/login">Quay lại đăng nhập</a></p>
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
    padding: 10px;
    font-size: 16px;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: #005229;
    border-color: #005229;
    transform: translateY(-2px);
}

.input-group-text {
    background-color: #f8f9fa;
    border-left: none;
    color: #6c757d;
}

.form-control {
    border-right: none;
}

.form-control:focus {
    border-color: #006837;
    box-shadow: none;
}

.form-control:focus + .input-group-append .input-group-text {
    border-color: #006837;
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 8px;
    animation: slideIn 0.3s ease;
}

.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}

.alert-danger {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}

@keyframes slideIn {
    from {
        transform: translateY(-20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
</style>

<script>
// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s ease';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });
});
</script>

<?php include(__DIR__ . '/../shares/footer.php'); ?>
