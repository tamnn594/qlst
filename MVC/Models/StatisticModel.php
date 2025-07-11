<?php
require_once __DIR__ . '/../Core/connectDB.php';

class StatisticModel extends connectDB {
    public function __construct() {
        parent::__construct(); // Gọi constructor của lớp cha để có $this->con
        mysqli_select_db($this->con, 'quanlysieuthi'); // Chọn database cho module này
        mysqli_query($this->con, "SET NAMES 'utf8'"); // Đảm bảo làm việc với UTF-8
    }

    // 1. Thống kê tổng doanh thu
    public function getTotalRevenue(): float {
        $query = "SELECT SUM(TongTien) AS TotalRevenue FROM DonHang WHERE TrangThai = 'Đã giao'";
        $result = $this->con->query($query);
        if ($result && $row = $result->fetch_assoc()) {
            return (float)($row['TotalRevenue'] ?? 0);
        }
        return 0.0;
    }

    // 2. Thống kê doanh thu theo tháng (trong năm hiện tại)
    public function getMonthlyRevenue(int $year): array {
        $query = "SELECT MONTH(NgayDat) AS Month, SUM(TongTien) AS MonthlyRevenue 
                  FROM DonHang 
                  WHERE YEAR(NgayDat) = ? AND TrangThai = 'Đã giao'
                  GROUP BY MONTH(NgayDat) 
                  ORDER BY Month";
        /** @var mysqli_stmt $stmt */
        $stmt = $this->con->prepare($query);
        if (!$stmt) {
            error_log("Prepare getMonthlyRevenue failed: " . $this->con->error);
            return [];
        }
        $stmt->bind_param('i', $year);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    
    // 3. Thống kê số lượng đơn hàng theo trạng thái
    public function getOrderCountByStatus(): array {
        $query = "SELECT TrangThai, COUNT(*) AS OrderCount FROM DonHang GROUP BY TrangThai";
        $result = $this->con->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    // 4. Top sản phẩm bán chạy nhất (theo số lượng)
    public function getTopSellingProducts(int $limit = 5): array {
        $query = "SELECT sp.MaSP, sp.TenSP, SUM(ctdh.SoLuong) AS TotalQuantitySold 
                  FROM ChiTietDonHang ctdh
                  JOIN SanPham sp ON ctdh.MaSP = sp.MaSP
                  JOIN DonHang dh ON ctdh.MaDH = dh.MaDH
                  WHERE dh.TrangThai = 'Đã giao'
                  GROUP BY sp.MaSP, sp.TenSP
                  ORDER BY TotalQuantitySold DESC
                  LIMIT ?";
        /** @var mysqli_stmt $stmt */
        $stmt = $this->con->prepare($query);
        if (!$stmt) {
            error_log("Prepare getTopSellingProducts failed: " . $this->con->error);
            return [];
        }
        $stmt->bind_param('i', $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // 5. Top sản phẩm có doanh thu cao nhất
    public function getTopRevenueProducts(int $limit = 5): array {
        $query = "SELECT sp.MaSP, sp.TenSP, SUM(ctdh.SoLuong * ctdh.DonGia) AS TotalRevenue
                  FROM ChiTietDonHang ctdh
                  JOIN SanPham sp ON ctdh.MaSP = sp.MaSP
                  JOIN DonHang dh ON ctdh.MaDH = dh.MaDH
                  WHERE dh.TrangThai = 'Đã giao'
                  GROUP BY sp.MaSP, sp.TenSP
                  ORDER BY TotalRevenue DESC
                  LIMIT ?";
        /** @var mysqli_stmt $stmt */
        $stmt = $this->con->prepare($query);
        if (!$stmt) {
            error_log("Prepare getTopRevenueProducts failed: " . $this->con->error);
            return [];
        }
        $stmt->bind_param('i', $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // 6. Top khách hàng mua nhiều nhất (theo tổng tiền)
    public function getTopSpendingCustomers(int $limit = 5): array {
        $query = "SELECT kh.MaKH, kh.HoTen, SUM(dh.TongTien) AS TotalSpent
                  FROM DonHang dh
                  JOIN KhachHang kh ON dh.MaKH = kh.MaKH
                  WHERE dh.TrangThai = 'Đã giao'
                  GROUP BY kh.MaKH, kh.HoTen
                  ORDER BY TotalSpent DESC
                  LIMIT ?";
        /** @var mysqli_stmt $stmt */
        $stmt = $this->con->prepare($query);
        if (!$stmt) {
            error_log("Prepare getTopSpendingCustomers failed: " . $this->con->error);
            return [];
        }
        $stmt->bind_param('i', $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Lấy tất cả các năm có đơn hàng
    public function getAvailableYears(): array {
        $query = "SELECT DISTINCT YEAR(NgayDat) AS Year FROM DonHang ORDER BY Year DESC";
        $result = $this->con->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
}
?>