<?php include(__DIR__ . '/../../shares/header.php'); ?>

<div class="container my-5">
    <h2 class="mb-4">Chỉnh sửa người dùng</h2>

    <div class="card">
        <div class="card-body">
            <form action="/DA_MaNguonMo/Admin/user/update" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
                
                <div class="form-group">
                    <label for="username">Tên đăng nhập</label>
                    <input type="text" class="form-control" id="username" name="username" 
                           value="<?= htmlspecialchars($user['username']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="role">Vai trò</label>
                    <select class="form-control" id="role" name="role">
                        <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="/DA_MaNguonMo/Admin/user" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/../../shares/footer.php'); ?>
