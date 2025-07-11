<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Đơn Hàng</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        /* Google Font */
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
            display: inline-flex; /* Để icon căn giữa */
            align-items: center;
            justify-content: center;
        }
        .btn-action:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        /* Custom colors for buttons */
        .btn-info { background-color: #17a2b8; border-color: #17a2b8; color: white; } /* View */
        .btn-warning { background-color: #ffc107; border-color: #ffc107; color: #212529; } /* Edit */
        .btn-danger { background-color: #dc3545; border-color: #dc3545; color: white; } /* Delete */


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
        #addOrderModal .modal-header { background-color: var(--primary-color); }
        #editOrderModal .modal-header { background-color: var(--warning-color); color: #2c3e50; }
        #viewDetailsModal .modal-header { background-color: #2c3e50; }
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
        .badge-status {
            font-size: 0.85em;
            padding: 0.5em 0.8em;
            border-radius: 50px;
            font-weight: 600;
        }
        /* Style for text-based status */
        .status-badge-chuaxacnhan { background-color: #fdcb6e; color: #333; } /* Warning */
        .status-badge-daxacnhan { background-color: #0fbcf9; color: white; } /* Info */
        .status-badge-dangiao { background-color: #fed330; color: #333; } /* Yellow */
        .status-badge-dagiao { background-color: #26de81; color: white; } /* Success */
        .status-badge-dahuy { background-color: #eb3b5a; color: white; } /* Danger */

    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-shipping-fast me-2"></i>QUẢN LÝ ĐƠN HÀNG</h4>
                <div class="header-actions">
                    <form id="searchForm" class="input-group">
                        <input type="text" id="searchInput" name="search_keyword" class="form-control bg-light border-0" placeholder="Nhập từ khóa...">
                        <button class="btn" type="submit" style="background-color: var(--secondary-color); color: white;" title="Thực hiện tìm kiếm">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    <button class="btn btn-light text-nowrap" type="button" data-bs-toggle="modal" data-bs-target="#addOrderModal">
                        <i class="fas fa-plus me-2"></i>Thêm Đơn Hàng
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Mã ĐH</th>
                                <th>Mã KH / Tên KH</th>
                                <th>Ngày Đặt</th>
                                <th>Tổng Tiền</th>
                                <th>Trạng Thái</th>
                                <th>Phương Thức TT</th>
                                <th>Hình Thức GH</th>
                                <th class="text-center">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody id="orderTableBody">
                            <?php if (!empty($data['orders'])): ?>
                                <?php foreach ($data['orders'] as $order): ?>
                                    <tr class="order-row" data-id="<?= htmlspecialchars($order['MaDH']) ?>">
                                        <td class="ps-4">
                                            <span class="badge bg-primary bg-opacity-10 text-primary fw-bold">#<?= htmlspecialchars($order['MaDH']) ?></span>
                                        </td>
                                        <td>
                                            <div class="fw-bold">KH<?= htmlspecialchars($order['MaKH']) ?> - <?= htmlspecialchars($order['HoTen']) ?></div>
                                        </td>
                                        <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($order['NgayDat']))) ?></td>
                                        <td><?= number_format($order['TongTien'], 0, ',', '.') ?>đ</td>
                                        <td><span class="badge badge-status status-badge-<?= str_replace(' ', '', strtolower(htmlspecialchars($order['TrangThai']))) ?>"><?= htmlspecialchars($order['TrangThai']) ?></span></td>
                                        <td><?= htmlspecialchars($order['PhuongThucThanhToan']) ?></td>
                                        <td><?= htmlspecialchars($order['HinhThucGiaoHang']) ?></td>
                                        <td class="text-center">
                                            <button class="btn btn-info btn-action view-details-btn" title="Xem chi tiết" data-bs-toggle="modal" data-bs-target="#viewDetailsModal"><i class="fas fa-eye"></i></button>
                                            <button class="btn btn-warning btn-action edit-btn" title="Sửa thông tin" data-bs-toggle="modal" data-bs-target="#editOrderModal"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-danger btn-action delete-btn" title="Xóa đơn hàng" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <i class="fas fa-box-open"></i>
                                            <p>Không có đơn hàng nào.</p>
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

    <div class="modal fade" id="addOrderModal" tabindex="-1" aria-labelledby="addOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="addOrderForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addOrderModalLabel"><i class="fas fa-plus-circle me-2"></i>Thêm Đơn Hàng Mới</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="maKH" class="form-label">Khách Hàng (*)</label>
                            <select class="form-select" id="maKH" name="maKH" required>
                                <option value="">Chọn khách hàng</option>
                                <?php
                                // Để lấy danh sách khách hàng trong view, chúng ta cần một OrderModel instance tạm thời
                                // Hoặc truyền nó từ Controller
                                $orderModelForCustomers = new OrderModel();
                                $customers = $orderModelForCustomers->getAllCustomers();
                                foreach ($customers as $customer) {
                                    echo '<option value="' . htmlspecialchars($customer['MaKH']) . '">' . htmlspecialchars($customer['HoTen']) . ' (ID: ' . htmlspecialchars($customer['MaKH']) . ')</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tongTien" class="form-label">Tổng Tiền (*)</label>
                            <input type="number" step="0.01" class="form-control" id="tongTien" name="tongTien" required>
                        </div>
                        <div class="mb-3">
                            <label for="trangThai" class="form-label">Trạng Thái (*)</label>
                            <select class="form-select" id="trangThai" name="trangThai" required>
                                <option value="Chờ xác nhận">Chờ xác nhận</option>
                                <option value="Đã xác nhận">Đã xác nhận</option>
                                <option value="Đang giao">Đang giao</option>
                                <option value="Đã giao">Đã giao</option>
                                <option value="Đã hủy">Đã hủy</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="phuongThucTT" class="form-label">Phương Thức Thanh Toán (*)</label>
                            <select class="form-select" id="phuongThucTT" name="phuongThucTT" required>
                                <option value="Tiền mặt">Tiền mặt</option>
                                <option value="Chuyển khoản">Chuyển khoản</option>
                                <option value="Thẻ tín dụng">Thẻ tín dụng</option>
                                <option value="Momo">Momo</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="hinhThucGH" class="form-label">Hình Thức Giao Hàng (*)</label>
                            <select class="form-select" id="hinhThucGH" name="hinhThucGH" required>
                                <option value="Giao hàng tiêu chuẩn">Giao hàng tiêu chuẩn</option>
                                <option value="Giao hàng nhanh">Giao hàng nhanh</option>
                                <option value="Tự lấy">Tự lấy</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Lưu Đơn Hàng</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editOrderForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editOrderModalLabel"><i class="fas fa-edit me-2"></i>Sửa Thông Tin Đơn Hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_maDH" name="edit_maDH">
                        <div class="mb-3">
                            <label for="edit_maKH" class="form-label">Khách Hàng (*)</label>
                            <select class="form-select" id="edit_maKH" name="edit_maKH" required>
                                <option value="">Chọn khách hàng</option>
                                <?php
                                $customers = $orderModelForCustomers->getAllCustomers(); // Tái sử dụng
                                foreach ($customers as $customer) {
                                    echo '<option value="' . htmlspecialchars($customer['MaKH']) . '">' . htmlspecialchars($customer['HoTen']) . ' (ID: ' . htmlspecialchars($customer['MaKH']) . ')</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_ngayDat" class="form-label">Ngày Đặt (*)</label>
                            <input type="datetime-local" class="form-control" id="edit_ngayDat" name="edit_ngayDat" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_tongTien" class="form-label">Tổng Tiền (*)</label>
                            <input type="number" step="0.01" class="form-control" id="edit_tongTien" name="edit_tongTien" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_trangThai" class="form-label">Trạng Thái (*)</label>
                            <select class="form-select" id="edit_trangThai" name="edit_trangThai" required>
                                <option value="Chờ xác nhận">Chờ xác nhận</option>
                                <option value="Đã xác nhận">Đã xác nhận</option>
                                <option value="Đang giao">Đang giao</option>
                                <option value="Đã giao">Đã giao</option>
                                <option value="Đã hủy">Đã hủy</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_phuongThucTT" class="form-label">Phương Thức Thanh Toán (*)</label>
                            <select class="form-select" id="edit_phuongThucTT" name="edit_phuongThucTT" required>
                                <option value="Tiền mặt">Tiền mặt</option>
                                <option value="Chuyển khoản">Chuyển khoản</option>
                                <option value="Thẻ tín dụng">Thẻ tín dụng</option>
                                <option value="Momo">Momo</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_hinhThucGH" class="form-label">Hình Thức Giao Hàng (*)</label>
                            <select class="form-select" id="edit_hinhThucGH" name="edit_hinhThucGH" required>
                                <option value="Giao hàng tiêu chuẩn">Giao hàng tiêu chuẩn</option>
                                <option value="Giao hàng nhanh">Giao hàng nhanh</option>
                                <option value="Tự lấy">Tự lấy</option>
                            </select>
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

    <div class="modal fade" id="viewDetailsModal" tabindex="-1" aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewDetailsModalLabel"><i class="fas fa-receipt me-2"></i>Chi Tiết Đơn Hàng #<span id="detail_madh_title"></span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-light p-4">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6>Thông tin Đơn hàng:</h6>
                            <p><strong>Mã Đơn Hàng:</strong> <span id="detail_order_id"></span></p>
                            <p><strong>Khách Hàng:</strong> <span id="detail_customer_name"></span></p>
                            <p><strong>Ngày Đặt:</strong> <span id="detail_order_date"></span></p>
                            <p><strong>Tổng Tiền:</strong> <span id="detail_total_amount"></span></p>
                            <p><strong>Trạng Thái:</strong> <span id="detail_status"></span></p>
                            <p><strong>Phương Thức TT:</strong> <span id="detail_payment_method"></span></p>
                            <p><strong>Hình Thức GH:</strong> <span id="detail_delivery_method"></span></p>
                        </div>
                    </div>
                    <h6>Sản phẩm trong Đơn hàng:</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Mã SP</th>
                                    <th>Tên Sản Phẩm</th>
                                    <th>Số Lượng</th>
                                    <th>Đơn Giá</th>
                                    <th>Thành Tiền</th>
                                </tr>
                            </thead>
                            <tbody id="orderDetailsTableBody">
                                </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel"><i class="fas fa-exclamation-triangle me-2"></i>Xác Nhận Xóa</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa đơn hàng <span id="deleteOrderIdSpan" class="fw-bold"></span> này không? Hành động này sẽ không thể hoàn tác.</p>
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
        // Định nghĩa BASE_URL nếu chưa có (để dùng trong AJAX requests)
        const BASE_URL = "<?= defined('BASE_URL') ? BASE_URL : '/web' ?>"; // <-- Đã đổi

        function showToast(message, isSuccess = true) {
            const toastId = 'toast-' + Date.now();
            const toastHeaderBg = isSuccess ? 'bg-success' : 'bg-danger';
            const toastHTML = `<div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000"><div class="toast-header text-white ${toastHeaderBg}"><i class="fas ${isSuccess ? 'fa-check-circle' : 'fa-times-circle'} me-2"></i><strong class="me-auto">${isSuccess ? 'Thành công' : 'Lỗi'}</strong><button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button></div><div class="toast-body">${message}</div></div>`;
            document.getElementById('toast-container').insertAdjacentHTML('beforeend', toastHTML);
            const toastElement = new bootstrap.Toast(document.getElementById(toastId));
            toastElement.show();
        }
        
        function getStatusBadge(status) {
            let className = '';
            switch(status) {
                case 'Chờ xác nhận': className = 'status-badge-chuaxacnhan'; break;
                case 'Đã xác nhận': className = 'status-badge-daxacnhan'; break;
                case 'Đang giao': className = 'status-badge-dangiao'; break;
                case 'Đã giao': className = 'status-badge-dagiao'; break;
                case 'Đã hủy': className = 'status-badge-dahuy'; break;
                default: className = 'bg-secondary'; break;
            }
            return `<span class="badge badge-status ${className}">${status}</span>`;
        }

        function renderOrderTable(orders) {
            const tableBody = document.getElementById('orderTableBody');
            tableBody.innerHTML = ''; // Xóa nội dung cũ

            if (orders.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="8"><div class="empty-state"><i class="fas fa-box-open"></i><p>Không có đơn hàng nào được tìm thấy.</p></div></td></tr>`;
                return;
            }

            orders.forEach(order => {
                const row = `
                    <tr class="order-row" data-id="${order.MaDH}">
                        <td class="ps-4">
                            <span class="badge bg-primary bg-opacity-10 text-primary fw-bold">#${order.MaDH}</span>
                        </td>
                        <td>
                            <div class="fw-bold">KH${order.MaKH} - ${order.HoTen}</div>
                        </td>
                        <td>${new Date(order.NgayDat).toLocaleString('vi-VN')}</td>
                        <td>${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(order.TongTien)}</td>
                        <td>${getStatusBadge(order.TrangThai)}</td>
                        <td>${order.PhuongThucThanhToan}</td>
                        <td>${order.HinhThucGiaoHang}</td>
                        <td class="text-center">
                            <button class="btn btn-info btn-action view-details-btn" title="Xem chi tiết" data-bs-toggle="modal" data-bs-target="#viewDetailsModal"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-warning btn-action edit-btn" title="Sửa thông tin" data-bs-toggle="modal" data-bs-target="#editOrderModal"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-danger btn-action delete-btn" title="Xóa đơn hàng" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                `;
                tableBody.insertAdjacentHTML('beforeend', row);
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const addOrderModal = new bootstrap.Modal(document.getElementById('addOrderModal'));
            const editOrderModal = new bootstrap.Modal(document.getElementById('editOrderModal'));
            const viewDetailsModal = new bootstrap.Modal(document.getElementById('viewDetailsModal'));
            const deleteConfirmModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));

            const addOrderForm = document.getElementById('addOrderForm');
            const editOrderForm = document.getElementById('editOrderForm');
            const searchForm = document.getElementById('searchForm');
            const searchInput = document.getElementById('searchInput');
            const orderTableBody = document.getElementById('orderTableBody');

            let orderIdToDelete = null;

            // === Xử lý Form Thêm Đơn Hàng ===
            addOrderForm.addEventListener('submit', function(e) {
                e.preventDefault();
                fetch(`${BASE_URL}/OrderController/add`, {
                    method: 'POST',
                    body: new FormData(this)
                })
                .then(res => res.json())
                .then(data => {
                    showToast(data.message, data.success);
                    if (data.success) {
                        addOrderModal.hide();
                        addOrderForm.reset();
                        // Tải lại dữ liệu bảng sau khi thêm thành công
                        fetch(`${BASE_URL}/OrderController/index`)
                            .then(response => response.json())
                            .then(orders => renderOrderTable(orders))
                            .catch(error => console.error('Error reloading orders:', error));
                        location.reload();    
                    }
                })
                .catch(error => {
                    console.error('Error adding order:', error);
                    showToast('Có lỗi xảy ra khi thêm đơn hàng.', false);
                });
            });

            // === Xử lý Form Sửa Đơn Hàng ===
            orderTableBody.addEventListener('click', function(e) {
                const editButton = e.target.closest('.edit-btn');
                if (editButton) {
                    const orderRow = editButton.closest('.order-row');
                    const maDH = orderRow.dataset.id;

                    fetch(`${BASE_URL}/OrderController/get/${maDH}`)
                        .then(response => response.json())
                        .then(order => {
                            if (order) {
                                document.getElementById('edit_maDH').value = order.MaDH;
                                document.getElementById('edit_maKH').value = order.MaKH;
                                // Định dạng ngày giờ cho input datetime-local
                                const ngayDat = new Date(order.NgayDat);
                                const localDateTime = new Date(ngayDat.getTime() - (ngayDat.getTimezoneOffset() * 60000)).toISOString().slice(0, 16);
                                document.getElementById('edit_ngayDat').value = localDateTime;
                                
                                document.getElementById('edit_tongTien').value = parseFloat(order.TongTien).toFixed(2); // Giữ 2 số thập phân
                                document.getElementById('edit_trangThai').value = order.TrangThai;
                                document.getElementById('edit_phuongThucTT').value = order.PhuongThucThanhToan;
                                document.getElementById('edit_hinhThucGH').value = order.HinhThucGiaoHang;
                                editOrderModal.show();
                                
                            } else {
                                showToast('Không tìm thấy thông tin đơn hàng.', false);
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching order for edit:', error);
                            showToast('Lỗi khi tải dữ liệu đơn hàng để sửa.', false);
                        });
                }
            });

            editOrderForm.addEventListener('submit', function(e) {
                e.preventDefault();
                fetch(`${BASE_URL}/OrderController/update`, {
                    method: 'POST',
                    body: new FormData(this)
                })
                .then(res => res.json())
                .then(data => {
                    showToast(data.message, data.success);
                    if (data.success) {
                        editOrderModal.hide();
                        // Tải lại dữ liệu bảng sau khi sửa thành công
                        fetch(`${BASE_URL}/OrderController/index`)
                            .then(response => response.json())
                            .then(orders => renderOrderTable(orders))
                            .catch(error => console.error('Error reloading orders:', error));
                            location.reload(); 
                    }
                })
                .catch(error => {
                    console.error('Error updating order:', error);
                    showToast('Có lỗi xảy ra khi cập nhật đơn hàng.', false);
                });
            });

            // === Xử lý Xóa Đơn Hàng ===
            orderTableBody.addEventListener('click', function(e) {
                const deleteButton = e.target.closest('.delete-btn');
                if (deleteButton) {
                    const orderRow = deleteButton.closest('.order-row');
                    orderIdToDelete = orderRow.dataset.id;
                    document.getElementById('deleteOrderIdSpan').textContent = '#' + orderIdToDelete;
                    deleteConfirmModal.show();
                }
            });

            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                if (orderIdToDelete) {
                    fetch(`${BASE_URL}/OrderController/delete/${orderIdToDelete}`, {
                        method: 'POST'
                    })
                    .then(res => res.json())
                    .then(data => {
                        showToast(data.message, data.success);
                        if (data.success) {
                            deleteConfirmModal.hide();
                            // Tải lại dữ liệu bảng sau khi xóa thành công
                            fetch(`${BASE_URL}/OrderController/index`)
                                .then(response => response.json())
                                .then(orders => renderOrderTable(orders))
                                .catch(error => console.error('Error reloading orders:', error));
                                location.reload(); 
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting order:', error);
                        showToast('Có lỗi xảy ra khi xóa đơn hàng.', false);
                    });
                    orderIdToDelete = null;
                }
            });

            // === Xử lý Xem Chi Tiết Đơn Hàng ===
            orderTableBody.addEventListener('click', function(e) {
                const viewDetailsButton = e.target.closest('.view-details-btn');
                if (viewDetailsButton) {
                    const orderRow = viewDetailsButton.closest('.order-row');
                    const maDH = orderRow.dataset.id;

                    // Lấy thông tin chung của đơn hàng
                    fetch(`${BASE_URL}/OrderController/get/${maDH}`)
                        .then(response => response.json())
                        .then(orderInfo => {
                            if (orderInfo) {
                                document.getElementById('detail_madh_title').textContent = orderInfo.MaDH;
                                document.getElementById('detail_order_id').textContent = orderInfo.MaDH;
                                document.getElementById('detail_customer_name').textContent = `${orderInfo.HoTen} (ID: ${orderInfo.MaKH})`;
                                document.getElementById('detail_order_date').textContent = new Date(orderInfo.NgayDat).toLocaleString('vi-VN');
                                document.getElementById('detail_total_amount').textContent = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(orderInfo.TongTien);
                                document.getElementById('detail_status').innerHTML = getStatusBadge(orderInfo.TrangThai);
                                document.getElementById('detail_payment_method').textContent = orderInfo.PhuongThucThanhToan;
                                document.getElementById('detail_delivery_method').textContent = orderInfo.HinhThucGiaoHang;
                            }
                        })
                        .catch(error => console.error('Error fetching order info for details:', error));

                    // Lấy chi tiết sản phẩm của đơn hàng
                    fetch(`${BASE_URL}/OrderController/getDetails/${maDH}`)
                        .then(response => response.json())
                        .then(orderDetails => {
                            const detailTableBody = document.getElementById('orderDetailsTableBody');
                            detailTableBody.innerHTML = '';
                            if (orderDetails && orderDetails.length > 0) {
                                orderDetails.forEach(item => {
                                    const subtotal = item.SoLuong * item.DonGia;
                                    const rowHtml = `
                                        <tr>
                                            <td>${item.MaSP}</td>
                                            <td>${item.TenSP}</td>
                                            <td>${item.SoLuong}</td>
                                            <td>${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(item.DonGia)}</td>
                                            <td>${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(subtotal)}</td>
                                        </tr>
                                    `;
                                    detailTableBody.insertAdjacentHTML('beforeend', rowHtml);
                                });
                            } else {
                                detailTableBody.innerHTML = '<tr><td colspan="5" class="text-center p-4">Không có sản phẩm nào trong đơn hàng này.</td></tr>';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching order details:', error);
                            showToast('Lỗi khi tải chi tiết sản phẩm đơn hàng.', false);
                        });
                    viewDetailsModal.show();
                }
            });

            // === Logic Tìm kiếm ===
            searchForm.addEventListener('submit', function(e) { 
                e.preventDefault(); 
                const keyword = searchInput.value;
                fetch(`${BASE_URL}/OrderController/index?search_keyword=${encodeURIComponent(keyword)}`)
                    .then(response => response.json())
                    .then(orders => renderOrderTable(orders))
                    .catch(error => console.error('Lỗi khi tìm kiếm:', error));
            });

            searchInput.addEventListener('input', function(e) {
                if (e.target.value === '') {
                    // Nếu ô tìm kiếm trống, tải lại toàn bộ danh sách
                    fetch(`${BASE_URL}/OrderController/index`)
                        .then(response => response.json())
                        .then(orders => renderOrderTable(orders))
                        .catch(error => console.error('Error reloading all orders:', error));
                }
            });
        });
    </script>

</body>
</html>