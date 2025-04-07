<?php include(__DIR__ . '/../shares/header.php'); ?>

<style>
/* Chỉnh sửa style cho tiêu đề và nội dung */
.promo-content {
    padding: 20px;
    text-align: center;
}

.promo-content h3 {
    color: #006837; /* Màu xanh Phúc Long */
    margin-bottom: 10px;
    font-size: 1.8rem;
    font-weight: 700;
    text-transform: uppercase;
}

.promo-date {
    color: #e44d26; /* Màu đỏ cam */
    font-size: 1rem;
    margin-bottom: 10px;
    font-weight: 600;
}

.promo-desc {
    color: #333;
    margin-bottom: 20px;
    line-height: 1.6;
    font-size: 1.1rem;
}

.promo-tag {
    position: absolute;
    margin: 20px;
    background: #e44d26;
    color: white;
    padding: 8px 20px;
    border-radius: 25px;
    font-weight: bold;
    font-size: 1.1rem;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    z-index: 10;
}

/* Style cho banner quảng cáo */
.ad-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 25px;
    background: linear-gradient(transparent, rgba(0,0,0,0.8));
    color: white;
}

.ad-content h4 {
    margin: 0;
    color: white;
    font-size: 1.8rem;
    font-weight: 700;
    text-transform: uppercase;
    margin-bottom: 5px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.ad-content p {
    margin: 5px 0 0;
    color: white;
    font-size: 1.2rem;
    opacity: 0.95;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
}

/* Style cho nút đặt hàng */
.btn-order {
    background: #006837;
    color: white;
    border: none;
    padding: 12px 35px;
    border-radius: 30px;
    font-weight: 600;
    font-size: 1.1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.btn-order:hover {
    background: #005229;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,104,55,0.3);
}

/* Thêm tiêu đề chính cho trang */
.promotion-title {
    text-align: center;
    margin-bottom: 40px;
    position: relative;
    padding-bottom: 15px;
}

.promotion-title h2 {
    color: #006837;
    font-size: 2.5rem;
    font-weight: 700;
    text-transform: uppercase;
    margin-bottom: 10px;
}

.promotion-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 3px;
    background: #006837;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .promo-content h3 {
        font-size: 1.5rem;
    }
    
    .ad-content h4 {
        font-size: 1.5rem;
    }
    
    .promotion-title h2 {
        font-size: 2rem;
    }
    
    .promo-desc {
        font-size: 1rem;
    }
}
</style>

<div class="container my-5">
    <div class="promotion-title">
        <h2>Ưu đãi đặc biệt</h2>
    </div>
    <!-- Banner chính -->
    <div class="main-banner mb-5">
        <img src="/DA_MaNguonMo/public/images/vietphuc-1920x576px-20250321083739.jpg" alt="Khuyến mãi đặc biệt" class="w-100">
    </div>

    <!-- Các chương trình khuyến mãi -->
    <div class="promotions-grid">
        <!-- Khuyến mãi 1 -->
        <div class="promo-card">
            <div class="promo-image">
                <div class="promo-tag">Giảm 20%</div>
                <img src="/DA_MaNguonMo/public/images/1tang1.jpg" alt="Khuyến mãi 1" style="width: 100%; height: 100%;">
            </div>
            <div class="promo-content">
                <h3>Mua 1 Tặng 1</h3>
                <p class="promo-date">Từ 01/05 - 31/05/20255</p>
                <p class="promo-desc">Áp dụng cho tất cả các loại trà sữa size L vào các ngày trong tuần.</p>
                <button class="btn-order">Đặt ngay</button>
            </div>
        </div>

        <!-- Khuyến mãi 2 -->
        <div class="promo-card">
            <div class="promo-image">
                <div class="promo-tag">Giảm 30%</div>
                <img src="/DA_MaNguonMo/public/images/combo.jpg" alt="Khuyến mãi 2" style="width: 100%; height: 100%;">
            </div>
            <div class="promo-content">
                <h3>Combo Tiết Kiệm</h3>
                <p class="promo-date">Từ 01/05 - 31/05/20255</p>
                <p class="promo-desc">Combo 2 ly bất kỳ chỉ với 55.000đ. Áp dụng size M.</p>
                <button class="btn-order">Đặt ngay</button>
            </div>
        </div>

        <!-- Khuyến mãi 3 -->
        <div class="promo-card">
            <div class="promo-image">
                <div class="promo-tag">Quà tặng</div>
                <img src="/DA_MaNguonMo/public/images/Sinhnhatphuclong.jpg" alt="Khuyến mãi 3" style="width: 100%; height: 100%;">
            </div>
            <div class="promo-content">
                <h3>Sinh Nhật Vui Vẻ</h3>
                <p class="promo-date">Áp dụng cả năm</p>
                <p class="promo-desc">Tặng 1 bánh kem mini cho khách hàng có sinh nhật tháng 8.</p>
                <button class="btn-order">Đặt ngay</button>
            </div>
        </div>
    </div>

    <!-- Banner quảng cáo -->
    <div class="ad-banners mt-5">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="ad-banner">
                    <img src="/DA_MaNguonMo/public/images/SPOTLIGHT.jpg" alt="Quảng cáo 1" style="width: 100%; height: 100%;">
                    <div class="ad-content">
                        <h4>PHÚC LONG GIÀNH "SPOTLIGHT" CHO MÓN TRÀ SỮA TRUYỀN THỐNG</h4>
                        <p>Giảm 15% cho đơn hàng "SPOTLIGHT"</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="ad-banner">
                    <img src="/DA_MaNguonMo/public/images/sanphammoi.jpg" alt="Quảng cáo 2" style="width: 100%; height: 100%;">
                    <div class="ad-content">
                        <h4>Phúc Long Ra Mắt Menu Thức Uống Mới: Danh Trà Thái Nguyên - Lục Bảo Tân Cương</h4>
                        <p>Phúc Long ra mắt sản phẩm mới - Ưu đãi giá dùng thử dành riêng cho Hội viên chỉ 45,000đ</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Giữ nguyên phần CSS và JavaScript như cũ -->

<?php include(__DIR__ . '/../shares/footer.php'); ?> 