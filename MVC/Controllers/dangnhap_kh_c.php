<?php 
class dangnhap_kh_c extends controller{
    private $dangnhap;

    function __construct()
    {
        $this->dangnhap = $this->model('khachhang_kh_m');
       
    }

    function Get_data(){
        // Hiển thị trang đăng nhập trước, không load Masterlayout
        $this->view('space', [
            'page' => 'dangnhap_kh_v'
        ]);
    }

    function dangnhap(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            // Kiểm tra tài khoản hoặc mật khẩu rỗng
            if ($this->dangnhap->checkrong_dangnhap($username, $password)) {
                echo "<script>alert('Tên đăng nhập hoặc mật khẩu không được để trống!')</script>";
                $this->view('space', [
                    'page' => 'dangnhap_kh_v',
                ]);
                return;
            }

            // Kiểm tra đăng nhập
            $user = $this->dangnhap->login($username, $password);
            if ($user) {
                echo "<script>alert('Đăng nhập thành công!')</script>";
                $_SESSION['username'] = $username;
                // Lấy sản phẩm và danh mục để truyền sang Masterlayout
                $sanphamModel = $this->model('SanPhamModel');
                $danhmucModel = $this->model('DanhMucModel');
                $dsSanPham = $sanphamModel->layTatCaSanPham();
                $dsDanhMuc = $danhmucModel->layTatCaDanhMuc();
                $this->view('Masterlayout', [
                    'dsSanPham' => $dsSanPham,
                    'dsDanhMuc' => $dsDanhMuc,
                    'jsCountdown' => true
                ]);
            } else {
                echo "<script>alert('Sai tên đăng nhập hoặc mật khẩu!')</script>";
                $this->view('space', [
                    'page' => 'dangnhap_kh_v',
                ]);
            }
        } else {
            // Nếu không phải POST, luôn hiển thị trang đăng nhập
            $this->view('space', [
                'page' => 'dangnhap_kh_v'
            ]);
        }
    }

    public function timkiem() {
        $keyword = $_GET['keyword'] ?? '';
        $sanphamModel = $this->model('SanPhamModel');
        $danhmucModel = $this->model('DanhMucModel');
        // Nếu không nhập từ khóa thì trả về tất cả sản phẩm
        if (trim($keyword) === '') {
            $dsSanPham = $sanphamModel->layTatCaSanPham();
        } else {
            // Sửa lại để tìm kiếm không phân biệt hoa thường và bỏ dấu tiếng Việt
            $dsSanPham = $sanphamModel->timKiemSanPhamFullText($keyword);
            // Nếu không có hàm fulltext, fallback về LIKE
            if ($dsSanPham === false) {
                $dsSanPham = $sanphamModel->timKiemSanPham($keyword);
            }
        }
        $dsDanhMuc = $danhmucModel->layTatCaDanhMuc();
        $this->view('Masterlayout', [
            'dsSanPham' => $dsSanPham,
            'dsDanhMuc' => $dsDanhMuc,
            'keyword' => $keyword
        ]);
    }

    public function thongtincanhan() {
        // Lấy thông tin user từ session
        $email = $_SESSION['username'] ?? null;
        if ($email) {
            // Lấy thông tin user theo email
            $user = $this->dangnhap->getUserByEmail($email);
            $this->view('Pages/thongtincanhan_kh_v', [
                'user' => $user
            ]);
        } else {
            // Nếu chưa đăng nhập, chuyển về trang đăng nhập
            $this->view('space', ['page' => 'dangnhap_kh_v']);
        }
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_unset();
        session_destroy();
        header("Location: /websitebanhangtaphoa/");
        exit();
    }

}
?>