<?php
class OrderModel extends connectDB{
    // Ghi đè constructor để chọn đúng database 'quanlysieuthi'
    // mà không cần sửa file connectDB.php gốc.
    public function __construct() {
        parent::__construct(); // Gọi constructor của lớp cha để có $this->con
        mysqli_select_db($this->con, 'quanlysieuthi'); // Chọn database cho module này
        mysqli_query($this->con, "SET NAMES 'utf8'"); // Đảm bảo làm việc với UTF-8
    }

    // Lấy tất cả đơn hàng, có thể join với KhachHang để lấy tên khách hàng
    public function getAllOrders(): array {
        // Sửa từ kh.TenKH thành kh.HoTen
        $query = "SELECT dh.*, kh.HoTen FROM donhang dh JOIN khachhang kh ON dh.MaKH = kh.MaKH ORDER BY dh.NgayDat DESC";
        $result = $this->con->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    // Lấy thông tin một đơn hàng theo MaDH
    public function getOrderById($maDH): ?array {
        // Sửa từ kh.TenKH thành kh.HoTen
        $query = "SELECT dh.*, kh.HoTen FROM donhang dh JOIN khachhang kh ON dh.MaKH = kh.MaKH WHERE dh.MaDH = ?";
        /** @var mysqli_stmt $stmt */
        $stmt = $this->con->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->con->error);
            return null;
        }
        $stmt->bind_param('i', $maDH);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    // Lấy chi tiết của một đơn hàng (các sản phẩm trong đơn hàng)
    public function getOrderDetails($maDH): array {
        $query = "SELECT ctdh.*, sp.TenSP FROM chitietdonhang ctdh JOIN sanpham sp ON ctdh.MaSP = sp.MaSP WHERE ctdh.MaDH = ?";
        /** @var mysqli_stmt $stmt */
        $stmt = $this->con->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->con->error);
            return [];
        }
        $stmt->bind_param('i', $maDH);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    // Thêm đơn hàng mới
    public function addOrder($maKH, $tongTien, $trangThai, $phuongThucTT, $hinhThucGH): int|false {
        $query = "INSERT INTO donhang (MaKH, TongTien, TrangThai, PhuongThucThanhToan, HinhThucGiaoHang) VALUES (?, ?, ?, ?, ?)";
        /** @var mysqli_stmt $stmt */
        $stmt = $this->con->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->con->error);
            return false;
        }
        $stmt->bind_param('idsss', $maKH, $tongTien, $trangThai, $phuongThucTT, $hinhThucGH);

        if ($stmt->execute()) {
            return $this->con->insert_id;
        }
        error_log("Execute failed: " . $stmt->error);
        return false;
    }

    // Cập nhật đơn hàng
    public function updateOrder($maDH, $maKH, $ngayDat, $tongTien, $trangThai, $phuongThucTT, $hinhThucGH): bool {
        $query = "UPDATE donhang SET MaKH = ?, NgayDat = ?, TongTien = ?, TrangThai = ?, PhuongThucThanhToan = ?, HinhThucGiaoHang = ? WHERE MaDH = ?";
        /** @var mysqli_stmt $stmt */
        $stmt = $this->con->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->con->error);
            return false;
        }
        $stmt->bind_param('isdsssi', $maKH, $ngayDat, $tongTien, $trangThai, $phuongThucTT, $hinhThucGH, $maDH);
        return $stmt->execute();
    }

    // Xóa đơn hàng (cần xóa chi tiết đơn hàng trước)
    public function deleteOrder($maDH): bool {
    // Xóa chi tiết đơn hàng trước
    $sql1 = "DELETE FROM chitietdonhang WHERE MaDH = ?";
    $stmt1 = $this->con->prepare($sql1);
    if (!$stmt1) return false;
    $stmt1->bind_param("i", $maDH);
    if (!$stmt1->execute()) return false;

    // Sau đó mới xóa đơn hàng
    $sql2 = "DELETE FROM donhang WHERE MaDH = ?";
    $stmt2 = $this->con->prepare($sql2);
    if (!$stmt2) return false;
    $stmt2->bind_param("i", $maDH);
    return $stmt2->execute();
}


    // Tìm kiếm đơn hàng
    public function searchOrders($keyword): array {
        $searchKeyword = '%' . $keyword . '%';
        $query = "SELECT dh.*, kh.HoTen FROM donhang dh JOIN khachhang kh ON dh.MaKH = kh.MaKH
                  WHERE dh.MaDH LIKE ? OR kh.HoTen LIKE ? OR dh.TrangThai LIKE ? OR dh.PhuongThucThanhToan LIKE ? OR dh.HinhThucGiaoHang LIKE ?
                  ORDER BY dh.NgayDat DESC";
        /** @var mysqli_stmt $stmt */
        $stmt = $this->con->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->con->error);
            return [];
        }
        $stmt->bind_param('sssss', $searchKeyword, $searchKeyword, $searchKeyword, $searchKeyword, $searchKeyword);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    // Lấy danh sách khách hàng (cho dropdown khi thêm/sửa đơn hàng)
    public function getAllCustomers(): array {
        $query = "SELECT MaKH, HoTen FROM khachhang"; // Sửa từ TenKH thành HoTen
        $result = $this->con->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
}