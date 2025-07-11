<?php
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký khách hàng - QuickMart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 60px; /* tăng từ 40px lên 60px */
            width: 100%;
            max-width: 650px; /* tăng từ 500px lên 650px */
            color: white;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
        }

        .register-container h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
        }

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px 15px;
            border: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 16px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.4);
        }

        .register-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(45deg, #4ecdc4, #ff6b6b);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .register-btn:hover {
            transform: scale(1.03);
            box-shadow: 0 0 15px rgba(255, 107, 107, 0.5);
        }

        .login-link {
            margin-top: 15px;
            text-align: center;
        }

        .login-link a {
            color: #ffdede;
            text-decoration: underline;
            font-weight: bold;
        }

        .login-link a:hover {
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Đăng ký tài khoản</h2>
        <form action="/websitebanhangtaphoa/dangky_kh_c/dangky" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email">
            </div>

            <div class="form-group">
                <label for="matkhau">Mật khẩu *</label>
                <input type="password" name="matkhau" id="matkhau" required>
            </div>

            <div class="form-group">
                <label for="hoten">Họ tên</label>
                <input type="text" name="hoten" id="hoten">
            </div>

            <div class="form-group">
                <label for="gioitinh">Giới tính</label>
                <input type="text" name="gioitinh" id="gioitinh">
            </div>

            <div class="form-group">
                <label for="ngaysinh">Ngày sinh</label>
                <input type="text" name="ngaysinh" id="ngaysinh">
            </div>

            <div class="form-group">
                <label for="sdt">Số điện thoại</label>
                <input type="text" name="sdt" id="sdt">
            </div>

            <div class="form-group">
                <label for="diachi">Địa chỉ</label>
                <textarea name="diachi" id="diachi" rows="3"></textarea>
            </div>

            <button type="submit" class="register-btn" name="btnLuu">Đăng ký</button>
        </form>

        <div class="login-link">
            Đã có tài khoản? <a href="http://localhost/websitebanhangtaphoa/dangnhap_kh_c">Đăng nhập</a>
        </div>
    </div>
</body>
</html>
