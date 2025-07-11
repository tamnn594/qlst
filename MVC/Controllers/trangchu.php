<?php
class trangchu extends controller {
    function Get_data() {
        // Lấy dữ liệu danh mục và sản phẩm nếu cần
        $danhmucModel = $this->model('DanhMucModel');
        $sanphamModel = $this->model('SanPhamModel');
        $dsDanhMuc = $danhmucModel->layTatCaDanhMuc();
        $dsSanPham = $sanphamModel->layTatCaSanPham();

        $this->view('Pages/trangchu_v', [
            'dsDanhMuc' => $dsDanhMuc,
            'dsSanPham' => $dsSanPham
        ]);
    }
    public function locdanhmuc($MaDM) {
        $sanphamModel = $this->model('SanPhamModel');
        $danhmucModel = $this->model('DanhMucModel');
        $dsSanPham = $sanphamModel->laySanPhamTheoDanhMuc($MaDM);
        $dsDanhMuc = $danhmucModel->layTatCaDanhMuc();
        // Sử dụng đúng view trangchu_v để không bắt đăng nhập và giao diện đồng bộ
        $this->view('Pages/trangchu_v', [
            'dsSanPham' => $dsSanPham,
            'dsDanhMuc' => $dsDanhMuc,
            'MaDM' => $MaDM
        ]);
    }
}
?>
