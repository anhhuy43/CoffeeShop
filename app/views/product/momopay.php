<?php 
if (!isset($_SESSION['order_info'])) {
    header('Location: /DA_MaNguonMo/Product/cart');
    exit;
}

$orderInfo = $_SESSION['order_info'];
include(__DIR__ . '/../shares/header.php'); 
?>

<div class="momo-payment">
    <div class="momo-detail-background">
        <div class="momo-detail">
            <div class="timeout">
                <h3>Đơn hàng sẽ hết hạn sau:</h3>
                <div class="time">10:00</div>
            </div>
            <div class="supplier">
                <h3>Nhà cung cấp:</h3>
                <p>MoMo Payment</p>
            </div>
            <div class="detail">
                <h3>Thông tin</h3>
                <p>Phúc Long Coffee & Tea</p>
            </div>
            <div class="idproduct">
                <h3>Đơn hàng</h3>
                <p>PL<?= date('Ymd') ?>-<?= $orderInfo['order_id'] ?></p>
            </div>
            <div class="order-info">
                <h3>Thông tin đơn hàng #<?= $orderInfo['order_id'] ?></h3>
                <p>Ngày đặt: <?= date('d/m/Y H:i', strtotime($orderInfo['created_at'])) ?></p>
                <p class="total-amount">Số tiền: <?= number_format($orderInfo['total_amount'], 0, ',', '.') ?> VNĐ</p>
            </div>
            <div class="back-button">
                <a href="/DA_MaNguonMo/Product" class="btn btn-secondary">Quay lại</a>
            </div>
            <div class="action-buttons mt-4">
                <a href="/DA_MaNguonMo/Product/orderConfirmation" class="btn btn-success">
                    Xác nhận thanh toán
                </a>
            </div>
        </div>
    </div>
    <div class="momo-qr">
        <div class="momo-qr-content">
            <p class="header">Quét mã để thanh toán</p>
            <img src="/DA_MaNguonMo/public/images/QR_Payment_MoMo.jpg" alt="Momo QR">
            <p class="desc">Sử dụng App MoMo hoặc ứng dụng Camera hỗ trợ QR code để quét mã.</p>
            <p class="loading">Đang chờ quét mã ...</p>
        </div>
    </div>
</div>

<style>
.momo-payment {
    display: flex;
    min-height: 600px;
    background: #f8f9fa;
    padding: 30px;
}

.momo-detail-background {
    flex: 1;
    padding: 20px;
}

.momo-detail {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}

.momo-detail h3 {
    color: #666;
    font-size: 1rem;
    margin-bottom: 10px;
}

.momo-detail p {
    color: #333;
    font-size: 1.1rem;
    font-weight: 500;
}

.time {
    font-size: 2rem;
    color: #e01e2b;
    font-weight: bold;
}

.momo-qr {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

.momo-qr-content {
    background: white;
    padding: 30px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}

.momo-qr-content img {
    max-width: 300px;
    margin: 20px 0;
}

.momo-qr-content .header {
    font-size: 1.2rem;
    font-weight: 600;
    color: #333;
}

.momo-qr-content .desc {
    color: #666;
    margin: 15px 0;
}

.momo-qr-content .loading {
    color: #e01e2b;
    font-weight: 500;
}

.back-button {
    margin-top: 20px;
    text-align: center;
}
</style>

<script>
var timeLeft = 600; // 10 minutes in seconds
var timerDisplay = document.querySelector('.time');

function updateTimer() {
    var minutes = Math.floor(timeLeft / 60);
    var seconds = timeLeft % 60;
    timerDisplay.textContent = 
        (minutes < 10 ? "0" : "") + minutes + 
        ":" + 
        (seconds < 10 ? "0" : "") + seconds;
        
    if (timeLeft === 0) {
        clearInterval(timerInterval);
        alert('Hết thời gian thanh toán!');
        window.location.href = '/DA_MaNguonMo/Product';
    }
    timeLeft--;
}

var timerInterval = setInterval(updateTimer, 1000);
updateTimer();
</script>

<?php include(__DIR__ . '/../shares/footer.php'); ?>
