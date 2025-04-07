<?php include(__DIR__ . '/../shares/header.php'); ?>
<!-- Thanh tìm kiếm và bộ lọc -->
<div class="filter-container mb-4">
    <div class="row">
        <!-- Tìm kiếm -->
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" id="searchInput" class="form-control" placeholder="Nhập tên sản phẩm cần tìm...">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" onclick="filterProducts()">
                        <i class="fa fa-search"></i> Tìm kiếm
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Lọc theo giá -->
        <div class="col-md-5">
            <div class="price-filter">
                <select id="priceFilter" class="form-control" onchange="filterProducts()">
                    <option value="">Tất cả mức giá</option>
                    <option value="0-20000">Dưới 20.000đ</option>
                    <option value="20000-40000">20.000đ - 40.000đ</option>
                    <option value="40000-60000">40.000đ - 60.000đ</option>
                    <option value="60000-80000">60.000đ - 80.000đ</option>
                    <option value="80000-100000">80.000đ - 100.000đ</option>
                    <option value="100000">Trên 100.000đ</option>
                </select>
            </div>
        </div>

        <!-- Nút reset bộ lọc -->
        <div class="col-md-1">
            <button class="btn btn-secondary" onclick="resetFilters()">
                <i class="fa fa-refresh"></i> Reset
            </button>
        </div>
    </div>
</div>

<!-- Thay thế nút thêm sản phẩm hiện tại bằng đoạn code có điều kiện -->
<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <a href="/DA_MaNguonMo/Product/add" class="btn btn-success mb-2">
        <i class="fas fa-plus"></i> Thêm sản phẩm mới
    </a>
<?php endif; ?>

<!-- Thêm CSS cho hiệu ứng -->
<style>
.card {
    transition: transform 0.3s, box-shadow 0.3s;
    margin-bottom: 20px;
    height: 100%;
    border-radius: 10px;
    overflow: hidden;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.card-img-container {
    position: relative;
    width: 100%;
    padding-top: 100%; /* Tạo container hình vuông */
    overflow: hidden;
    background-color: #fff;
}

.card-img-top {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 10px;
    transition: transform 0.3s;
}

.card:hover .card-img-top {
    transform: scale(1.05);
}

.card-body {
    padding: 1rem;
    text-align: center;
    background-color: #fff;
}

.card-title {
    font-size: 1rem;
    margin-bottom: 0.5rem;
    line-height: 1.4;
    height: 2.8em;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.card-title a {
    color: #333;
    text-decoration: none;
    font-weight: 500;
}

.card-title a:hover {
    color: #006837;
}

.product-price {
    font-size: 1.2rem;
    color: #e44d26;
    font-weight: bold;
    margin: 0.5rem 0;
}

.action-buttons {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.btn-sm {
    padding: 0.4rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.btn-primary {
    background-color: #006837;
    border-color: #006837;
}

.btn-primary:hover {
    background-color: #005229;
    border-color: #005229;
    transform: translateY(-2px);
}

.fade-in {
    opacity: 0;
    animation: fadeIn 0.5s ease-in forwards;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.search-container {
    max-width: 500px;
    margin: 20px auto;
}

.search-container input {
    border-radius: 20px 0 0 20px;
    border: 2px solid #006837;
    padding: 10px 20px;
}

.search-container .btn {
    border-radius: 0 20px 20px 0;
    background-color: #006837;
    border: 2px solid #006837;
    padding: 10px 20px;
}

.search-container .btn:hover {
    background-color: #005229;
    border-color: #005229;
}

.filter-container {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.filter-container select {
    border: 2px solid #006837;
    border-radius: 20px;
    padding: 8px 15px;
}
</style>

<div class="row" id="product-list">
    <!-- Danh sách sản phẩm sẽ được tải từ API và hiển thị tại đây -->
</div>

<?php include 'app/views/shares/footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    loadProducts();
    
    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            filterProducts();
        }
    });
});

// Hàm lọc sản phẩm
function filterProducts() {
    const searchTerm = document.getElementById('searchInput').value.trim().toLowerCase();
    const priceRange = document.getElementById('priceFilter').value;

    fetch('/DA_MaNguonMo/api/product')
        .then(response => response.json())
        .then(data => {
            let filteredProducts = data;

            // Lọc theo tên
            if (searchTerm) {
                filteredProducts = filteredProducts.filter(product => 
                    product.name.toLowerCase().includes(searchTerm)
                );
            }

            // Lọc theo giá
            if (priceRange) {
                const [minPrice, maxPrice] = priceRange.split('-').map(Number);
                filteredProducts = filteredProducts.filter(product => {
                    const price = Number(product.price);
                    if (maxPrice) {
                        return price >= minPrice && price <= maxPrice;
                    } else {
                        return price >= minPrice;
                    }
                });
            }

            displayProducts(filteredProducts);
        });
}

// Hiển thị sản phẩm
function displayProducts(products) {
    const productList = document.getElementById('product-list');
    productList.innerHTML = '';

    if (products.length === 0) {
        productList.innerHTML = '<div class="col-12 text-center"><p>Không tìm thấy sản phẩm nào</p></div>';
        return;
    }

    const isAdmin = <?php echo isset($_SESSION['role']) && $_SESSION['role'] === 'admin' ? 'true' : 'false'; ?>;
    
    products.forEach((product, index) => {
        const productItem = document.createElement('div');
        productItem.className = 'col-md-3 mb-4 fade-in';
        productItem.style.animationDelay = `${index * 0.1}s`;
        productItem.innerHTML = `
            <div class="card">
                <a href="/DA_MaNguonMo/Product/show/${product.id}" class="card-img-container">
                    <img src="/DA_MaNguonMo/${product.image}" class="card-img-top" alt="${product.name}">
                </a>
                <div class="card-body">
                    <h2 class="card-title">
                        <a href="/DA_MaNguonMo/Product/show/${product.id}">${product.name}</a>
                    </h2>
                    <p class="product-price">${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(product.price)}</p>
                    <div class="action-buttons">
                        ${isAdmin ? `
                            <a href="/DA_MaNguonMo/Product/edit/${product.id}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            <button class="btn btn-danger btn-sm" onclick="deleteProduct(${product.id})">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        ` : `
                            <a href="/DA_MaNguonMo/Product/show/${product.id}" class="btn btn-primary btn-sm">
                                <i class="fas fa-shopping-cart"></i> Xem chi tiết
                            </a>
                        `}
                    </div>
                </div>
            </div>
        `;
        productList.appendChild(productItem);
    });
}

// Reset tất cả bộ lọc
function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('priceFilter').value = '';
    loadProducts();
}

// Load tất cả sản phẩm
function loadProducts() {
    fetch('/DA_MaNguonMo/api/product')
        .then(response => response.json())
        .then(data => {
            displayProducts(data);
        });
}

function deleteProduct(id) {
    if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
        fetch(`/DA_MaNguonMo/api/product/${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Product deleted successfully') {
                location.reload();
            } else {
                alert('Xóa sản phẩm thất bại');
            }
        });
    }
}

// Thay thế hoặc thêm hàm addToCart trong phần script
function addToCart(productId) {
    // Chuyển hướng đến trang show của sản phẩm
    window.location.href = `/DA_MaNguonMo/Product/show/${productId}`;
}
</script>