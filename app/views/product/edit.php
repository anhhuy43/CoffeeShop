<?php include(__DIR__ . '/../shares/header.php'); ?>

<div class="container my-5">
    <h1>Sửa sản phẩm</h1>
    <form id="edit-product-form" method="POST" action="/DA_MaNguonMo/Product/update" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $editId ?>">
        <div class="form-group">
            <label for="name">Tên sản phẩm:</label>
            <input type="text" id="name" name="name" class="form-control" value="<?= $product->name ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Mô tả:</label>
            <textarea id="description" name="description" class="form-control" required><?= $product->description ?></textarea>
        </div>
        <div class="form-group">
            <label for="price">Giá:</label>
            <input type="number" id="price" name="price" class="form-control" value="<?= $product->price ?>" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="category_id">Danh mục:</label>
            <select id="category_id" name="category_id" class="form-control" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category->id ?>" <?= $category->id == $product->category_id ? 'selected' : '' ?>>
                        <?= $category->name ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="image">Hình ảnh:</label>
            <input type="file" id="image" name="image" class="form-control">
            <?php if ($product->image): ?>
                <img src="/DA_MaNguonMo/<?= $product->image ?>" alt="Current Image" class="mt-2" style="max-width: 200px;">
                <input type="hidden" name="existing_image" value="<?= $product->image ?>">
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        <a href="/DA_MaNguonMo/Product" class="btn btn-secondary">Hủy</a>
    </form>
</div>

<script>
document.getElementById('edit-product-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('/DA_MaNguonMo/Product/update', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        window.location.href = '/DA_MaNguonMo/Product';
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Không thể cập nhật sản phẩm');
    });
});
</script>

<?php include(__DIR__ . '/../shares/footer.php'); ?>
