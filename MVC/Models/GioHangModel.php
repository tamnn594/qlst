<?php
class GioHangModel extends connectDB {
    // Lấy hoặc tạo giỏ hàng cho khách
    public function layHoacTaoGioHang($maKH) {
        $sql = "SELECT MaGH FROM GioHang WHERE MaKH = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $maKH);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row['MaGH'];
        }
        // Nếu chưa có, tạo mới
        $sql = "INSERT INTO GioHang (MaKH) VALUES (?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $maKH);
        $stmt->execute();
        return $this->con->insert_id;
    }

    // Thêm hoặc cập nhật sản phẩm trong giỏ hàng
    public function themHoacCapNhatSanPham($maGH, $maSP, $soLuong) {
        // Kiểm tra đã có sản phẩm trong giỏ chưa
        $sql = "SELECT SoLuong FROM ChiTietGioHang WHERE MaGH = ? AND MaSP = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ii", $maGH, $maSP);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            // Cập nhật số lượng
            $sql = "UPDATE ChiTietGioHang SET SoLuong = SoLuong + ? WHERE MaGH = ? AND MaSP = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("iii", $soLuong, $maGH, $maSP);
            return $stmt->execute();
        } else {
            // Thêm mới
            $sql = "INSERT INTO ChiTietGioHang (MaGH, MaSP, SoLuong) VALUES (?, ?, ?)";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("iii", $maGH, $maSP, $soLuong);
            return $stmt->execute();
        }
    }

    // Lấy chi tiết giỏ hàng theo MaKH
    public function layChiTietGioHangTheoMaKH($maKH) {
        $sql = "SELECT gh.MaGH, ct.MaSP, ct.SoLuong, sp.TenSP, sp.Gia, sp.HinhAnh
                FROM GioHang gh
                JOIN ChiTietGioHang ct ON gh.MaGH = ct.MaGH
                JOIN SanPham sp ON ct.MaSP = sp.MaSP
                WHERE gh.MaKH = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $maKH);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function xoaSanPham($maGH, $maSP) {
        $sql = "DELETE FROM ChiTietGioHang WHERE MaGH = ? AND MaSP = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ii", $maGH, $maSP);
        return $stmt->execute();
    }
}
?>
