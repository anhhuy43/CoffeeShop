<?php include(__DIR__ . '/../../shares/header.php'); ?>

<div class="container my-5">
    <h2 class="mb-4">Quản lý người dùng</h2>

    <?php if (empty($users)): ?>
        <div class="alert alert-info">Không có người dùng nào.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên đăng nhập</th>
                        <th>Vai trò</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr data-id="<?= htmlspecialchars($user['id']) ?>">
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td>
                            <span class="badge <?= $user['role'] === 'admin' ? 'bg-danger' : 'bg-primary' ?>">
                                <?= htmlspecialchars($user['role']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="/DA_MaNguonMo/Admin/user/edit/<?= $user['id'] ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            <button class="btn btn-sm btn-danger" onclick="deleteUser(<?= $user['id'] ?>)">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<script>
function deleteUser(id) {
    if (confirm('Bạn có chắc chắn muốn xóa người dùng này?')) {
        fetch(`/DA_MaNguonMo/Admin/user/delete/${id}`, {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the row from the table
                const row = document.querySelector(`tr[data-id="${id}"]`);
                if (row) {
                    row.remove();
                }
                location.reload(); // Reload to update the view
            } else {
                alert('Không thể xóa người dùng này');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi xóa người dùng');
        });
    }
}
</script>

<?php include(__DIR__ . '/../../shares/footer.php'); ?>
