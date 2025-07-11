<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa danh mục</title>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .edit-container {
            max-width: 400px;
            margin: 60px auto;
            background: rgba(255,255,255,0.97);
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.10);
            padding: 36px 28px 28px 28px;
        }
        h2 {
            color: #3a7bd5;
            text-align: center;
            margin-bottom: 28px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .form-row {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }
        .form-group {
            padding: 10px 12px;
            border: 1.5px solid #4ecdc4;
            border-radius: 8px;
            background: #f7fafd;
            font-size: 15px;
            color: #333;
        }
        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
            font-size: 0.95rem;
        }
        .btn-primary {
            background: linear-gradient(45deg, #4ecdc4, #667eea);
            color: #fff;
            box-shadow: 0 2px 8px rgba(78,205,196,0.10);
        }
        .btn-primary:hover {
            background: linear-gradient(45deg, #667eea, #4ecdc4);
            box-shadow: 0 4px 16px rgba(78,205,196,0.15);
        }
        .btn-secondary {
            background: #f7fafd;
            color: #3a7bd5;
            border: 1.5px solid #3a7bd5;
            margin-left: 10px;
        }
        .btn-secondary:hover {
            background: #3a7bd5;
            color: #fff;
        }
        .btn-group {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <h2>Sửa danh mục</h2>
        <form action="/websitebanhangtaphoa/Admin/suaDanhMuc/<?= $data['danhmuc']['MaDM'] ?>" method="post" class="form-row">
            <input class="form-group" type="text" name="TenDM" value="<?= htmlspecialchars($data['danhmuc']['TenDM']) ?>" placeholder="Tên danh mục" required>
            <div class="btn-group">
                <button class="btn btn-primary" type="submit">Lưu thay đổi</button>
                <a class="btn btn-secondary" href="/websitebanhangtaphoa/Admin/sanpham">Quay lại</a>
            </div>
        </form>
    </div>
</body>
</html>
