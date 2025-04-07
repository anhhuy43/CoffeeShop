<?php include(__DIR__ . '/../shares/header.php'); ?>

<div class="container">
    <div class="product-detail">
        <div class="row">
            <div class="col-md-6">
                <div class="product-image">
                    <img src="/DA_MaNguonMo/<?php echo $product->image; ?>" 
                         alt="<?php echo $product->name; ?>" 
                         class="img-fluid product-img">
                </div>
            </div>
            <div class="col-md-6">
                <h1 class="product-title"><?php echo $product->name; ?></h1>
                <p class="product-price">
                    <?php echo number_format($product->price, 0, ',', '.'); ?> VNĐ
                </p>
                <div class="product-description">
                    <h3>Mô tả sản phẩm</h3>
                    <p><?php echo $product->description; ?></p>
                </div>
                <?php if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'): ?>
                    <form action="/DA_MaNguonMo/Product/cart" method="POST" class="d-flex align-items-center gap-3">
                        <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                        <div class="quantity-control">
                            <label for="quantity" class="form-label">Số lượng:</label>
                            <input type="number" 
                                   name="quantity" 
                                   id="quantity" 
                                   class="form-control" 
                                   value="1" 
                                   min="1" 
                                   max="99">
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg" style="margin-left: 25px; margin-top: 32px;">
                            <i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng
                        </button>
                    </form>
                <?php endif; ?>
                <a href="/DA_MaNguonMo/Product" class="btn btn-secondary btn-lg">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
    </div>
</div>

<div id="imageModal" class="modal">
    <span class="close-modal">&times;</span>
    <img class="modal-content" id="modalImage">
</div>

<style>
.product-detail {
    padding: 30px 0;
}

.product-image {
    position: relative;
    cursor: zoom-in;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.product-image img {
    width: 100%;
    height: auto;
    object-fit: contain;
}

.product-title {
    color: #333;
    font-size: 2rem;
    margin-bottom: 20px;
    font-weight: 600;
}

.product-price {
    font-size: 1.8rem;
    color: #e44d26;
    font-weight: bold;
    margin: 20px 0;
}

.product-description {
    margin: 30px 0 100px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 10px;
}

.product-description h3 {
    font-size: 1.2rem;
    color: #006837;
    margin-bottom: 15px;
    font-weight: 600;
}

.product-category {
    margin: 20px 0;
    padding: 10px 0;
    border-top: 1px solid #eee;
    border-bottom: 1px solid #eee;
}

.btn-lg {
    padding: 12px 25px;
    border-radius: 30px;
    margin-right: 10px;
    margin-top: 20px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary {
    background-color: #006837;
    border-color: #006837;
}

.btn-primary:hover {
    background-color: #005229;
    border-color: #005229;
    transform: translateY(-2px);
}

.btn-secondary:hover {
    transform: translateY(-2px);
}

.zoom-image {
    width: 100%;
    height: auto;
    object-fit: contain;
    transition: transform 0.3s ease;
}

.zoom-hint {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 0.8rem;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-image:hover .zoom-hint {
    opacity: 1;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    padding: 20px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.9);
    backdrop-filter: blur(5px);
}

.modal-content {
    margin: auto;
    display: block;
    max-width: 90%;
    max-height: 90vh;
    object-fit: contain;
    animation: zoom 0.3s ease;
}

.close-modal {
    position: fixed;
    right: 35px;
    top: 15px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
    z-index: 1001;
    transition: 0.3s;
}

.close-modal:hover {
    color: #bbb;
    transform: rotate(90deg);
}

@keyframes zoom {
    from {transform: scale(0.1)}
    to {transform: scale(1)}
}

@media (max-width: 768px) {
    .product-title {
        font-size: 1.5rem;
    }
    
    .product-price {
        font-size: 1.5rem;
    }
    
    .btn-lg {
        width: 100%;
        margin-bottom: 10px;
    }
    
    .modal-content {
        width: 100%;
    }
    
    .close-modal {
        right: 20px;
        top: 10px;
    }
}

.loading {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    font-size: 20px;
}

.close-modal {
    opacity: 0.8;
    text-shadow: 0 0 10px rgba(255,255,255,0.5);
}

.close-modal:hover {
    opacity: 1;
}
</style>

<script>
function openImageModal(imgSrc) {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    
    modal.style.display = "block";
    
    modalImg.style.opacity = "0";
    modalImg.src = imgSrc;
    
    modalImg.onload = function() {
        modalImg.style.opacity = "1";
        modalImg.style.transition = "opacity 0.3s ease";
    };
}

document.querySelector('.close-modal').onclick = function() {
    document.getElementById('imageModal').style.display = "none";
}

document.getElementById('imageModal').onclick = function(e) {
    if (e.target === this) {
        this.style.display = "none";
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.getElementById('imageModal').style.display = "none";
    }
});

let touchstartX = 0;
let touchendX = 0;

document.getElementById('imageModal').addEventListener('touchstart', e => {
    touchstartX = e.changedTouches[0].screenX;
});

document.getElementById('imageModal').addEventListener('touchend', e => {
    touchendX = e.changedTouches[0].screenX;
    if (touchendX < touchstartX - 50) {
        document.getElementById('imageModal').style.display = "none";
    }
});
</script>

<?php include(__DIR__ . '/../shares/footer.php'); ?> 