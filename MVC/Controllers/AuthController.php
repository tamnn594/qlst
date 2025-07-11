<?php
class AuthController extends controller {
    private $authModel;

    public function __construct() {
        $this->authModel = $this->model('AuthModel');
    }
    // Hiển thị form đăng nhập cho admin
    public function adminLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $admin = $this->authModel->checkAdminLogin($username, $password);

            if ($admin) {
                $_SESSION['admin_id'] = $admin['MaAdmin'];
                $_SESSION['admin_name'] = $admin['HoTen'];
                $this->authModel->storeLoggedInUser($admin['MaAdmin']);
                
                // === SỬA LỖI TẠI ĐÂY ===
                // Chỉ định rõ action 'index' của CustomerController khi chuyển hướng
                header('Location: ' . BASE_URL . '/Admin'); 
                exit();
            } else {
                $this->view('Pages/admin_login_v', ['error' => 'Sai tên đăng nhập hoặc mật khẩu!']);
            }
        } else {
            $this->view('Pages/admin_login_v');
        }
    }

    // Đăng xuất admin: hủy phiên và không thể quay lại trang quản trị
    public function adminLogout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL . '/AuthController/adminLogin');
        exit();
    }

    // Đăng xuất user thường (nếu có)
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL . '/AuthController/login');
        exit();
    }

    // Bắt buộc phải đăng nhập admin mới truy cập được
    public function requireAdminLogin() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ' . BASE_URL . '/AuthController/adminLogin');
            exit();
        }
    }
}
?>
