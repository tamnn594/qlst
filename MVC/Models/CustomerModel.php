<?php
class CustomerModel extends connectDB {

    // Ghi đè constructor để chọn đúng database 'quanlysieuthi'
    // mà không cần sửa file connectDB.php gốc.
    public function __construct() {
        parent::__construct(); // Gọi constructor của lớp cha để có $this->con
        mysqli_select_db($this->con, 'quanlysieuthi'); // Chọn database cho module này
        mysqli_query($this->con, "SET NAMES 'utf8'"); // Đảm bảo làm việc với UTF-8
    }

    public function getAllCustomers() {
        $sql = "SELECT * FROM khachhang ORDER BY MaKH DESC";
        $result = mysqli_query($this->con, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function searchCustomers($keyword) {
        // Câu lệnh SQL có 4 dấu '?'
        $sql = "SELECT * FROM khachhang WHERE HoTen LIKE ? OR Email LIKE ? OR SDT LIKE ? OR DiaChi LIKE ? ORDER BY MaKH DESC";
        $stmt = mysqli_prepare($this->con, $sql);
        $searchKeyword = "%" . $keyword . "%";
        
        // === ĐÃ SỬA LỖI TẠI ĐÂY ===
        // Cung cấp 4 kiểu dữ liệu ("ssss") và 4 biến cho 4 dấu '?'
        mysqli_stmt_bind_param($stmt, "ssss", 
            $searchKeyword, 
            $searchKeyword, 
            $searchKeyword, 
            $searchKeyword
        );

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getCustomerById($id) {
        $sql = "SELECT * FROM khachhang WHERE MaKH = ?";
        $stmt = mysqli_prepare($this->con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }

    public function createCustomer($data) {
        $sql = "INSERT INTO khachhang (TenDangNhap, MatKhau, HoTen, Email, SDT, DiaChi) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->con, $sql);
        mysqli_stmt_bind_param($stmt, "ssssss", 
            $data['username'],
            $data['password'],
            $data['fullname'],
            $data['email'],
            $data['phone'],
            $data['address']
        );
        return mysqli_stmt_execute($stmt);
    }

    // THÊM PHƯƠNG THỨC NÀY VÀO TRONG CLASS CustomerModel CỦA TỆP CustomerModel.php

/**
 * Cập nhật thông tin khách hàng trong cơ sở dữ liệu.
 * @param int $id ID của khách hàng cần cập nhật.
 * @param array $data Dữ liệu mới của khách hàng.
 * @return bool Trả về true nếu cập nhật thành công, false nếu thất bại.
 */
public function updateCustomer($id, $data) {
    // Để đảm bảo tính toàn vẹn dữ liệu, hãy kiểm tra xem Tên đăng nhập mới có bị trùng
    // với một người dùng khác không.
    $checkSql = "SELECT MaKH FROM khachhang WHERE TenDangNhap = ? AND MaKH != ?";
    $checkStmt = mysqli_prepare($this->con, $checkSql);
    mysqli_stmt_bind_param($checkStmt, "si", $data['username'], $id);
    mysqli_stmt_execute($checkStmt);
    $result = mysqli_stmt_get_result($checkStmt);

    // Nếu tìm thấy Tên đăng nhập đã tồn tại ở một khách hàng khác, trả về false
    if (mysqli_num_rows($result) > 0) {
        return false;
    }

    // Nếu không trùng, tiến hành cập nhật
    $sql = "UPDATE khachhang 
            SET TenDangNhap = ?, MatKhau = ?, HoTen = ?, Email = ?, SDT = ?, DiaChi = ? 
            WHERE MaKH = ?";
            
    $stmt = mysqli_prepare($this->con, $sql);
    
    // Ràng buộc các tham số vào câu lệnh prepared statement
    mysqli_stmt_bind_param($stmt, "ssssssi", 
        $data['username'],
        $data['password'],
        $data['fullname'],
        $data['email'],
        $data['phone'],
        $data['address'],
        $id
    );
    
    // Thực thi câu lệnh và trả về kết quả (true/false)
    return mysqli_stmt_execute($stmt);
}


    public function hasOrders($customerId) {
        $sql = "SELECT MaDH FROM donhang WHERE MaKH = ? LIMIT 1";
        $stmt = mysqli_prepare($this->con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $customerId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_num_rows($result) > 0;
    }

    public function deleteCustomer($id) {
        if ($this->hasOrders($id)) {
            return false; // Không xóa nếu có đơn hàng
        }
        $sql = "DELETE FROM khachhang WHERE MaKH = ?";
        $stmt = mysqli_prepare($this->con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        return mysqli_stmt_execute($stmt);
    }

    public function getCustomerOrders($customerId) {
        $sql = "SELECT * FROM donhang WHERE MaKH = ? ORDER BY NgayDat DESC";
        $stmt = mysqli_prepare($this->con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $customerId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getOrderDetails($orderId) {
        $sql = "SELECT ct.*, sp.TenSP, sp.HinhAnh 
                FROM chitietdonhang ct
                JOIN sanpham sp ON ct.MaSP = sp.MaSP
                WHERE ct.MaDH = ?";
        $stmt = mysqli_prepare($this->con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $orderId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
?>
