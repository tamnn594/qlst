<?php
require_once __DIR__ . '/../Models/StatisticModel.php';
require_once __DIR__ . '/../Core/controller.php';

class StatisticController extends Controller {
    private $statisticModel;

    public function __construct() {
        $this->statisticModel = new StatisticModel();
    }

    public function index() {
        $data = [];

        // Lấy tổng doanh thu
        $data['totalRevenue'] = $this->statisticModel->getTotalRevenue();

        // Lấy năm hiện tại hoặc từ request
        $currentYear = isset($_GET['year']) ? (int)$_GET['year'] : (int)date('Y');
        $data['selectedYear'] = $currentYear;

        // Lấy doanh thu theo tháng cho năm đã chọn
        $monthlyRevenueRaw = $this->statisticModel->getMonthlyRevenue($currentYear);
        // Chuyển đổi dữ liệu thô thành mảng 12 tháng để dễ dàng vẽ biểu đồ
        $data['monthlyRevenue'] = array_fill(1, 12, 0.0); // Khởi tạo 12 tháng với 0
        foreach ($monthlyRevenueRaw as $row) {
            $data['monthlyRevenue'][(int)$row['Month']] = (float)$row['MonthlyRevenue'];
        }

        // Lấy số lượng đơn hàng theo trạng thái
        $data['orderCounts'] = $this->statisticModel->getOrderCountByStatus();

        // Lấy top sản phẩm bán chạy/doanh thu
        $data['topSellingProducts'] = $this->statisticModel->getTopSellingProducts(5);
        $data['topRevenueProducts'] = $this->statisticModel->getTopRevenueProducts(5);

        // Lấy top khách hàng chi tiêu
        $data['topSpendingCustomers'] = $this->statisticModel->getTopSpendingCustomers(5);

        // Lấy danh sách các năm có dữ liệu để chọn
        $data['availableYears'] = $this->statisticModel->getAvailableYears();

        $this->view("Pages/StatisticManager_v", $data);
    }
}
?>