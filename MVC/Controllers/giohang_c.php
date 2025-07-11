<?php
class giohang_c extends controller {
    // Thêm sản phẩm vào giỏ hàng (tạo mới nếu chưa có)
    public function themVaoGio() {
        if (!isset($_SESSION['username'])) {
            echo json_encode(['success' => false, 'message' => 'Bạn cần đăng nhập để thêm vào giỏ hàng!']);
            return;
        }
        $maSP = $_POST['MaSP'] ?? null;
        $soLuong = $_POST['SoLuong'] ?? 1;
        $soLuong = max(1, intval($soLuong));
        if (!$maSP) {
            echo json_encode(['success' => false, 'message' => 'Thiếu thông tin sản phẩm!']);
            return;
        }

        $khModel = $this->model('khachhang_kh_m');
        $user = $khModel->getUserByEmail($_SESSION['username']);
        if (!$user) {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy tài khoản!']);
            return;
        }
        $maKH = $user['MaKH'];

        $gioHangModel = $this->model('GioHangModel');
        $maGH = $gioHangModel->layHoacTaoGioHang($maKH);

        $result = $gioHangModel->themHoacCapNhatSanPham($maGH, $maSP, $soLuong);
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Đã thêm vào giỏ hàng!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Thêm vào giỏ hàng thất bại!']);
        }
    }

    // Lấy danh sách sản phẩm trong giỏ hàng
    public function layGioHang() {
        if (!isset($_SESSION['username'])) {
            echo json_encode([]);
            return;
        }
        $khModel = $this->model('khachhang_kh_m');
        $user = $khModel->getUserByEmail($_SESSION['username']);
        if (!$user) {
            echo json_encode([]);
            return;
        }
        $maKH = $user['MaKH'];
        $gioHangModel = $this->model('GioHangModel');
        $ds = $gioHangModel->layChiTietGioHangTheoMaKH($maKH);
        echo json_encode($ds);
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function xoaSanPham() {
        if (!isset($_SESSION['username'])) {
            echo json_encode(['success' => false]);
            return;
        }
        $maSP = $_POST['MaSP'] ?? null;
        if (!$maSP) {
            echo json_encode(['success' => false]);
            return;
        }
        $khModel = $this->model('khachhang_kh_m');
        $user = $khModel->getUserByEmail($_SESSION['username']);
        if (!$user) {
            echo json_encode(['success' => false]);
            return;
        }
        $maKH = $user['MaKH'];
        $gioHangModel = $this->model('GioHangModel');
        $maGH = $gioHangModel->layHoacTaoGioHang($maKH);
        $gioHangModel->xoaSanPham($maGH, $maSP);
        echo json_encode(['success' => true]);
    }
}
?>
