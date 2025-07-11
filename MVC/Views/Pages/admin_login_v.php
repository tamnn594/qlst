<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập Quản Trị Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .login-container { max-width: 450px; margin: 5rem auto; }
        .card { border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        .card-header { background-color: #4a0e69; color: white; border-top-left-radius: 15px; border-top-right-radius: 15px;}
    </style>
</head>
<body>
    <div class="container login-container">
        <div class="card">
            <div class="card-header text-center py-3">
                <h3><i class="fas fa-user-shield me-2"></i>Đăng Nhập Quản Trị Viên</h3>
            </div>
            <div class="card-body p-5">
                <?php if (isset($data['error'])): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($data['error']) ?></div>
                <?php endif; ?>
                <form action="<?= BASE_URL ?>/AuthController/adminLogin" method="POST">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Tên đăng nhập" required>
                        <label for="username">Tên đăng nhập</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>
                        <label for="password">Mật khẩu</label>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Đăng Nhập</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
