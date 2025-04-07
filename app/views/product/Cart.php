<?php include(__DIR__ . '/../shares/header.php'); ?>

<div class="container my-5">
    <h2 class="mb-4">Giỏ hàng của bạn</h2>
    
    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0;
                    foreach ($_SESSION['cart'] as $item): 
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="/DA_MaNguonMo/<?php echo $item['image']; ?>" 
                                         alt="<?php echo $item['name']; ?>"
                                         class="cart-item-image me-3">
                                    <span><?php echo $item['name']; ?></span>
                                </div>
                            </td>
                            <td><?php echo number_format($item['price']); ?>₫</td>
                            <td>
                                <input type="number" 
                                       value="<?php echo $item['quantity']; ?>"
                                       min="1"
                                       class="form-control quantity-input"
                                       style="width: 80px"
                                       data-id="<?php echo $item['id']; ?>">
                            </td>
                            <td><?php echo number_format($subtotal); ?>₫</td>
                            <td>
                                <button class="btn btn-danger btn-sm remove-item"
                                        data-id="<?php echo $item['id']; ?>">
                                    <i class="fas fa-trash" style="margin-left: 5px;"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                        <td colspan="2"><strong><?php echo number_format($total); ?>₫</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="d-flex gap-3">
                <a href="/DA_MaNguonMo/Product" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Tiếp tục mua sắm
                </a>
                <button type="button" id="updateCartBtn" class="btn btn-success">
                    <i class="fas fa-sync-alt"></i> Cập nhật giỏ hàng
                </button>
            </div>
            <a href="/DA_MaNguonMo/Product/checkout" class="btn btn-primary">
                Thanh toán <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            Giỏ hàng của bạn đang trống. 
            <a href="/DA_MaNguonMo/Product" class="alert-link">Tiếp tục mua sắm</a>
        </div>
    <?php endif; ?>
</div>

<style>
.cart-item-image {
    width: 80px;
    height: 80px;
    object-fit: contain;
    background: #f8f9fa;
    padding: 5px;
    border-radius: 5px;
}

.quantity-input {
    text-align: center;
    border-radius: 20px;
    border: 1px solid #ddd;
    padding: 5px 10px;
    transition: all 0.3s ease;
}

.quantity-input:focus {
    border-color: #006837;
    box-shadow: 0 0 0 0.2rem rgba(0,104,55,0.25);
}

.table > :not(caption) > * > * {
    vertical-align: middle;
}

.btn {
    padding: 10px 20px;
    border-radius: 25px;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.btn-success {
    background-color: #006837;
    border-color: #006837;
}

.btn-success:hover {
    background-color: #005229;
    border-color: #005229;
}

.btn i {
    margin-right: 5px;
}

.remove-item {
    padding: 6px 10px;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.remove-item:hover {
    background-color: #dc3545;
    color: white;
    transform: scale(1.1);
}

.remove-item i {
    font-size: 14px;
}

/* Animation khi xóa sản phẩm */
.cart-item-removing {
    animation: fadeOut 0.3s ease;
}

@keyframes fadeOut {
    from { opacity: 1; }
    to { opacity: 0; }
}

.alert {
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Style cho animation quay icon khi đang cập nhật */
.fa-spin {
    animation: fa-spin 1s infinite linear;
}

@keyframes fa-spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<script>
// Xử lý xóa sản phẩm
document.querySelectorAll('.remove-item').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.getAttribute('data-id');
        if(confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) {
            removeFromCart(productId);
        }
    });
});

function removeFromCart(productId) {
    fetch(`/DA_MaNguonMo/Product/removeFromCart`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            // Reload trang sau khi xóa thành công
            location.reload();
        } else {
            alert('Có lỗi xảy ra khi xóa sản phẩm');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi xóa sản phẩm');
    });
}

// Xử lý cập nhật số lượng
document.querySelectorAll('.quantity-input').forEach(input => {
    input.addEventListener('change', function() {
        const productId = this.getAttribute('data-id');
        const newQuantity = parseInt(this.value);
        
        // Kiểm tra số lượng hợp lệ
        if (newQuantity < 1) {
            this.value = 1;
            return;
        }
        
        updateCartQuantity(productId, newQuantity, this);
    });
});

function updateCartQuantity(productId, quantity, inputElement) {
    const row = inputElement.closest('tr');
    const priceCell = row.querySelector('td:nth-child(2)');
    const totalCell = row.querySelector('td:nth-child(4)');
    const price = parseFloat(priceCell.textContent.replace(/[^\d]/g, ''));
    
    // Hiển thị loading
    row.style.opacity = '0.5';
    
    fetch('/DA_MaNguonMo/Product/updateCart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cập nhật tổng tiền của sản phẩm
            const newTotal = price * quantity;
            totalCell.textContent = new Intl.NumberFormat('vi-VN').format(newTotal) + '₫';
            
            // Cập nhật tổng tiền giỏ hàng
            updateCartTotal();
            
            // Cập nhật số lượng trên icon giỏ hàng
            updateCartIcon(data.cartCount);
        } else {
            inputElement.value = data.oldQuantity;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        inputElement.value = data.oldQuantity;
    })
    .finally(() => {
        row.style.opacity = '1';
    });
}

function updateCartTotal() {
    let total = 0;
    document.querySelectorAll('tr').forEach(row => {
        const quantityInput = row.querySelector('.quantity-input');
        if (quantityInput) {
            const quantity = parseInt(quantityInput.value);
            const price = parseFloat(row.querySelector('td:nth-child(2)').textContent.replace(/[^\d]/g, ''));
            total += price * quantity;
        }
    });
    
    // Cập nhật tổng tiền
    const totalElement = document.querySelector('tfoot strong:last-child');
    if (totalElement) {
        totalElement.textContent = new Intl.NumberFormat('vi-VN').format(total) + '₫';
    }
}

function updateCartIcon(count) {
    const cartCount = document.querySelector('.cart-count');
    if (cartCount) {
        if (count > 0) {
            cartCount.textContent = count;
            cartCount.style.display = 'flex';
        } else {
            cartCount.style.display = 'none';
        }
    }
}

function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alertDiv.style.top = '20px';
    alertDiv.style.right = '20px';
    alertDiv.style.zIndex = '1050';
    
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 3000);
}

document.getElementById('updateCartBtn').addEventListener('click', function() {
    const quantities = {};
    let hasChanges = false;
    
    document.querySelectorAll('.quantity-input').forEach(input => {
        const productId = input.getAttribute('data-id');
        const newQuantity = parseInt(input.value);
        const oldQuantity = parseInt(input.getAttribute('data-original-quantity') || input.defaultValue);
        
        if (newQuantity !== oldQuantity) {
            hasChanges = true;
            quantities[productId] = newQuantity;
        }
    });
    
    if (!hasChanges) {
        return;
    }
    
    // Thay đổi trạng thái nút
    const button = this;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-sync-alt fa-spin"></i> Đang cập nhật...';
    button.disabled = true;
    
    fetch('/DA_MaNguonMo/Product/updateCartBatch', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ quantities })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cập nhật lại trang sau 1 giây
            setTimeout(() => {
                location.reload();
            }, 1000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    })
    .finally(() => {
        // Khôi phục trạng thái nút
        setTimeout(() => {
            button.innerHTML = originalText;
            button.disabled = false;
        }, 1000);
    });
});

// Thêm data-original-quantity cho mỗi input số lượng
document.querySelectorAll('.quantity-input').forEach(input => {
    input.setAttribute('data-original-quantity', input.value);
});
</script>

<?php include(__DIR__ . '/../shares/footer.php'); ?>
