<?php
class SanPhamModel extends connectDB {
    public function themSanPham($TenSP, $Gia, $SoLuong, $MoTa, $HinhAnh, $MaDM) {
        $sql = "INSERT INTO sanpham (TenSP, Gia, SoLuong, MoTa, HinhAnh, MaDM) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("sdisss", $TenSP, $Gia, $SoLuong, $MoTa, $HinhAnh, $MaDM);
        return $stmt->execute();
    }

    public function layTatCaSanPham() {
        $sql = "SELECT * FROM sanpham";
        $stmt = $this->con->prepare($sql);
        if (!$stmt) return false;
        if (!$stmt->execute()) return false;
        $result = $stmt->get_result();
        if (!$result) return [];
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function laySanPhamTheoId($MaSP) {
        $sql = "SELECT * FROM sanpham WHERE MaSP = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $MaSP);
        if (!$stmt->execute()) return false;
        return $stmt->get_result()->fetch_assoc() ?: null;
    }

    public function suaSanPham($MaSP, $TenSP, $Gia, $SoLuong, $MoTa, $HinhAnh, $MaDM) {
        $sql = "UPDATE sanpham SET TenSP=?, Gia=?, SoLuong=?, MoTa=?, HinhAnh=?, MaDM=? WHERE MaSP=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("sdisssi", $TenSP, $Gia, $SoLuong, $MoTa, $HinhAnh, $MaDM, $MaSP);
        return $stmt->execute();
    }

    public function xoaSanPham($MaSP) {
        $sql = "DELETE FROM sanpham WHERE MaSP = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $MaSP);
        return $stmt->execute();
    }

    // Thêm hàm tìm kiếm fulltext nếu có index fulltext trên cột TenSP
    public function timKiemSanPhamFullText($keyword) {
        $sql = "SELECT * FROM sanpham WHERE MATCH(TenSP) AGAINST (? IN NATURAL LANGUAGE MODE)";
        $stmt = $this->con->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("s", $keyword);
        if (!$stmt->execute()) return false;
        $result = $stmt->get_result();
        if (!$result) return false;
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function timKiemSanPham($keyword) {
        $keyword = '%' . $keyword . '%';
        $sql = "SELECT * FROM sanpham WHERE 
                TenSP LIKE ? OR 
                MoTa LIKE ? OR
                MaSP LIKE ?";
        return $this->db->select($sql, [$keyword, $keyword, $keyword]);
    }

    public function laySanPhamTheoDanhMuc($MaDM) {
        $sql = "SELECT * FROM sanpham WHERE MaDM = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $MaDM);
        if (!$stmt->execute()) return [];
        $result = $stmt->get_result();
        if (!$result) return [];
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function capNhatSoLuong($MaSP, $SoLuongMoi) {
        $sql = "UPDATE sanpham SET SoLuong = ? WHERE MaSP = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ii", $SoLuongMoi, $MaSP);
        return $stmt->execute();
    }

    public function kiemTraTonTai($MaSP) {
        $sql = "SELECT COUNT(*) as count FROM sanpham WHERE MaSP = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $MaSP);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }
}
?>
