<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Khách Hàng</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        /* CSS không thay đổi, giữ nguyên như cũ */
        @import url('https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700&display=swap');
        :root {
            --primary-color: #4a69bd;
            --secondary-color: #6a89cc;
            --success-color: #1dd1a1;
            --warning-color: #feca57;
            --danger-color: #ff6b6b;
            --light-color: #f8f9fa;
            --dark-color: #576574;
            --font-family: 'Be Vietnam Pro', sans-serif;
        }
        body {
            background-color: #eef2f5;
            font-family: var(--font-family);
        }
        .container-fluid {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            padding: 1.25rem 1.5rem;
            border-bottom: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .card-header h4 {
            font-weight: 600;
        }
        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .table-hover tbody tr {
            transition: all 0.2s ease-in-out;
        }
        .table-hover tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            background-color: white;
        }
        .table thead th {
            background-color: var(--primary-color);
            font-weight: 600;
            color: white;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            vertical-align: middle;
        }
        .table td {
            vertical-align: middle;
            color: var(--dark-color);
        }
        .btn-action {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            transition: all 0.2s ease;
        }
        .btn-action:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .modal-content {
            border: none;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .modal-header {
            border-bottom: 0;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        #addCustomerModal .modal-header { background-color: var(--primary-color); }
        #editCustomerModal .modal-header { background-color: var(--warning-color); color: #2c3e50; }
        #historyModal .modal-header { background-color: #8e44ad; }
        #detailModal .modal-header { background-color: #2c3e50; }
        #deleteConfirmModal .modal-header { background-color: var(--danger-color); }
        .btn-close-white {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #95a5a6;
        }
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        .empty-state p {
            font-size: 1.2rem;
            font-weight: 500;
        }
        #toast-container {
            position: fixed; top: 20px; right: 20px; z-index: 1090;
        }
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-users-cog me-2"></i>QUẢN LÝ KHÁCH HÀNG</h4>
                <div class="header-actions">
                    <form id="searchForm" class="input-group" method="GET" action="<?= defined('BASE_URL') ? BASE_URL : '' ?>/CustomerController/Get_data_kh">
                        <input type="text" id="searchInput" name="keyword" class="form-control bg-light border-0" placeholder="Nhập từ khóa..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
                        <button class="btn" type="submit" style="background-color: var(--secondary-color); color: white;" title="Thực hiện tìm kiếm">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    <button class="btn btn-light text-nowrap" type="button" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                        <i class="fas fa-plus me-2"></i>Thêm Mới
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Mã KH</th>
                                <th>Họ Tên</th>
                                <th>Thông Tin Liên Hệ</th>
                                <th>Địa Chỉ</th>
                                <th class="text-center">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody id="customerTableBody">
                            <?php if (!empty($data['customers'])): ?>
                                <?php foreach ($data['customers'] as $customer): ?>
                                    <tr class="customer-row" data-id="<?= htmlspecialchars($customer['MaKH']) ?>" data-name="<?= htmlspecialchars($customer['HoTen']) ?>">
                                        <td class="ps-4">
                                            <span class="badge bg-primary bg-opacity-10 text-primary fw-bold">#<?= htmlspecialchars($customer['MaKH']) ?></span>
                                        </td>
                                        <td>
                                            <div class="fw-bold"><?= htmlspecialchars($customer['HoTen']) ?></div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span><i class="fas fa-envelope me-2 text-muted"></i><?= htmlspecialchars($customer['Email']) ?></span>
                                                <span><i class="fas fa-phone me-2 text-muted"></i><?= htmlspecialchars($customer['SDT']) ?></span>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($customer['DiaChi']) ?></td>
                                        <td class="text-center">
                                            <button class="btn btn-info btn-action view-history-btn" title="Xem lịch sử mua hàng"><i class="fas fa-history"></i></button>
                                            <button class="btn btn-warning btn-action edit-btn" title="Sửa thông tin"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-danger btn-action delete-btn" title="Xóa khách hàng"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">
                                        <div class="empty-state">
                                            <i class="fas fa-user-slash"></i>
                                            <p>Không có dữ liệu khách hàng.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="toast-container"></div>

    <div class="modal fade" id="addCustomerModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="addCustomerForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Thêm Khách Hàng Mới</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                         <div class="mb-3">
                            <label class="form-label">Tên Đăng Nhập (*)</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mật Khẩu (*)</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Họ Tên (*)</label>
                            <input type="text" name="fullname" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số Điện Thoại</label>
                            <input type="tel" name="phone" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Địa Chỉ</label>
                            <textarea name="address" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Lưu</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="editCustomerModal" tabindex="-1">
         <div class="modal-dialog">
            <form id="editCustomerForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-user-edit me-2"></i>Sửa Thông Tin Khách Hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="edit_id" id="edit_id">
                        <div class="mb-3">
                            <label class="form-label">Tên Đăng Nhập (*)</label>
                            <input type="text" name="edit_username" id="edit_username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mật Khẩu (*)</label>
                            <input type="text" name="edit_password" id="edit_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Họ Tên (*)</label>
                            <input type="text" name="edit_fullname" id="edit_fullname" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="edit_email" id="edit_email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số Điện Thoại</label>
                            <input type="tel" name="edit_phone" id="edit_phone" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Địa Chỉ</label>
                            <textarea name="edit_address" id="edit_address" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-warning"><i class="fas fa-save me-2"></i>Lưu Thay Đổi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="historyModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="historyModalTitle"><i class="fas fa-history me-2"></i>Lịch Sử Mua Hàng</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Mã ĐH</th>
                                <th>Ngày Đặt</th>
                                <th>Tổng Tiền</th>
                                <th class="text-center">Trạng Thái</th>
                                <th class="text-center">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody id="historyTableBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailModal" tabindex="-1">
         <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalTitle"><i class="fas fa-receipt me-2"></i>Chi Tiết Đơn Hàng</h5>
                     <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light p-4" id="detailContent"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Xác Nhận Xóa</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa khách hàng này? Hành động này sẽ không thể hoàn tác.</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn"><i class="fas fa-trash-alt me-2"></i>Xác Nhận</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        if (typeof customerManagerScriptLoaded === 'undefined') {
            const customerManagerScriptLoaded = true;
            const BASE_URL = "<?= defined('BASE_URL') ? BASE_URL : '' ?>";

            function showToast(message, isSuccess = true) {
                const toastId = 'toast-' + Date.now();
                const toastHeaderBg = isSuccess ? 'bg-success' : 'bg-danger';
                const toastHTML = `<div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000"><div class="toast-header text-white ${toastHeaderBg}"><i class="fas ${isSuccess ? 'fa-check-circle' : 'fa-times-circle'} me-2"></i><strong class="me-auto">${isSuccess ? 'Thành công' : 'Lỗi'}</strong><button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button></div><div class="toast-body">${message}</div></div>`;
                document.getElementById('toast-container').insertAdjacentHTML('beforeend', toastHTML);
                const toastElement = new bootstrap.Toast(document.getElementById(toastId));
                toastElement.show();
            }
            
            // Hàm renderTable không cần thiết cho logic tìm kiếm nữa, nhưng vẫn giữ lại để tương lai có thể dùng lại
            function renderTable(customers) {
                const tableBody = document.getElementById('customerTableBody');
                tableBody.innerHTML = '';
                if (customers.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="5"><div class="empty-state"><i class="fas fa-user-slash"></i><p>Không tìm thấy khách hàng nào.</p></div></td></tr>`;
                    return;
                }
                customers.forEach(customer => {
                    const row = `<tr class="customer-row" data-id="${customer.MaKH}" data-name="${customer.HoTen}"><td class="ps-4"><span class="badge bg-primary bg-opacity-10 text-primary fw-bold">#${customer.MaKH}</span></td><td><div class="fw-bold">${customer.HoTen}</div></td><td><div class="d-flex flex-column"><span><i class="fas fa-envelope me-2 text-muted"></i>${customer.Email || 'N/A'}</span><span><i class="fas fa-phone me-2 text-muted"></i>${customer.SDT || 'N/A'}</span></div></td><td>${customer.DiaChi || 'N/A'}</td><td class="text-center"><button class="btn btn-info btn-action view-history-btn" title="Xem lịch sử mua hàng"><i class="fas fa-history"></i></button><button class="btn btn-warning btn-action edit-btn" title="Sửa thông tin"><i class="fas fa-edit"></i></button><button class="btn btn-danger btn-action delete-btn" title="Xóa khách hàng"><i class="fas fa-trash"></i></button></td></tr>`;
                    tableBody.insertAdjacentHTML('beforeend', row);
                });
            }

            function getStatusBadge(status) {
                switch(status) {
                    case 'Đã giao': return '<span class="badge rounded-pill bg-success">Đã giao</span>';
                    case 'Chờ xử lý': return '<span class="badge rounded-pill bg-warning text-dark">Chờ xử lý</span>';
                    case 'Đã hủy': return '<span class="badge rounded-pill bg-danger">Đã hủy</span>';
                    default: return `<span class="badge rounded-pill bg-secondary">${status}</span>`;
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                const addCustomerModal = new bootstrap.Modal(document.getElementById('addCustomerModal'));
                const editCustomerModal = new bootstrap.Modal(document.getElementById('editCustomerModal'));
                const historyModal = new bootstrap.Modal(document.getElementById('historyModal'));
                const detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
                const deleteConfirmModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));

                // === PHẦN 2: VÔ HIỆU HÓA/XÓA BỎ JAVASCRIPT TÌM KIẾM AJAX ===
                /*
                const searchForm = document.getElementById('searchForm');
                const searchInput = document.getElementById('searchInput');

                function performSearch() {
                    const keyword = searchInput.value;
                    fetch(`${BASE_URL}/CustomerController/search?keyword=${keyword}`)
                        .then(response => response.json())
                        .then(data => renderTable(data))
                        .catch(error => console.error('Lỗi khi tìm kiếm:', error));
                }

                searchForm.addEventListener('submit', function(e) { 
                    e.preventDefault(); 
                    performSearch(); 
                });

                searchInput.addEventListener('input', function(e) {
                    if (e.target.value === '') {
                        performSearch();
                    }
                });
                */

                document.getElementById('addCustomerForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    fetch(`${BASE_URL}/CustomerController/add`, { method: 'POST', body: new FormData(this) })
                        .then(res => res.json()).then(data => {
                            showToast(data.message, data.success);
                            if (data.success) { addCustomerModal.hide(); this.reset(); setTimeout(() => location.reload(), 1000); }
                        });
                });
                
                let customerIdToDelete = null;

                document.getElementById('customerTableBody').addEventListener('click', function(e) {
                    const button = e.target.closest('button.btn-action');
                    if (!button) return;
                    const customerRow = e.target.closest('.customer-row');
                    const customerId = customerRow.dataset.id;
                    const customerName = customerRow.dataset.name;

                    if (button.classList.contains('edit-btn')) {
                        fetch(`${BASE_URL}/CustomerController/get/${customerId}`).then(res => res.json()).then(customer => {
                            document.getElementById('edit_id').value = customer.MaKH;
                            document.getElementById('edit_username').value = customer.TenDangNhap;
                            document.getElementById('edit_password').value = customer.MatKhau;
                            document.getElementById('edit_fullname').value = customer.HoTen;
                            document.getElementById('edit_email').value = customer.Email;
                            document.getElementById('edit_phone').value = customer.SDT;
                            document.getElementById('edit_address').value = customer.DiaChi;
                            editCustomerModal.show();
                        });
                    } else if (button.classList.contains('delete-btn')) {
                        customerIdToDelete = customerId;
                        deleteConfirmModal.show();
                    } else if (button.classList.contains('view-history-btn')) {
                        // Logic xem lịch sử mua hàng (AJAX) vẫn hoạt động tốt, không cần thay đổi
                        fetch(`${BASE_URL}/CustomerController/getOrders/${customerId}`).then(res => res.json()).then(orders => {
                            document.getElementById('historyModalTitle').innerHTML = `<i class="fas fa-history me-2"></i>Lịch Sử Mua Hàng - <span class="fw-bold">${customerName}</span>`;
                            const historyBody = document.getElementById('historyTableBody');
                            historyBody.innerHTML = '';
                            if (orders.length === 0) {
                                historyBody.innerHTML = '<tr><td colspan="5" class="text-center p-4">Khách hàng chưa có đơn hàng nào.</td></tr>';
                            } else {
                                orders.forEach(order => {
                                    historyBody.innerHTML += `<tr class="order-detail-row" style="cursor:pointer;" data-order-id="${order.MaDH}"><td><span class="badge bg-dark bg-opacity-75">#${order.MaDH}</span></td><td>${new Date(order.NgayDat).toLocaleDateString('vi-VN')}</td><td>${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(order.TongTien)}</td><td class="text-center">${getStatusBadge(order.TrangThai)}</td><td class="text-center"><button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i> Xem</button></td></tr>`;
                                });
                            }
                            historyModal.show();
                        });
                    }
                });

                document.getElementById('editCustomerForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    fetch(`${BASE_URL}/CustomerController/update`, { method: 'POST', body: new FormData(this) })
                        .then(res => res.json()).then(data => {
                            showToast(data.message, data.success);
                            if (data.success) { editCustomerModal.hide(); setTimeout(() => location.reload(), 1000); }
                        });
                });

                document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                    if (customerIdToDelete) {
                        fetch(`${BASE_URL}/CustomerController/delete/${customerIdToDelete}`, { method: 'POST' }).then(res => res.json())
                            .then(data => {
                                showToast(data.message, data.success);
                                deleteConfirmModal.hide();
                                if (data.success) { setTimeout(() => location.reload(), 1000); }
                            });
                        customerIdToDelete = null;
                    }
                });
                
                // Logic xem chi tiết đơn hàng (AJAX) vẫn hoạt động tốt, không cần thay đổi
                document.getElementById('historyTableBody').addEventListener('click', function(e){
                    const orderRow = e.target.closest('.order-detail-row');
                    if(!orderRow) return;
                    const orderId = orderRow.dataset.orderId;
                    fetch(`${BASE_URL}/CustomerController/getDetails/${orderId}`).then(res => res.json()).then(details => {
                        document.getElementById('detailModalTitle').innerHTML = `<i class="fas fa-receipt me-2"></i>Chi Tiết Đơn Hàng #${orderId}`;
                        const content = document.getElementById('detailContent');
                        content.innerHTML = '';
                        if (details.length === 0) {
                            content.innerHTML = '<p class="p-4 text-center">Không có chi tiết cho đơn hàng này.</p>';
                        } else {
                            let total = 0;
                            let itemsHtml = '';
                            details.forEach(item => {
                                const subtotal = item.SoLuong * item.DonGia;
                                total += subtotal;
                                itemsHtml += `<div class="row border-bottom py-2"><div class="col-md-2"><img src="${BASE_URL}/Public/images/${item.HinhAnh}" class="img-fluid rounded" alt="${item.TenSP}" onerror="this.src='https.placehold.co/100x100/eef2f5/576574?text=Ảnh'"></div><div class="col-md-4 d-flex align-items-center">${item.TenSP}</div><div class="col-md-2 d-flex align-items-center">SL: ${item.SoLuong}</div><div class="col-md-2 d-flex align-items-center">${new Intl.NumberFormat('vi-VN').format(item.DonGia)}đ</div><div class="col-md-2 d-flex align-items-center fw-bold">${new Intl.NumberFormat('vi-VN').format(subtotal)}đ</div></div>`;
                            });
                            content.innerHTML = `<div class="container-fluid">${itemsHtml}<div class="row pt-3"><div class="col text-end"><h5 class="fw-bold">TỔNG CỘNG: <span class="text-danger">${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(total)}</span></h5></div></div></div>`;
                        }
                        historyModal.hide();
                        detailModal.show();
                    });
                });
                
                document.getElementById('detailModal').addEventListener('hidden.bs.modal', function () { });
            });
        }
    </script>

</body>
</html>