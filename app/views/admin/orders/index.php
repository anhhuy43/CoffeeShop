<?php include(__DIR__ . '/../../shares/header.php'); ?>

<div class="container my-5">
    <h2 class="mb-4">Quản lý đơn hàng</h2>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Tên khách hàng</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Tổng tiền</th>
                            <th>Ngày đặt</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>#<?= $order->id ?></td>
                                <td><?= htmlspecialchars($order->name) ?></td>
                                <td><?= htmlspecialchars($order->phone) ?></td>
                                <td><?= htmlspecialchars($order->address) ?></td>
                                <td><?= number_format($order->total_amount, 0, ',', '.') ?> VNĐ</td>
                                <td><?= date('d/m/Y H:i', strtotime($order->created_at)) ?></td>
                                <td>
                                    <a href="/DA_MaNguonMo/Admin/order/details/<?= $order->id ?>" 
                                       class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Chi tiết
                                    </a>
                                </td>
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
}

.table th {
    background-color: #f8f9fa;
    border-top: none;
}

.btn-info {
    background-color: #006837;
    border-color: #006837;
    color: white;
}

.btn-info:hover {
    background-color: #005229;
    border-color: #005229;
    color: white;
}
</style>

<?php include(__DIR__ . '/../../shares/footer.php'); ?>
