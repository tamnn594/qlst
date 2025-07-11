<?php
class AuthModel extends connectDB {

    public function __construct() {
        parent::__construct();
        mysqli_select_db($this->con, 'quanlysieuthi');
        mysqli_query($this->con, "SET NAMES 'utf8'");
    }

    /**
     * Kiểm tra thông tin đăng nhập của Admin.
     */
    public function checkAdminLogin($username, $password) {
        $sql = "SELECT * FROM taikhoanadmin WHERE TenDangNhap = ?";
        $stmt = mysqli_prepare($this->con, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($admin = mysqli_fetch_assoc($result)) {
            // So sánh mật khẩu plain text (KHÔNG KHUYẾN KHÍCH)
            if ($password === $admin['MatKhau']) {
                return $admin; // Đăng nhập thành công
            }
        }
        return false; // Sai tên đăng nhập hoặc mật khẩu
    }

    /**
     * Lưu user ID vào bảng 'user' theo yêu cầu.
     * Hàm này sẽ xóa hết dữ liệu cũ và chèn user mới.
     */
    public function storeLoggedInUser($userId) {
        // Xóa tất cả user cũ trong bảng
        $sqlDelete = "DELETE FROM user";
        mysqli_query($this->con, $sqlDelete);

        // Chèn user mới đăng nhập
        $sqlInsert = "INSERT INTO user (user) VALUES (?)";
        $stmt = mysqli_prepare($this->con, $sqlInsert);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $userId);
            return mysqli_stmt_execute($stmt);
        } else {
            // Ghi log hoặc xử lý lỗi ở đây nếu cần
            // error_log("MySQL Prepare failed: " . mysqli_error($this->con));
        }
        return false;
    }
}
?>
