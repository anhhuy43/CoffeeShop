<?php include(__DIR__ . '/../shares/header.php'); ?>

<div class="container my-5">
    <!-- Banner chính -->
    <div class="main-banner mb-5">
        <img src="/DA_MaNguonMo/public/images/promotion-banner.jpg" alt="Khuyến mãi đặc biệt" class="w-100">
    </div>

    <!-- Các chương trình khuyến mãi -->
    <div class="promotions-grid">
        <!-- Khuyến mãi 1 -->
        <div class="promo-card">
            <div class="promo-image">
                <img src="/DA_MaNguonMo/public/images/promo1.jpg" alt="Khuyến mãi 1">
                <div class="promo-tag">Giảm 20%</div>
            </div>
            <div class="promo-content">
                <h3>Mua 1 Tặng 1</h3>
                <p class="promo-date">Từ 01/05 - 31/05/2024</p>
                <p class="promo-desc">Áp dụng cho tất cả các loại trà sữa size L vào các ngày trong tuần.</p>
                <button class="btn-order">Đặt ngay</button>
            </div>
        </div>

        <!-- Khuyến mãi 2 -->
        <div class="promo-card">
            <div class="promo-image">
                <img src="/DA_MaNguonMo/public/images/promo2.jpg" alt="Khuyến mãi 2">
                <div class="promo-tag">Giảm 30%</div>
            </div>
            <div class="promo-content">
                <h3>Combo Tiết Kiệm</h3>
                <p class="promo-date">Từ 01/05 - 31/05/2024</p>
                <p class="promo-desc">Combo 2 ly bất kỳ chỉ với 55.000đ. Áp dụng size M.</p>
                <button class="btn-order">Đặt ngay</button>
            </div>
        </div>

        <!-- Khuyến mãi 3 -->
        <div class="promo-card">
            <div class="promo-image">
                <img src="/DA_MaNguonMo/public/images/promo3.jpg" alt="Khuyến mãi 3">
                <div class="promo-tag">Quà tặng</div>
            </div>
            <div class="promo-content">
                <h3>Sinh Nhật Vui Vẻ</h3>
                <p class="promo-date">Áp dụng cả năm</p>
                <p class="promo-desc">Tặng 1 bánh kem mini cho khách hàng có sinh nhật.</p>
                <button class="btn-order">Đặt ngay</button>
            </div>
        </div>
    </div>

    <!-- Banner quảng cáo -->
    <div class="ad-banners mt-5">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="ad-banner">
                    <img src="/DA_MaNguonMo/public/images/ad-banner1.jpg" alt="Quảng cáo 1">
                    <div class="ad-content">
                        <h4>Thứ 3 Vui Vẻ</h4>
                        <p>Giảm 15% cho mọi đơn hàng</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="ad-banner">
                    <img src="/DA_MaNguonMo/public/images/ad-banner2.jpg" alt="Quảng cáo 2">
                    <div class="ad-content">
                        <h4>Cuối Tuần Hạnh Phúc</h4>
                        <p>Tặng topping cho đơn từ 2 ly</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.promotions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-top: 30px;
}

.promo-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.promo-card:hover {
    transform: translateY(-5px);
}

.promo-image {
    position: relative;
    height: 200px;
}

.promo-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.promo-tag {
    position: absolute;
    top: 15px;
    right: 15px;
    background: #e44d26;
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-weight: bold;
}

.promo-content {
    padding: 20px;
    text-align: center;
}

.promo-content h3 {
    color: #006837;
    margin-bottom: 10px;
    font-size: 1.5rem;
}

.promo-date {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 10px;
}

.promo-desc {
    color: #444;
    margin-bottom: 20px;
    line-height: 1.5;
}

.btn-order {
    background: #006837;
    color: white;
    border: none;
    padding: 10px 30px;
    border-radius: 25px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-order:hover {
    background: #005229;
    transform: translateY(-2px);
}

.ad-banner {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    height: 200px;
}

.ad-banner img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.ad-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 20px;
    background: linear-gradient(transparent, rgba(0,0,0,0.7));
    color: white;
}

.ad-content h4 {
    margin: 0;
    font-size: 1.3rem;
}

.ad-content p {
    margin: 5px 0 0;
    opacity: 0.9;
}

/* Animation */
.promo-card {
    animation: fadeInUp 0.5s ease forwards;
    opacity: 0;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .promotions-grid {
        grid-template-columns: 1fr;
    }
    
    .ad-banner {
        height: 150px;
    }
}
</style>

<script>
// Thêm animation delay cho các card
document.querySelectorAll('.promo-card').forEach((card, index) => {
    card.style.animationDelay = `${index * 0.2}s`;
});

// Xử lý nút đặt hàng
document.querySelectorAll('.btn-order').forEach(button => {
    button.addEventListener('click', () => {
        window.location.href = '/DA_MaNguonMo/Product';
    });
});
</script>

<?php include(__DIR__ . '/../shares/footer.php'); ?> 