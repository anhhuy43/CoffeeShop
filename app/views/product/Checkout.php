<?php include(__DIR__ . '/../shares/header.php'); ?>

<div class="container my-5">
    <div class="row">
        <!-- Thông tin đơn hàng -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Thông tin đặt hàng</h4>
                </div>
                <div class="card-body">
                    <form id="checkoutForm" action="/DA_MaNguonMo/Product/placeOrder" method="POST" novalidate>
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="name" class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            
                            <div class="col-12">
                                <label for="address" class="form-label">Địa chỉ giao hàng</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                            </div>
                            
                            <div class="col-12">
                                <label for="note" class="form-label">Ghi chú (không bắt buộc)</label>
                                <textarea class="form-control" id="note" name="note" rows="2"></textarea>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 btn-lg">
                            <span class="normal-text">Đặt hàng</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tổng quan đơn hàng -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Đơn hàng của bạn</h4>
                </div>
                <div class="card-body">
                    <?php
                    $total = 0;
                    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])):
                        foreach ($_SESSION['cart'] as $item):
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                    ?>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="mb-0"><?php echo $item['name']; ?></h6>
                                <small class="text-muted">
                                    <?php echo number_format($item['price']); ?>₫ x <?php echo $item['quantity']; ?>
                                </small>
                            </div>
                            <span><?php echo number_format($subtotal); ?>₫</span>
                        </div>
                    <?php
                        endforeach;
                    endif;
                    ?>

                    <hr>

                    <div class="d-flex justify-content-between mb-3">
                        <strong>Tạm tính:</strong>
                        <strong><?php echo number_format($total); ?>₫</strong>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <strong>Phí vận chuyển:</strong>
                        <strong>Miễn phí</strong>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-4">
                        <h5>Tổng cộng:</h5>
                        <h5 class="text-primary"><?php echo number_format($total); ?>₫</h5>
                    </div>

                    <a href="/DA_MaNguonMo/Product/cart" class="btn btn-outline-secondary w-100 mt-2">
                        Quay lại giỏ hàng
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
    border-radius: 10px;
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
    background-color: #006837 !important;
}

.form-control {
    border-radius: 8px;
    padding: 10px 15px;
}

.form-control:focus {
    border-color: #006837;
    box-shadow: 0 0 0 0.2rem rgba(0,104,55,0.25);
}

.btn-primary {
    background-color: #006837;
    border-color: #006837;
    border-radius: 8px;
    padding: 12px 20px;
}

.btn-primary:hover {
    background-color: #005229;
    border-color: #005229;
}

.btn-outline-secondary {
    border-radius: 8px;
}

.text-primary {
    color: #006837 !important;
}

.spinner-border {
    width: 1rem;
    height: 1rem;
    border-width: 0.15em;
}

button:disabled {
    cursor: not-allowed;
    opacity: 0.7;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('checkoutForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate form
            if (this.checkValidity()) {
                // Tìm nút submit
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    // Show loading
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang xử lý...';
                    submitBtn.disabled = true;
                    
                    // Submit form
                    setTimeout(() => {
                        this.submit();
                    }, 100);
                } else {
                    this.submit();
                }
            } else {
                // Trigger HTML5 validation
                this.reportValidity();
            }
        });
    }
});

// Thêm validate form
function validateForm() {
    const form = document.getElementById('checkoutForm');
    const name = form.querySelector('#name').value.trim();
    const phone = form.querySelector('#phone').value.trim();
    const email = form.querySelector('#email').value.trim();
    const address = form.querySelector('#address').value.trim();

    // Validate tên
    if (name.length < 2) {
        alert('Vui lòng nhập họ tên hợp lệ');
        return false;
    }

    // Validate số điện thoại
    const phoneRegex = /(84|0[3|5|7|8|9])+([0-9]{8})\b/;
    if (!phoneRegex.test(phone)) {
        alert('Vui lòng nhập số điện thoại hợp lệ');
        return false;
    }

    // Validate email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert('Vui lòng nhập email hợp lệ');
        return false;
    }

    // Validate địa chỉ
    if (address.length < 10) {
        alert('Vui lòng nhập địa chỉ đầy đủ');
        return false;
    }

    return true;
}

// Cập nhật form submit
document.getElementById('checkoutForm').onsubmit = function(e) {
    e.preventDefault();
    if (validateForm()) {
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        // Disable nút và hiện loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Đang xử lý...';
        
        // Submit form
        this.submit();
    }
};
</script>

<?php include(__DIR__ . '/../shares/footer.php'); ?>