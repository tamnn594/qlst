<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quản lý tài khoản</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    :root {
      --primary-color:rgb(11, 112, 245);
      --background: #fff;
      --text-color: #333;
      --border-radius: 12px;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: var(--background);
      color: var(--text-color);
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px 20px;
      min-height: 100vh;
    }

    .profile-container {
      width: 100%;
      max-width: 480px;
      background-color: #fefefe;
      border-radius: var(--border-radius);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      padding: 30px;
      animation: fadeIn 0.4s ease;
    }

    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(20px);}
      to {opacity: 1; transform: translateY(0);}
    }

    h2 {
      text-align: center;
      margin-bottom: 24px;
      color: var(--primary-color);
    }

    .info-item {
      margin-bottom: 18px;
    }

    .info-item label {
      font-weight: 600;
      display: block;
      margin-bottom: 4px;
    }

    .info-item input, .info-item select {
      width: 100%;
      padding: 10px 12px;
      border-radius: 8px;
      border: 1px solid #ccc;
      color: #333;
      font-size: 1rem;
    }

    .btn-group {
      display: flex;
      justify-content: space-between;
      margin-top: 25px;
    }

    .btn {
      flex: 1;
      padding: 10px 15px;
      margin: 0 5px;
      background-color: var(--primary-color);
      color: white;
      border: none;
      border-radius: var(--border-radius);
      font-weight: bold;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .btn:hover {
      background-color:rgb(6, 83, 184);
      transform: scale(1.02);
    }

    .btn-password {
      margin-top: 18px;
      width: 100%;
      padding: 10px;
      background-color: #555;
      color: white;
      border: none;
      border-radius: var(--border-radius);
      font-weight: bold;
      cursor: pointer;
      transition: 0.2s;
    }

    .btn-password:hover {
      background-color: #444;
    }
  </style>
</head>
<body>
  <div class="profile-container">
    <h2>Thông tin tài khoản</h2>
    <form method="POST" action="/websitebanhangtaphoa/thongtincanhan_kh_c/sua">
      <div class="info-item">
        <label>Họ tên:</label>
        <input type="text" name="HoTen" value="<?= htmlspecialchars($data['user']['HoTen'] ?? '') ?>" required>
      </div>
      <div class="info-item">
        <label>Email:</label>
        <input type="email" name="Email" value="<?= htmlspecialchars($data['user']['Email'] ?? '') ?>" required>
      </div>
      <div class="info-item">
        <label>Số điện thoại:</label>
        <input type="text" name="SDT" value="<?= htmlspecialchars($data['user']['SDT'] ?? '') ?>" required>
      </div>
      <div class="info-item">
        <label>Giới tính:</label>
        <select name="GioiTinh" required>
          <option value="Nam" <?= ($data['user']['GioiTinh'] ?? '') == 'Nam' ? 'selected' : '' ?>>Nam</option>
          <option value="Nữ" <?= ($data['user']['GioiTinh'] ?? '') == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
        </select>
      </div>
      <div class="info-item">
        <label>Ngày sinh:</label>
        <input type="date" name="NgaySinh" value="<?= htmlspecialchars($data['user']['NgaySinh'] ?? '') ?>" required>
      </div>
      <div class="info-item">
        <label>Địa chỉ:</label>
        <input type="text" name="DiaChi" value="<?= htmlspecialchars($data['user']['DiaChi'] ?? '') ?>" required>
      </div>
      <div class="btn-group">
        <button type="submit" class="btn" name="btnsua" value="1">Lưu</button>
        <button type="reset" class="btn">Xóa</button>
      </div>
    </form>
    <div class="btn-group">
      <button class="btn" onclick="window.history.go(-1)">Quay lại </button>
    </div>
    <button class="btn-password" onclick="document.getElementById('changePassForm').style.display='block'">Đổi mật khẩu</button>
    <form id="changePassForm" method="POST" action="/websitebanhangtaphoa/thongtincanhan_kh_c/doimatkhau" style="display:none;margin-top:18px;">
      <div class="info-item">
        <label>Mật khẩu cũ:</label>
        <input type="password" name="old_password" required>
      </div>
      <div class="info-item">
        <label>Mật khẩu mới:</label>
        <input type="password" name="new_password" required>
      </div>
      <div class="info-item">
        <label>Nhập lại mật khẩu mới:</label>
        <input type="password" name="renew_password" required>
      </div>
      <div class="btn-group">
        <button type="submit" class="btn">Lưu mật khẩu</button>
        <button type="button" class="btn" onclick="document.getElementById('changePassForm').style.display='none'">Hủy</button>
      </div>
    </form>
  </div>
</body>
</html>
