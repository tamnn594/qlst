<?php
class DanhMucModel extends connectDB {
    public function themDanhMuc($TenDM) {
        $sql = "INSERT INTO danhmuc (TenDM) VALUES (?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $TenDM);
        return $stmt->execute();
    }

    public function layTatCaDanhMuc() {
        $sql = "SELECT * FROM danhmuc";
        $stmt = $this->con->prepare($sql);
        if (!$stmt) return false;
        if (!$stmt->execute()) return false;
        $result = $stmt->get_result();
        if (!$result) return [];
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function layDanhMucTheoId($MaDM) {
        $sql = "SELECT * FROM danhmuc WHERE MaDM = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $MaDM);
        if (!$stmt->execute()) return false;
        return $stmt->get_result()->fetch_assoc() ?: null;
    }

    public function suaDanhMuc($MaDM, $TenDM) {
        $sql = "UPDATE danhmuc SET TenDM = ? WHERE MaDM = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("si", $TenDM, $MaDM);
        $stmt->execute();
        // Kiểm tra số dòng bị ảnh hưởng để xác nhận cập nhật thành công
        return $stmt->affected_rows > 0;
    }

    public function xoaDanhMuc($MaDM) {
        $sql = "DELETE FROM danhmuc WHERE MaDM = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $MaDM);
        return $stmt->execute();
    }

    public function timKiemDanhMuc($keyword) {
        $sql = "SELECT * FROM danhmuc WHERE TenDM LIKE ?";
        $stmt = $this->con->prepare($sql);
        $like = '%' . $keyword . '%';
        $stmt->bind_param("s", $like);
        if (!$stmt->execute()) return [];
        $result = $stmt->get_result();
        if (!$result) return [];
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>