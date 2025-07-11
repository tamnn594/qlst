<?php
// Trang hiển thị giỏ hàng cho khách hàng
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng của bạn</title>
    <link rel="stylesheet" href="/websitebanhangtaphoa/Public/Css/dingdang.css">
    <style>
        .cart-container { max-width: 800px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); padding: 32px 24px; }
        .cart-title { font-size: 2rem; color: #fc5c9c; margin-bottom: 24px; text-align: center; }
        .cart-table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        .cart-table th, .cart-table td { padding: 12px 8px; text-align: center; }
        .cart-table th { background: #f7fafd; color: #4ecdc4; }
        .cart-table img { width: 60px; border-radius: 8px; }
        .cart-actions { text-align: right; }
        .btn { padding: 8px 18px; border-radius: 8px; border: none; font-weight: bold; cursor: pointer; }
        .btn-danger { background: #ff6b6b; color: #fff; }
        .btn-danger:hover { background: #fc5c9c; }
        .btn-order { background: #4ecdc4; color: #fff; }
        .btn-order:hover { background: #38b2ac; }
        .empty-cart { color: #888; text-align: center; padding: 40px 0; }
    </style>
</head>
<body>
    <div class="cart-container">
        <div class="cart-title">🛒 Giỏ hàng của bạn</div>
        <?php if (!empty($data['cart']) && count($data['cart']) > 0): ?>
        <table class="cart-table">
            <tr>
                <th>Ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tạm tính</th>
                <th>Xóa</th>
            </tr>
            <?php $tong = 0; ?>
            <?php foreach ($data['cart'] as $item): 
                $thanhtien = $item['Gia'] * $item['SoLuong'];
                $tong += $thanhtien;
            ?>
            <tr>
                <td><img src="<?= htmlspecialchars($item['HinhAnh']) ?>"></td>
                <td><?= htmlspecialchars($item['TenSP']) ?></td>
                <td><?= number_format($item['Gia']) ?>₫</td>
                <td><?= $item['SoLuong'] ?></td>
                <td><?= number_format($thanhtien) ?>₫</td>
                <td>
                    <form method="post" action="/websitebanhangtaphoa/giohang_c/xoaSanPham">
                        <input type="hidden" name="MaSP" value="<?= $item['MaSP'] ?>">
                        <button class="btn btn-danger" type="submit">🗑️</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4" style="text-align:right;font-weight:bold;">Tổng tiền:</td>
                <td colspan="2" style="color:#fc5c9c;font-weight:bold;"><?= number_format($tong) ?>₫</td>
            </tr>
        </table>
        <div class="cart-actions">
            <button class="btn btn-order">💳 Đặt hàng</button>
        </div>
        <?php else: ?>
            <div class="empty-cart">Giỏ hàng của bạn đang trống.</div>
        <?php endif; ?>
    </div>
</body>
</html>
