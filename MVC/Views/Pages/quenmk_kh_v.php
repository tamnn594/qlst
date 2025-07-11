<?php
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quên mật khẩu - QuickMart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background: linear-gradient(135deg, #ff6a00, #ee0979);
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .forgot-container {
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 35px;
            border-radius: 15px;
            width: 100%;
            max-width: 400px;
            color: white;
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
        }

        .forgot-container h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 26px;
            background: linear-gradient(to right, #ffecd2, #fcb69f);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #ffffff40;
            background: rgba(255,255,255,0.2);
            color: white;
        }

        .form-group input:focus {
            outline: none;
            background: rgba(255,255,255,0.3);
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(45deg, #ff9a9e, #fad0c4);
            border: none;
            border-radius: 8px;
            font-weight: bold;
            color: #333;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            background: linear-gradient(45deg, #fbc2eb, #a6c1ee);
        }

        .back-link {
            margin-top: 15px;
            text-align: center;
        }

        .back-link a {
            color: #ffe;
            text-decoration: underline;
        }

        .back-link a:hover {
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="forgot-container">
        <h2>Quên mật khẩu</h2>
        <form action="#" method="post">
            <div class="form-group">
                <label for="email">Nhập email đăng ký:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
            </div>
            <button class="submit-btn" type="submit">Gửi mật khẩu mới</button>
        </form>
        <div class="back-link">
            <a href="#">Quay lại đăng nhập</a>
        </div>
    </div>
</body>
</html>
