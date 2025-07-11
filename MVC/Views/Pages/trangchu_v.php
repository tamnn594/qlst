<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickMart - Siêu thị tạp hóa online</title>
   <link rel="stylesheet" href="/websitebanhangtaphoa/Public/Css/dingdang.css"> 
   <style>
    /* Dropdown danh mục dạng combobox - màu nổi bật */
    .category-dropdown {
        position: relative;
        display: inline-block;
        margin-left: 10px;
    }
    .category-select {
        padding: 10px 16px;
        border-radius: 8px;
        border: 2px solid #fc5c9c;
        background: linear-gradient(90deg, #fc5c9c 0%, #4ecdc4 100%);
        color: #fff;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        min-width: 180px;
        outline: none;
        transition: border 0.2s, background 0.2s;
        box-shadow: 0 2px 8px rgba(252,92,156,0.08);
    }
    .category-select:focus {
        border: 2px solid #4ecdc4;
        background: linear-gradient(90deg, #4ecdc4 0%, #fc5c9c 100%);
        color: #fff;
    }
    .category-select option {
        color: #333;
        background: #fff;
    }
    /* Làm chữ "Tất cả" đậm hơn */
    .nav-menu .nav-item {
        font-weight: bold;
        
    }
   </style>
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">🛒 QuickMart</div>
                
                <div class="search-bar">
                    <form method="get" action="/websitebanhangtaphoa/dangnhap_kh_c/timkiem" style="display:inline;" onsubmit="return searchNotEmpty();">
                        <input type="text" id="searchInput" name="keyword" placeholder="Tìm kiếm sản phẩm..." value="<?= isset($data['keyword']) ? htmlspecialchars($data['keyword']) : '' ?>">
                        <button class="search-btn" type="submit">🔍</button>
                    </form>
                </div>
                <script>
                function searchNotEmpty() {
                    var kw = document.getElementById('searchInput').value.trim();
                    if (kw.length === 0) {
                        alert('Vui lòng nhập từ khóa tìm kiếm!');
                        return false;
                    }
                    return true;
                }
                </script>
                
                <div class="header-actions">
                    <button class="header-btn" onclick="window.location.href='/websitebanhangtaphoa/dangnhap_kh_c/Get_data'">
                        🛒 Giỏ hàng <span class="cart-count" id="cartCount">0</span>
                    </button>
                    <button class="header-btn" onclick="window.location.href='/websitebanhangtaphoa/dangnhap_kh_c/Get_data'">👤 Đăng nhập / Đăng ký</button>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav class="nav">
        <div class="container">
            <div class="nav-content">
                <div class="nav-menu">
                    <a href="/websitebanhangtaphoa/trangchu" class="nav-item">Tất cả</a>
                    <div class="category-dropdown">
                        <select class="category-select" onchange="if(this.value) window.location.href=this.value;">
                            <option value="">Danh mục</option>
                            <?php if (isset($data['dsDanhMuc']) && is_array($data['dsDanhMuc'])): ?>
                                <?php foreach ($data['dsDanhMuc'] as $dm): ?>
                                    <option value="/websitebanhangtaphoa/trangchu/locdanhmuc/<?= $dm['MaDM'] ?>"
                                        <?php if (isset($data['MaDM']) && $data['MaDM'] == $dm['MaDM']) echo 'selected'; ?>>
                                        <?= htmlspecialchars($dm['TenDM']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
               
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main">
        <div class="container">
            <!-- Promotion Banner -->
            <div class="promotion-banner">
                <div class="promotion-text">🎉 KHUYẾN MÃI LỚN - GIẢM GIÁ 50% TẤT CẢ SẢN PHẨM</div>
                <div class="countdown">
                    <div class="countdown-item">
                        <div class="countdown-number" id="hours">00</div>
                        <div class="countdown-label">Giờ</div>
                    </div>
                    <div class="countdown-item">
                        <div class="countdown-number" id="minutes">00</div>
                        <div class="countdown-label">Phút</div>
                    </div>
                    <div class="countdown-item">
                        <div class="countdown-number" id="seconds">00</div>
                        <div class="countdown-label">Giây</div>
                    </div>
                </div>
            </div>

            <!-- Products Section -->
            <section class="products-section">
                <h2>
                    🏪
                    <?php
                    // Nếu có từ khóa tìm kiếm, ưu tiên hiển thị tiêu đề tìm kiếm
                    if (isset($data['keyword']) && strlen(trim($data['keyword'])) > 0) {
                        echo "Kết quả tìm kiếm cho: <span style='color:#fc5c9c'>" . htmlspecialchars($data['keyword']) . "</span>";
                    }
                    // Nếu không, hiển thị tên danh mục nếu có chọn, mặc định là "Tất cả sản phẩm"
                    else if (!empty($data['dsDanhMuc']) && !empty($data['MaDM'])) {
                        $maDM = $data['MaDM'];
                        $tenDM = 'Tất cả sản phẩm';
                        foreach ($data['dsDanhMuc'] as $dm) {
                            if ($dm['MaDM'] == $maDM) {
                                $tenDM = $dm['TenDM'];
                                break;
                            }
                        }
                        echo htmlspecialchars($tenDM);
                    } else {
                        echo "Tất cả sản phẩm";
                    }
                    ?>
                </h2>
                <div class="products-grid">
                    <?php
                    // Hiển thị sản phẩm tìm kiếm hoặc tất cả sản phẩm
                    if (isset($data['dsSanPham']) && is_array($data['dsSanPham']) && count($data['dsSanPham']) > 0):
                        $danhMucMap = [];
                        if (isset($data['dsDanhMuc']) && is_array($data['dsDanhMuc'])) {
                            foreach ($data['dsDanhMuc'] as $dm) {
                                $danhMucMap[$dm['MaDM']] = $dm['TenDM'];
                            }
                        }
                        foreach ($data['dsSanPham'] as $sp): ?>
                    <div class="product-card">
                        <img src="<?= htmlspecialchars($sp['HinhAnh']) ?>" alt="<?= htmlspecialchars($sp['TenSP']) ?>" class="product-image">
                        <div class="product-info">
                            <h3><?= htmlspecialchars($sp['TenSP']) ?></h3>
                            <div class="product-price"><?= number_format($sp['Gia']) ?>₫</div>
                            <div class="product-category">
                                <?= isset($danhMucMap[$sp['MaDM']]) ? htmlspecialchars($danhMucMap[$sp['MaDM']]) : '---' ?>
                            </div>
                            <div class="product-desc"><?= htmlspecialchars($sp['MoTa']) ?></div>
                            <div style="margin-top:10px;display:flex;align-items:center;gap:8px;">
                                <input type="number" min="1" value="1" style="width:55px;padding:4px 6px;border-radius:6px;border:1px solid #eee;" id="qty-<?= $sp['MaSP'] ?>">
                                <button class="btn btn-primary"
                                    onclick="themVaoGioServer(<?= htmlspecialchars($sp['MaSP']) ?>, document.getElementById('qty-<?= $sp['MaSP'] ?>').value)">
                                    🛒 Thêm vào giỏ
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;
                    else: ?>
                        <div style="color:#fff;text-align:center;width:100%;">Không có sản phẩm nào phù hợp.</div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </main>

    <!-- Shopping Cart Panel -->
    <div id="cartPanel" class="cart-panel">
        <div class="cart-header">
            <h2>🛒 Giỏ hàng</h2>
            <button class="btn btn-secondary" onclick="toggleCart()">✖️</button>
        </div>
        <div id="cartItems">
            <!-- Sản phẩm giỏ hàng sẽ được load bằng JS -->
        </div>
        <div class="cart-total">
            <div class="total-price">Tổng: <span id="totalPrice">0đ</span></div>
            <button class="btn btn-primary" style="width: 100%; margin-top: 15px;">💳 Thanh toán</button>
        </div>
    </div>

    <!-- Notification -->
    <div id="notification" class="notification"></div>

    <!-- Nhúng file JS đã tách -->
    <script src="/websitebanhangtaphoa/Public/Js/main.js"></script>
    <script>
        // Đảm bảo các hàm JS khả dụng sau khi main.js đã load
        window.addEventListener('load', function() {
            if (typeof startCountdown === 'function') startCountdown();
            if (typeof updateCartCount === 'function') updateCartCount();
        });
    </script>
</body>
</html>
