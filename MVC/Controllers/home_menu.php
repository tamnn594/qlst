<?php
class home_menu extends controller {
    public function Get_data() {
        $sanphamModel = $this->model('SanPhamModel');
        $danhmucModel = $this->model('DanhMucModel');
        $dsSanPham = $sanphamModel->layTatCaSanPham();
        $dsDanhMuc = $danhmucModel->layTatCaDanhMuc();
        $this->view('Masterlayout', [
            'dsSanPham' => $dsSanPham,
            'dsDanhMuc' => $dsDanhMuc
        ]);
    }

    public function timkiem() {
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $sanphamModel = $this->model('SanPhamModel');
        $danhmucModel = $this->model('DanhMucModel');

        $dsSanPham = [];
        if (!empty($keyword)) {
            $dsSanPham = $sanphamModel->timKiemSanPham($keyword);
            if (empty($dsSanPham)) {
                $_SESSION['search_notification'] = "Không tìm thấy sản phẩm nào phù hợp với từ khóa '$keyword'";
            }
        } else {
            $dsSanPham = $sanphamModel->layTatCaSanPham();
        }
        
        $dsDanhMuc = $danhmucModel->layTatCaDanhMuc();
        
        $this->view('Masterlayout', [
            'page' => 'search',
            'dsSanPham' => $dsSanPham,
            'dsDanhMuc' => $dsDanhMuc,
            'keyword' => $keyword,
            'notification' => $_SESSION['search_notification'] ?? null
        ]);
        
        // Xóa notification sau khi hiển thị
        if (isset($_SESSION['search_notification'])) {
            unset($_SESSION['search_notification']);
        }
    }

    public function locdanhmuc($MaDM) {
        $sanphamModel = $this->model('SanPhamModel');
        $danhmucModel = $this->model('DanhMucModel');
        $dsSanPham = $sanphamModel->laySanPhamTheoDanhMuc($MaDM);
        $dsDanhMuc = $danhmucModel->layTatCaDanhMuc();
        $this->view('Masterlayout', [
            'dsSanPham' => $dsSanPham,
            'dsDanhMuc' => $dsDanhMuc,
            'MaDM' => $MaDM
        ]);
    }
}
?>