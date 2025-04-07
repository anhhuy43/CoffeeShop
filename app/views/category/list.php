<?php include 'app/views/shares/header.php'; ?>

<h1>Danh sách danh mục</h1>
<a href="/DA_MaNguonMo/Category/add" class="btn btn-success mb-2">Thêm danh mục mới</a>
<ul class="list-group">
    <?php foreach ($categories as $category): ?>
    <li class="list-group-item">
        <h2> <a href="/DA_MaNguonMo/Category/show/<?php echo $category->id; ?>">
                <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
            </a>
        </h2>
        <p><?php echo htmlspecialchars($category->description, ENT_QUOTES, 'UTF-8'); ?></p>
        <a href="/DA_MaNguonMo/Category/edit/<?php echo $category->id; ?>" class="btn btn-warning">Sửa</a>
        <a href="/DA_MaNguonMo/Category/delete/<?php echo $category->id; ?>" class="btn btn-danger"
            onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">Xóa</a>
    </li>
    <?php endforeach; ?>
</ul>

<?php include 'app/views/shares/footer.php'; ?>
