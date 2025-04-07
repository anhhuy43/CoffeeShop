<?php include(__DIR__ . '/../shares/header.php'); ?>

<div class="container my-5">
    <h2 class="mb-4">Thống kê đơn hàng</h2>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="card-title">Tổng số đơn hàng</h6>
                    <h3 class="card-text"><?= $totalOrders ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h66 class="card-title">Tổng doanh thu</h66>
                    <h3 class="card-text"><?= number_format($totalRevenue, 0, ',', '.') ?> VNĐ</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h66 class="card-title">Số lượng sản phẩm bán</h66>
                    <h3 class="card-text"><?= $totalQuantity ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6 class="card-title">Đơn giá trung bình</h6>
                    <h3 class="card-text"><?= number_format($averageOrderValue, 0, ',', '.') ?> VNĐ</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Products Table -->
    <div class="card mb-4">
        <div class="card-header">
            <h3>Sản phẩm bán chạy</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng đã bán</th>
                            <th>Doanh thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($topProducts as $product): ?>
                            <tr>
                                <td><?= htmlspecialchars($product->name) ?></td>
                                <td><?= $product->total_quantity ?></td>
                                <td><?= number_format($product->total_revenue, 0, ',', '.') ?> VNĐ</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="card">
        <div class="card-header">
            <h3>Đơn hàng gần đây</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Số lượng</th>
                            <th>Tổng tiền</th>
                            <th>Ngày đặt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentOrders as $order): ?>
                            <tr>
                                <td>#<?= $order->order_id ?></td>
                                <td><?= htmlspecialchars($order->customer_name) ?></td>
                                <td><?= $order->total_quantity ?></td>
                                <td><?= number_format($order->total_amount, 0, ',', '.') ?> VNĐ</td>
                                <td><?= date('d/m/Y H:i', strtotime($order->created_at)) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
    border-radius: 10px;
    margin-bottom: 20px;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: none;
    padding: 15px 20px;
}

.card-body {
    padding: 20px;
}

.table th {
    border-top: none;
    background-color: #f8f9fa;
    font-weight: 600;
}

.table td, .table th {
    padding: 15px;
    vertical-align: middle;
}

.bg-primary {
    background-color: #006837 !important;
}

.bg-success {
    background-color: #28a745 !important;
}

.bg-info {
    background-color: #17a2b8 !important;
}

.bg-warning {
    background-color: #ffc107 !important;
}
</style>

<?php include(__DIR__ . '/../shares/footer.php'); ?>
