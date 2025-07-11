<?php 
class thongtincanhan_kh_c extends controller {
    private $khachhangModel;

    function __construct() {
        $this->khachhangModel = $this->model('khachhang_kh_m');
    }

    function Get_data() {
        // Lấy email từ session
        $email = $_SESSION['email'] ?? ($_SESSION['username'] ?? null);
        $user = null;
        if ($email) {
            $user = $this->khachhangModel->getUserByEmail($email);
        }
        $this->view('space', [
            'page' => 'thongtincanhan_kh_v',
            'user' => $user
        ]);
    }

    function sua() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnsua'])) {
            $hoten = trim($_POST['HoTen']);
            $email = trim($_POST['Email']);
            $sdt = trim($_POST['SDT']);
            $gioitinh = trim($_POST['GioiTinh']);
            $ngaysinh = trim($_POST['NgaySinh']);
            $diachi = trim($_POST['DiaChi']);

            // Email gốc từ session để làm điều kiện WHERE
            $emailCu = $_SESSION['email'] ?? ($_SESSION['username'] ?? '');

            // Đảm bảo model khachhang_kh_m có hàm update($hoten, $gioitinh, $ngaysinh, $email, $sdt, $diachi, $emailCu)
            $kq = $this->khachhangModel->update($hoten, $gioitinh, $ngaysinh, $email, $sdt, $diachi, $emailCu);

            if ($kq) {
                $_SESSION['email'] = $email; // Cập nhật email nếu đổi
                echo "<script>alert('Cập nhật thành công!');</script>";
            } else {
                echo "<script>alert('Cập nhật thất bại!');</script>";
            }

            // Lấy lại thông tin mới để hiển thị
            $user = $this->khachhangModel->getUserByEmail($email);
            $this->view('space', [
                'page' => 'thongtincanhan_kh_v',
                'user' => $user
            ]);
        }
    }

    public function doimatkhau() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_SESSION['email'] ?? ($_SESSION['username'] ?? '');
            $old = $_POST['old_password'] ?? '';
            $new = $_POST['new_password'] ?? '';
            $renew = $_POST['renew_password'] ?? '';
            $user = $this->khachhangModel->getUserByEmail($email);

            if (!$user || $user['MatKhau'] !== $old) {
                echo "<script>alert('Mật khẩu cũ không đúng!');window.history.back();</script>";
                return;
            }
            if ($new !== $renew) {
                echo "<script>alert('Mật khẩu mới không khớp!');window.history.back();</script>";
                return;
            }
            if ($old === $new) {
                echo "<script>alert('Mật khẩu mới phải khác mật khẩu cũ!');window.history.back();</script>";
                return;
            }
            $kq = $this->khachhangModel->update_doimk($user['MaKH'], $new);
            if ($kq) {
                echo "<script>alert('Đổi mật khẩu thành công!');window.location.href='/websitebanhangtaphoa/dangnhap_kh_c/logout';</script>";
            } else {
                echo "<script>alert('Đổi mật khẩu thất bại!');window.history.back();</script>";
            }
        }
    }
}
?>
