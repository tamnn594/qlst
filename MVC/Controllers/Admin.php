<?php
class Admin extends controller {
    public function __construct() {
        // Đảm bảo session đã được khởi tạo
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // // Kiểm tra đăng nhập admin
        // if (!isset($_SESSION['admin_id'])) {
        //     header('Location: /websitebanhangtaphoa/AuthController/adminLogin');
        //     exit;
        // }
    }

    public function sanpham() {
        $sanphamModel = $this->model('SanPhamModel');
        $danhmucModel = $this->model('DanhMucModel');
        $dsSanPham = $sanphamModel->layTatCaSanPham();
        $dsDanhMuc = $danhmucModel->layTatCaDanhMuc();
        $this->view('Pages/admin_sanpham_v', [
            'dsSanPham' => $dsSanPham,
            'dsDanhMuc' => $dsDanhMuc
        ]);
    }

    public function Get_data() {
        $this->sanpham();
    }

    // Thêm danh mục
    public function themDanhMuc() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['TenDM'])) {
            $TenDM = trim($_POST['TenDM']);
            $model = $this->model('DanhMucModel');
            $model->themDanhMuc($TenDM);
        }
        header('Location: /websitebanhangtaphoa/Admin/sanpham');
        exit;
    }

    // Sửa danh mục
    public function suaDanhMuc($MaDM) {
        $model = $this->model('DanhMucModel');
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['TenDM'])) {
            $TenDM = trim($_POST['TenDM']);
            $model->suaDanhMuc($MaDM, $TenDM);
            header('Location: /websitebanhangtaphoa/Admin/sanpham');
            exit;
        } else {
            $danhmuc = $model->layDanhMucTheoId($MaDM);
            $this->view('Pages/sua_danhmuc_v', ['danhmuc' => $danhmuc]);
        }
    }

    // Xóa danh mục
    public function xoaDanhMuc($MaDM) {
        $model = $this->model('DanhMucModel');
        $model->xoaDanhMuc($MaDM);
        header('Location: /websitebanhangtaphoa/Admin/sanpham');
        exit;
    }

    // Tìm kiếm danh mục
    public function timKiemDanhMuc() {
        $keyword = $_GET['keyword'] ?? '';
        $model = $this->model('DanhMucModel');
        $dsDanhMuc = $model->timKiemDanhMuc($keyword);
        $sanphamModel = $this->model('SanPhamModel');
        $dsSanPham = $sanphamModel->layTatCaSanPham();
        $this->view('Pages/admin_sanpham_v', [
            'dsSanPham' => $dsSanPham,
            'dsDanhMuc' => $dsDanhMuc
        ]);
    }

    // Thêm sản phẩm
    public function themSanPham() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST'
            && !empty($_POST['TenSP'])
            && isset($_POST['Gia'], $_POST['SoLuong'], $_POST['MaDM'])) {
            $TenSP = trim($_POST['TenSP']);
            $Gia = floatval($_POST['Gia']);
            $SoLuong = intval($_POST['SoLuong']);
            $MoTa = $_POST['MoTa'] ?? '';
            $HinhAnh = $_POST['HinhAnh'] ?? '';
            $MaDM = intval($_POST['MaDM']);
            $model = $this->model('SanPhamModel');
            $model->themSanPham($TenSP, $Gia, $SoLuong, $MoTa, $HinhAnh, $MaDM);
        }
        header('Location: /websitebanhangtaphoa/Admin/sanpham');
        exit;
    }

    // Sửa sản phẩm
    public function suaSanPham($MaSP) {
        $model = $this->model('SanPhamModel');
        if ($_SERVER['REQUEST_METHOD'] == 'POST'
            && !empty($_POST['TenSP'])
            && isset($_POST['Gia'], $_POST['SoLuong'], $_POST['MaDM'])) {
            $TenSP = trim($_POST['TenSP']);
            $Gia = floatval($_POST['Gia']);
            $SoLuong = intval($_POST['SoLuong']);
            $MoTa = $_POST['MoTa'] ?? '';
            $HinhAnh = $_POST['HinhAnh'] ?? '';
            $MaDM = intval($_POST['MaDM']);
            $model->suaSanPham($MaSP, $TenSP, $Gia, $SoLuong, $MoTa, $HinhAnh, $MaDM);
            header('Location: /websitebanhangtaphoa/Admin/sanpham');
            exit;
        } else {
            $sanpham = $model->laySanPhamTheoId($MaSP);
            $this->view('Pages/sua_sanpham_v', ['sanpham' => $sanpham]);
        }
    }

    // Xóa sản phẩm
    public function xoaSanPham($MaSP) {
        $model = $this->model('SanPhamModel');
        $model->xoaSanPham($MaSP);
        header('Location: /websitebanhangtaphoa/Admin/sanpham');
        exit;
    }

    // Tìm kiếm sản phẩm
    public function timKiemSanPham() {
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $model = $this->model('SanPhamModel');
        $dsSanPham = $model->timKiemSanPham($keyword);
        $danhmucModel = $this->model('DanhMucModel');
        $dsDanhMuc = $danhmucModel->layTatCaDanhMuc();
        $this->view('Pages/admin_sanpham_v', [
            'dsSanPham' => $dsSanPham,
            'dsDanhMuc' => $dsDanhMuc
        ]);
    }
}
?>
