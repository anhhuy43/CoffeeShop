<?php include(__DIR__ . '/../../shares/header.php'); ?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Chi tiết đơn hàng #<?= $orderDetails[0]->order_id ?></h2>
        <a href="/DA_MaNguonMo/Admin/order" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title mb-4">Danh sách sản phẩm</h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        foreach ($orderDetails as $item): 
                            $subtotal = $item->price * $item->quantity;
                            $total += $subtotal;
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($item->product_name) ?></td>
                                <td><?= number_format($item->price, 0, ',', '.') ?> VNĐ</td>
                                <td><?= $item->quantity ?></td>
                                <td><?= number_format($subtotal, 0, ',', '.') ?> VNĐ</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                            <td><strong><?= number_format($total, 0, ',', '.') ?> VNĐ</strong></td>
                        </tr>
                    </tfoot>
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
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}

.btn-secondary:hover {
    background-color: #5a6268;
    border-color: #545b62;
}
</style>

<?php include(__DIR__ . '/../../shares/footer.php'); ?>
