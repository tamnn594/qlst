<?php
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - QuickMart</title>
    <style>
        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #667eea, #764ba2);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            color: white;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            background: linear-gradient(white);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 16px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .form-group input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.4);
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            transform: scale(1.03);
            box-shadow: 0 0 15px rgba(255, 107, 107, 0.5);
        }

        .register-link {
            margin-top: 20px;
            text-align: center;
        }

        .register-link a {
            color: #ffdede;
            text-decoration: underline;
            font-weight: bold;
        }

        .register-link a:hover {
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Đăng nhập khách hàng</h2>
        <form action="/websitebanhangtaphoa/dangnhap_kh_c/dangnhap" method="post">
            <div class="form-group">
                <label for="username">Tài khoản:</label>
                <input type="email" id="username" name="username" placeholder="Nhập email" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
            </div>
            <button class="login-btn" type="submit">Đăng nhập</button>
        </form>
        <div class="register-link">
            Chưa có tài khoản? <a href="/websitebanhangtaphoa/dangky_kh_c">Đăng ký ngay</a>
        </div>
        <div style="text-align:center; margin-top:8px;">
            <a href="<?= defined('BASE_URL') ? BASE_URL : '/websitebanhangtaphoa' ?>/AuthController/adminLogin"
               style="font-size:13px; color:#eee; opacity:0.7; text-decoration:none; font-weight:bold;">
                Đăng nhập với quyền admin
            </a>
        </div>
    </div>

</body>
</html>
