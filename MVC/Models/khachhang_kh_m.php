<?php 
class khachhang_kh_m extends connectDB{
    public function insert($makhachhang, $tendangnhap,$matkhau,$tenkhachhang, $gioitinh, $ngaysinh,$email,$dienthoai,$diachi){
        $sql="INSERT INTO khachhang VALUES ('$makhachhang', '$tendangnhap','$matkhau','$tenkhachhang', '$gioitinh', '$ngaysinh','$email','$dienthoai','$diachi')";
        return mysqli_query($this->con,$sql);
    }
    // public function all(){
    //     $sql="SELECT * From khachhang";
    //     return mysqli_query($this->con,$sql);
    // }
    // function checktrungma($matacgia){
    //     $sql="SELECT * From tacgia Where MaTacGia='$matacgia'";
    //     $dl=mysqli_query($this->con,$sql);
    //     $kq=false;
    //     if(mysqli_num_rows($dl)>0){
    //         $kq=true;  //trùng mã
    //     }
    //     return $kq;
    // }
    function checktrungemail($email){
        $sql="SELECT * From khachhang Where Email='$email'";
        $dl=mysqli_query($this->con,$sql);
        $kq=false;
        if(mysqli_num_rows($dl)>0){
            $kq=true;  //trùng 
        }
        return $kq;
    }
    function checkrong($tendangnhap,$matkhau,$tenkhachhang,$email,$dienthoai,$diachi){
        if(empty($tendangnhap) || empty($matkhau)|| empty($tenkhachhang)|| empty($email)||empty($dienthoai)||empty($diachi)){
            return true; // Có trường dữ liệu rỗng
        } else {
            return false; // Không có trường dữ liệu rỗng
        }
    }
    function checkrong_dangnhap($matkhau,$email,){
        if(empty($email) || empty($matkhau)){
            return true; // Có trường dữ liệu rỗng
        } else {
            return false; // Không có trường dữ liệu rỗng
        }
    }
    // function find($matacgia,$tentacgia){
    //     $sql="SELECT * FROM tacgia WHERE MaTacGia like N'%$matacgia%' or TenTacGia like N'%$tentacgia%' ";
    //     return mysqli_query($this->con,$sql);
    // }
    // function find_2dk($matacgia,$tentacgia){
    //     $sql="SELECT * FROM tacgia WHERE MaTacGia like N'%$matacgia%' and TenTacGia like N'%$tentacgia%' ";
    //     return mysqli_query($this->con,$sql);
    // }
    // function find2($matacgia){
    //     $sql="SELECT * FROM tacgia WHERE MaTacGia = N'$matacgia' ";
    //     return mysqli_query($this->con,$sql);
    // }
    function delete($makhachhang){
        $sql="DELETE FROM khachhang WHERE MaKH= N'$makhachhang'";
        return mysqli_query($this->con,$sql);
    }
    // function delete_thanhphan($matacgia){//thực hiện xóa các sách có mã tác giả nếu tác giả đó bị xóa
    //     $sql="DELETE FROM sach WHERE MaTacGia= N'$matacgia'";
    //     return mysqli_query($this->con,$sql);
    // }
    function update2($tenkhachhang, $gioitinh, $ngaysinh,$email,$dienthoai,$diachi){
        $sql="UPDATE khachhang SET HoTen='$tenkhachhang',GioiTinh='$gioitinh', NgaySinh='$ngaysinh',Email='$email', SDT='$dienthoai',DiaChi='$diachi' WHERE Email='$email'";
        return mysqli_query($this->con,$sql);
    }
    function update_doimk($makhachhang, $matkhau){
        $sql="UPDATE khachhang SET MatKhau=? WHERE MaKH=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("si", $matkhau, $makhachhang);
        return $stmt->execute();
    }

    public function login($email, $matkhau){
        $sql = "SELECT * FROM khachhang WHERE Email = '$email' AND MatKhau = '$matkhau'";
        $result = mysqli_query($this->con, $sql);
        return mysqli_fetch_assoc($result); // Trả về thông tin khách hàng nếu đăng nhập đúng
    }
    function update_quenmk($email,$matkhau){
        $sql="UPDATE khachhang SET MatKhau='$matkhau' WHERE Email='$email'";
        return mysqli_query($this->con,$sql);
    }

    public function getUserByUsername($username) {
        $sql = "SELECT * FROM khachhang WHERE TenDangNhap = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $username);
        if (!$stmt->execute()) return null;
        $result = $stmt->get_result();
        return $result ? $result->fetch_assoc() : null;
    }

    public function getUserByEmail($email) {
        $sql = "SELECT * FROM khachhang WHERE Email = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $email);
        if (!$stmt->execute()) return null;
        $result = $stmt->get_result();
        return $result ? $result->fetch_assoc() : null;
    }

    // Giữ lại duy nhất hàm update sử dụng prepare/bind_param đúng chuẩn:
    public function update($hoten, $gioitinh, $ngaysinh, $email, $sdt, $diachi, $emailCu) {
        $sql = "UPDATE khachhang SET HoTen=?, GioiTinh=?, NgaySinh=?, Email=?, SDT=?, DiaChi=? WHERE Email=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("sssssss", $hoten, $gioitinh, $ngaysinh, $email, $sdt, $diachi, $emailCu);
        return $stmt->execute();
    }

}
?>