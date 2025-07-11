<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý sản phẩm & danh mục</title>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .admin-header {
            background: linear-gradient(45deg, #4ecdc4, #667eea);
            color: #fff;
            padding: 32px 0 24px 0;
            text-align: center;
            border-radius: 0 0 24px 24px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            margin-bottom: 40px;
            letter-spacing: 2px;
        }
        .admin-header h1 {
            font-size: 2.2rem;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 8px;
        }
        .admin-panel {
            background: rgba(255,255,255,0.97);
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.10);
            padding: 32px 24px;
            margin-bottom: 40px;
        }
        .admin-panel h2, .admin-panel h3 {
            color: #3a7bd5;
            margin-bottom: 18px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .form-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 24px;
            align-items: flex-end;
        }
        .form-group {
            min-width: 0;
            max-width: 100%;
            padding: 10px 12px;
            border: 1.5px solid #4ecdc4;
            border-radius: 8px;
            background: #f7fafd;
            font-size: 15px;
            color: #333;
            box-sizing: border-box;
            width: 100%;
        }
        .btn {
            padding: 7px 0;
            border-radius: 8px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
            margin: 0 2px;
            display: inline-block;
            font-size: 0.95rem;
        }
        .btn-primary {
            background: linear-gradient(45deg, #4ecdc4, #667eea);
            color: #fff;
            box-shadow: 0 2px 8px rgba(78,205,196,0.10);
            min-width: 0;
            width: 100%;
            grid-column: 3/4;
            justify-self: end;
        }
        .btn-primary:hover {
            background: linear-gradient(45deg, #667eea, #4ecdc4);
            box-shadow: 0 4px 16px rgba(78,205,196,0.15);
        }
        .btn-secondary {
            background: #f7fafd;
            color: #3a7bd5;
            border: 1.5px solid #3a7bd5;
        }
        .btn-secondary:hover {
            background: #3a7bd5;
            color: #fff;
        }
        .btn-action {
            padding: 7px 18px;
            border-radius: 8px;
            border: none;
            font-weight: bold;
            font-size: 0.95rem;
            cursor: pointer;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s, transform 0.15s;
            margin: 0 2px;
            outline: none;
        }
        .btn-edit {
            background: #eaf6fb;
            color: #3a7bd5;
            border: 1.5px solid #3a7bd5;
        }
        .btn-edit:hover {
            background: linear-gradient(90deg, #4ecdc4 0%, #3a7bd5 100%);
            color: #fff;
            box-shadow: 0 2px 8px rgba(58,123,213,0.10);
            transform: translateY(-2px) scale(1.04);
        }
        .btn-delete {
            background: #fff0f0;
            color: #d9534f;
            border: 1.5px solid #d9534f;
        }
        .btn-delete:hover {
            background: linear-gradient(90deg, #ffbcbc 0%, #d9534f 100%);
            color: #fff;
            box-shadow: 0 2px 8px rgba(217,83,79,0.10);
            transform: translateY(-2px) scale(1.04);
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            margin-bottom: 24px;
        }
        th, td {
            padding: 12px 10px;
            text-align: center;
            vertical-align: middle;
        }
        th {
            background: linear-gradient( #1976d2);
            color: #fff;
            font-weight: bold;
            border-bottom: 2px solid #f7fafd;
            font-size: 1.05rem;
            /* Bo góc trái/phải cho header */
        }
        table tr:first-child th:first-child {
            border-top-left-radius: 18px;
        }
        table tr:first-child th:last-child {
            border-top-right-radius: 18px;
        }
        tr:nth-child(even) {
            background: #f7fafd;
        }
        tr:hover td {
            background: #e3f0ff;
        }
        img {
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(78,205,196,0.10);
        }
        .action-group {
            display: flex;
            justify-content: center;
            gap: 8px;
        }
        .admin-menu {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0;
            margin-bottom: 32px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            background: #f7fafd;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .admin-menu-btn {
            flex: 1;
            padding: 12px 0;
            background: transparent;
            color: #3a7bd5;
            font-size: 14px; /* giảm kích thước chữ */
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: 0.2s;
            outline: none;
            letter-spacing: 1px;
            /* border-right: 1.5px solid #e0e0e0; */
            border-radius: 0;
            min-width: 120px;
        }
        .admin-menu-btn:not(:last-child) {
            border-right: 1.5px solid #d0e6fa; /* Thêm viền xanh nhạt giữa các nút */
        }
        .admin-menu-btn:first-child {
            border-radius: 16px 0 0 16px;
        }
        .admin-menu-btn:last-child {
            border-right: none;
            border-radius: 0 16px 16px 0;
        }
        .admin-menu-btn.active, .admin-menu-btn:hover {
            background: linear-gradient(45deg, #4ecdc4, #3a7bd5);
            color: #fff;
        }
        .admin-menu-btn:visited {
            color: #3a7bd5;
        }
        .icon {
            margin-right: 4px;
            font-size: 1em;
            vertical-align: middle;
        }
        @media (max-width: 600px) {
            .admin-menu {
                flex-direction: column;
                max-width: 100%;
                border-radius: 12px;
            }
            .admin-menu-btn, .admin-menu-btn:first-child, .admin-menu-btn:last-child {
                border-radius: 0 !important;
                border-right: none;
                border-bottom: 1px solid #e0e0e0;
                min-width: 100px;
            }
            .admin-menu-btn:last-child {
                border-bottom: none;
            }
        }
        @media (max-width: 900px) {
            .form-row { grid-template-columns: 1fr; }
            .form-group, .btn-primary { max-width: 100%; min-width: 0; width: 100%; grid-column: auto; }
            .admin-panel { padding: 18px 6px; }
            .action-group { flex-direction: column; gap: 4px; }
            .admin-menu-btn { font-size: 14px; padding: 8px 0; }
        }
    </style>
    <script>
        function showTab(tab) {
            document.getElementById('tab-sanpham').style.display = tab === 'sanpham' ? 'block' : 'none';
            document.getElementById('tab-danhmuc').style.display = tab === 'danhmuc' ? 'block' : 'none';
            document.getElementById('btn-sanpham').classList.toggle('active', tab === 'sanpham');
            document.getElementById('btn-danhmuc').classList.toggle('active', tab === 'danhmuc');
        }
        // Hiển thị/ẩn form thêm sản phẩm
        function toggleAddSanPham() {
            var f = document.getElementById('form-them-sanpham');
            f.style.display = (f.style.display === 'none' || f.style.display === '') ? 'grid' : 'none';
        }
        // Hiển thị/ẩn form thêm danh mục
        function toggleAddDanhMuc() {
            var f = document.getElementById('form-them-danhmuc');
            f.style.display = (f.style.display === 'none' || f.style.display === '') ? 'grid' : 'none';
        }
        window.onload = function() {
            showTab('sanpham');
            document.getElementById('form-them-sanpham').style.display = 'none';
            document.getElementById('form-them-danhmuc').style.display = 'none';
        }
    </script>
</head>
<body>
    <div class="admin-header" style="position:relative;">
        <h1 style="margin-bottom:8px;"><span class="icon"></span>Trang quản trị <span style="color:#4ecdc4;">QuickMart</span></h1>
        <div style="font-size:18px;opacity:0.85;">________________</div>
        <button class="btn btn-primary"
            style="position:absolute;top:14px;right:18px;background:#ff6b6b;color:#fff;width:auto;padding:4px 10px;font-size:12px;line-height:1.2;border-radius:6px;min-width:unset;box-shadow:none;"
            onclick="
                // Xóa session phía client (nếu có lưu token localStorage/cookie)
                <?php session_destroy(); ?>
                window.location.replace('/websitebanhangtaphoa/AuthController/adminLogin');
                return false;
            ">
            <span class="icon" style="font-size:1em;margin-right:2px;">🚪</span>Đăng xuất
        </button>
    </div>
    <div class="container" style="max-width:1100px;margin:0 auto;">
        <div class="admin-menu">
            <button id="btn-sanpham" class="admin-menu-btn active" onclick="showTab('sanpham')"><span class="icon">🛒</span>Sản phẩm</button>
            <button id="btn-danhmuc" class="admin-menu-btn" onclick="showTab('danhmuc')"><span class="icon">📂</span>Danh mục</button>
            <button class="admin-menu-btn" style="white-space:nowrap;" onclick="window.location.href='/websitebanhangtaphoa/customerController/get_data_kh'; return false;"><span class="icon">👤</span>Khách hàng</button>
            <button class="admin-menu-btn" style="white-space:nowrap;" onclick="window.location.href='/websitebanhangtaphoa/OrderController/index'; return false;"><span class="icon">📦</span>Đơn hàng</button>
            <button class="admin-menu-btn" style="white-space:nowrap;" onclick="window.location.href='/websitebanhangtaphoa/StatisticController/index'; return false;"><span class="icon">📊</span>Thống kê</button>
        </div>

        <div id="tab-sanpham" class="admin-panel">
            <h2><span class="icon">🛒</span>Quản lý sản phẩm</h2>
            <!-- Thanh tìm kiếm sản phẩm -->
            <!-- <form action="/websitebanhangtaphoa/Admin/timKiemSanPham" method="get" style="margin-bottom:18px;display:flex;gap:10px;align-items:center;">
                <input id="input-timkiem-sanpham" type="text" name="keyword" value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>" placeholder="Tìm kiếm sản phẩm..." style="flex:1;padding:10px 14px;border-radius:8px;border:1.5px solid #4ecdc4;font-size:15px;">
                <button type="submit" class="btn btn-primary" style="width:auto;padding:8px 22px;"><span class="icon">🔍</span>Tìm kiếm</button>
            </form> -->
            <!-- Không dùng JS để ẩn/hiện input tìm kiếm, chỉ giữ nguyên form như trên -->
            <button class="btn btn-primary" style="width:auto;margin-bottom:18px;" onclick="toggleAddSanPham()">➕ Tạo mới</button>
            <form id="form-them-sanpham" action="/websitebanhangtaphoa/Admin/themSanPham" method="post" class="form-row">
                <input class="form-group" type="text" name="TenSP" placeholder="Tên sản phẩm" required>
                <input class="form-group" type="number" name="Gia" placeholder="Giá" required>
                <input class="form-group" type="number" name="SoLuong" placeholder="Số lượng" required>
                <input class="form-group" type="text" name="MoTa" placeholder="Mô tả">
                <input class="form-group" type="text" name="HinhAnh" placeholder="Link hình ảnh">
                <input class="form-group" type="number" name="MaDM" placeholder="Mã danh mục" required>
                <button class="btn btn-primary" type="submit"><span class="icon">➕</span>Thêm sản phẩm</button>
            </form>

            <h3><span class="icon">📋</span>Danh sách sản phẩm</h3>
            <div style="overflow-x:auto;">
            <table>
                <tr>
                    <th>Mã SP</th>
                    <th>Tên SP</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Mô tả</th>
                    <th>Hình ảnh</th>
                    <th>Danh mục</th>
                    <th>Hành động</th>
                </tr>
                <?php
                $danhMucMap = [];
                foreach ($data['dsDanhMuc'] as $dm) {
                    $danhMucMap[$dm['MaDM']] = $dm['TenDM'];
                }
                ?>
                <?php if (isset($data['dsSanPham']) && is_array($data['dsSanPham']) && count($data['dsSanPham']) > 0): ?>
                    <?php foreach ($data['dsSanPham'] as $sp): ?>
                    <tr>
                        <td><?= $sp['MaSP'] ?></td>
                        <td><?= $sp['TenSP'] ?></td>
                        <td style="color:#3a7bd5;font-weight:bold;"><?= number_format($sp['Gia']) ?>₫</td>
                        <td><?= $sp['SoLuong'] ?></td>
                        <td><?= $sp['MoTa'] ?></td>
                        <td>
                            <?php if (!empty($sp['HinhAnh'])): ?>
                                <img src="<?= $sp['HinhAnh'] ?>" style="width:50px;">
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= isset($danhMucMap[$sp['MaDM']]) ? '<span style="color:#4ecdc4;font-weight:bold;">'.htmlspecialchars($danhMucMap[$sp['MaDM']]).'</span>' : '---' ?>
                        </td>
                        <td>
                            <div class="action-group">
                                <a class="btn btn-secondary btn-edit" style="text-decoration:none;" href="/websitebanhangtaphoa/Admin/suaSanPham/<?= $sp['MaSP'] ?>"><span class="icon">✏️</span>Sửa</a>
                                <a class="btn btn-secondary btn-delete" style="text-decoration:none;" href="/websitebanhangtaphoa/Admin/xoaSanPham/<?= $sp['MaSP'] ?>" onclick="return confirm('Xóa sản phẩm này?')"><span class="icon">🗑️</span>Xóa</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="color:#888;text-align:center;">Không tìm thấy sản phẩm nào.</td>
                    </tr>
                <?php endif; ?>
            </table>
            </div>
        </div>

        <div id="tab-danhmuc" class="admin-panel" style="display:none;">
            <h2><span class="icon">📂</span>Quản lý danh mục</h2>
            <button class="btn btn-primary" style="width:auto;margin-bottom:18px;" onclick="toggleAddDanhMuc()">➕ Tạo mới </button>
            <form id="form-them-danhmuc" action="/websitebanhangtaphoa/Admin/themDanhMuc" method="post" class="form-row">
                <input class="form-group" type="text" name="TenDM" placeholder="Tên danh mục" required>
                <button class="btn btn-primary" type="submit"><span class="icon">➕</span>Thêm danh mục</button>
            </form>
            <h3><span class="icon">📋</span>Danh sách danh mục</h3>
            <div style="overflow-x:auto;">
            <table style="border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(58,123,213,0.10);">
                <tr style="background:linear-gradient(90deg,#4ecdc4 0%,#3a7bd5 100%);color:#fff;font-size:1.08rem;">
                    <th style="border-top-left-radius:12px;">Mã DM</th>
                    <th>Tên DM</th>
                    <th style="border-top-right-radius:12px;">Hành động</th>
                </tr>
                <?php foreach ($data['dsDanhMuc'] as $dm): ?>
                <tr style="background:#fafdff;">
                    <td style="color:#3a7bd5;font-weight:500;"><?= $dm['MaDM'] ?></td>
                    <td style="color:#222;font-weight:500;"><?= $dm['TenDM'] ?></td>
                    <td>
                        <div class="action-group">
                            <a class="btn btn-secondary btn-edit" style="text-decoration:none;" href="/websitebanhangtaphoa/Admin/suaDanhMuc/<?= $dm['MaDM'] ?>"><span class="icon">✏️</span>Sửa</a>
                            <a class="btn btn-secondary btn-delete" style="text-decoration:none;" href="/websitebanhangtaphoa/Admin/xoaDanhMuc/<?= $dm['MaDM'] ?>" onclick="return confirm('Xóa danh mục này?')"><span class="icon">🗑️</span>Xóa</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            </div>
        </div>
    </div>
</body>
</html>
