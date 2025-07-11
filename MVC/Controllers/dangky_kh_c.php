<?php 
class dangky_kh_c extends controller{
    private $dangky;
    
    function __construct()
    {
        $this->dangky = $this->model('khachhang_kh_m');
        // $this->muonsach = $this->model('muonsach_m');
    }
    function Get_data(){
        $this->view('space',[
            'page'=>'dangky_kh_v'
        ]);
    }
    function dangky() {
        if (isset($_POST['btnLuu'])) {
            $email = $_POST['email'];
            $matkhau = $_POST['matkhau'];
            $hoten = $_POST['hoten'];
            $gioitinh = $_POST['gioitinh'];
            $ngaysinh = $_POST['ngaysinh'];
            $dienthoai = $_POST['sdt'];
            $diachi = $_POST['diachi'];
            
           // Kiểm tra trùng mã
            $kq1 = $this->dangky->checktrungemail($email);

            //Kiểm tra các trường dữ liệu rỗng
            $kq2 = $this->dangky->checkrong($email,$matkhau,$hoten,$email,$dienthoai,$diachi);
            
            if ($kq1) {
                echo "<script>alert('Trùng email!')</script>";

            }
            elseif ($kq2) {
                echo "<script>alert('Không để trống dữ liệu!')</script>";
            } else {
                // Chèn dữ liệu nếu không trùng mã và không có trường dữ liệu rỗng
                $kq = $this->dangky->insert(null,$email,$matkhau,$hoten, $gioitinh, $ngaysinh,$email,$dienthoai,$diachi);
                
                if ($kq) {
                    echo "<script>alert('Thêm mới thành công!')</script>";
                    // Chuyển về trang đăng nhập sau khi đăng ký thành công
                    $this->view('space', [
                        'page' => 'dangnhap_kh_v',
                    ]);
                    return;
                } else {
                    echo "<script>alert('Thêm mới thất bại!')</script>";
                }
            }
            
            // Tái render view với dữ liệu đã cung cấp (chỉ khi thất bại)
            $this->view('Masterlayout', [
                'page' => 'dangky_kh_v',
            ]);
        }
    }

}
?>