<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống Kê Doanh Thu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        /* Re-use your existing CSS styles */
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
        .statistic-card .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .statistic-card .icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        .statistic-card .value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-color);
        }
        .statistic-card .label {
            font-size: 1.1rem;
            color: var(--dark-color);
            opacity: 0.8;
        }
        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0,0,0,.03);
        }
        .badge-status {
            font-size: 0.85em;
            padding: 0.5em 0.8em;
            border-radius: 50px;
            font-weight: 600;
        }
        /* Style for text-based status */
        .status-badge-cho_xac_nhan { background-color: #fdcb6e; color: #333; } /* Warning */
        .status-badge-da_xac_nhan { background-color: #0fbcf9; color: white; } /* Info */
        .status-badge-dang_giao { background-color: #fed330; color: #333; } /* Yellow */
        .status-badge-da_giao { background-color: #26de81; color: white; } /* Success */
        .status-badge-da_huy { background-color: #eb3b5a; color: white; } /* Danger */
    </style>
</head>
<body>
    <?php
    // Định nghĩa hàm PHP getStatusBadge
    // Hàm này sẽ được sử dụng trong phần render HTML của PHP
    function getStatusBadge($status) {
        // Chuẩn hóa trạng thái để so sánh (loại bỏ khoảng trắng và chuyển về chữ thường)
        $normalizedStatus = str_replace(' ', '_', mb_strtolower($status, 'UTF-8'));
        $className = '';
        switch($normalizedStatus) {
            case 'chờ_xác_nhận': $className = 'status-badge-cho_xac_nhan'; break;
            case 'đã_xác_nhận': $className = 'status-badge-da_xac_nhan'; break;
            case 'đang_giao': $className = 'status-badge-dang_giao'; break;
            case 'đã_giao': $className = 'status-badge-da_giao'; break;
            case 'đã_huy': $className = 'status-badge-da_huy'; break;
            default: $className = 'bg-secondary'; break;
        }
        return '<span class="badge badge-status ' . htmlspecialchars($className) . '">' . htmlspecialchars($status) . '</span>';
    }
    ?>

    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-chart-line me-2"></i>Bảng Thống Kê Tổng Quan</h4>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4 mb-3">
                        <div class="card statistic-card">
                            <div class="card-body">
                                <div class="icon text-success"><i class="fas fa-money-bill-wave"></i></div>
                                <div class="value"><?= number_format($data['totalRevenue'], 0, ',', '.') ?> đ</div>
                                <div class="label">Tổng Doanh Thu (Đã Giao)</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card statistic-card">
                            <div class="card-body">
                                <div class="icon text-info"><i class="fas fa-shopping-basket"></i></div>
                                <div class="value">
                                    <?php
                                    $totalOrders = 0;
                                    foreach ($data['orderCounts'] as $count) {
                                        $totalOrders += $count['OrderCount'];
                                    }
                                    echo number_format($totalOrders, 0, ',', '.');
                                    ?>
                                </div>
                                <div class="label">Tổng Số Đơn Hàng</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card statistic-card">
                            <div class="card-body">
                                <div class="icon text-primary"><i class="fas fa-users"></i></div>
                                <div class="value">
                                    <?php
                                    // Giả sử bạn có thể lấy tổng số khách hàng từ CustomerModel nếu cần
                                    // Hoặc đếm MaKH duy nhất từ DonHang
                                    $totalCustomers = count($data['topSpendingCustomers']); // Chỉ là ví dụ
                                    echo number_format($totalCustomers, 0, ',', '.');
                                    ?>
                                </div>
                                <div class="label">Tổng Số Khách Hàng</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Doanh Thu Theo Tháng (Năm <?= htmlspecialchars($data['selectedYear']) ?>)</h4>
                <div class="header-actions">
                    <form action="<?= BASE_URL ?>/StatisticController/index" method="GET" class="d-flex">
                        <select name="year" class="form-select me-2" onchange="this.form.submit()">
                            <?php foreach ($data['availableYears'] as $year): ?>
                                <option value="<?= htmlspecialchars($year['Year']) ?>" <?= ($year['Year'] == $data['selectedYear']) ? 'selected' : '' ?>>
                                    Năm <?= htmlspecialchars($year['Year']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="monthlyRevenueChart"></canvas>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-boxes me-2"></i>Top Sản Phẩm Bán Chạy Nhất</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Mã SP</th>
                                        <th>Tên Sản Phẩm</th>
                                        <th class="text-end">Số Lượng Bán</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($data['topSellingProducts'])): ?>
                                        <?php foreach ($data['topSellingProducts'] as $product): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($product['MaSP']) ?></td>
                                                <td><?= htmlspecialchars($product['TenSP']) ?></td>
                                                <td class="text-end"><?= number_format($product['TotalQuantitySold']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="3" class="text-center p-4">Chưa có dữ liệu sản phẩm bán chạy.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-dollar-sign me-2"></i>Top Sản Phẩm Doanh Thu Cao Nhất</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Mã SP</th>
                                        <th>Tên Sản Phẩm</th>
                                        <th class="text-end">Doanh Thu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($data['topRevenueProducts'])): ?>
                                        <?php foreach ($data['topRevenueProducts'] as $product): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($product['MaSP']) ?></td>
                                                <td><?= htmlspecialchars($product['TenSP']) ?></td>
                                                <td class="text-end"><?= number_format($product['TotalRevenue'], 0, ',', '.') ?> đ</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="3" class="text-center p-4">Chưa có dữ liệu sản phẩm doanh thu.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-users-cog me-2"></i>Top Khách Hàng Tiềm Năng</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Mã KH</th>
                                        <th>Họ Tên</th>
                                        <th class="text-end">Tổng Chi Tiêu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($data['topSpendingCustomers'])): ?>
                                        <?php foreach ($data['topSpendingCustomers'] as $customer): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($customer['MaKH']) ?></td>
                                                <td><?= htmlspecialchars($customer['HoTen']) ?></td>
                                                <td class="text-end"><?= number_format($customer['TotalSpent'], 0, ',', '.') ?> đ</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="3" class="text-center p-4">Chưa có dữ liệu khách hàng tiềm năng.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-info-circle me-2"></i>Số Lượng Đơn Hàng Theo Trạng Thái</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Trạng Thái</th>
                                        <th class="text-end">Số Lượng Đơn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($data['orderCounts'])): ?>
                                        <?php foreach ($data['orderCounts'] as $status): ?>
                                            <tr>
                                                <td><?= getStatusBadge(htmlspecialchars($status['TrangThai'])) ?></td>
                                                <td class="text-end"><?= number_format($status['OrderCount']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="2" class="text-center p-4">Chưa có dữ liệu trạng thái đơn hàng.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Data từ PHP để vẽ biểu đồ
        const monthlyRevenueData = <?= json_encode(array_values($data['monthlyRevenue'])) ?>;
        const months = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'];

        const ctx = document.getElementById('monthlyRevenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Doanh Thu (VND)',
                    data: monthlyRevenueData,
                    backgroundColor: 'rgba(74, 105, 189, 0.2)',
                    borderColor: 'rgba(74, 105, 189, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Doanh Thu Theo Tháng',
                        font: {
                            size: 16
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value, index, ticks) {
                                return new Intl.NumberFormat('vi-VN').format(value) + ' đ';
                            }
                        }
                    }
                }
            }
        });

        // Hàm getStatusBadge trong JavaScript (chỉ dùng nếu bạn động hóa việc render bảng bằng JS sau này)
        // Hiện tại không được gọi bởi PHP, chỉ tồn tại trong JS
        function getStatusBadgeJS(status) { // Đổi tên thành getStatusBadgeJS để tránh nhầm lẫn
            let className = '';
            switch(status) {
                case 'Chờ xác nhận': className = 'status-badge-cho_xac_nhan'; break;
                case 'Đã xác nhận': className = 'status-badge-da_xac_nhan'; break;
                case 'Đang giao': className = 'status-badge-dang_giao'; break;
                case 'Đã giao': className = 'status-badge-da_giao'; break;
                case 'Đã hủy': className = 'status-badge-da_huy'; break;
                default: className = 'bg-secondary'; break;
            }
            return `<span class="badge badge-status ${className}">${status}</span>`;
        }
    </script>

</body>
</html>