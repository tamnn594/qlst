<?php
require_once __DIR__ . '/../Models/OrderModel.php';
require_once __DIR__ . '/../Core/controller.php';

class OrderController extends Controller {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new OrderModel();
    }

    public function index() {
        // Nếu là request AJAX từ tìm kiếm, chỉ trả về JSON
        if (isset($_GET['search_keyword']) || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
            $keyword = $_GET['search_keyword'] ?? '';
            $orders = $this->orderModel->searchOrders($keyword);
            header('Content-Type: application/json');
            echo json_encode($orders);
            exit; // Dừng script
        } else {
            // Lần tải trang đầu tiên
            $orders = $this->orderModel->getAllOrders();
            $this->view("Pages/OrderManager_v", [
                "orders" => $orders
            ]);
        }
    }

    // Phương thức để lấy thông tin chi tiết một đơn hàng (dùng cho modal sửa)
    public function get($maDH = '') {
        if (!empty($maDH)) {
            $order = $this->orderModel->getOrderById($maDH);
            header('Content-Type: application/json');
            echo json_encode($order);
            exit;
        }
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Mã đơn hàng không hợp lệ.']);
        exit;
    }

    // Phương thức để lấy chi tiết sản phẩm của một đơn hàng (dùng cho modal xem chi tiết)
    public function getDetails($maDH = '') {
        if (!empty($maDH)) {
            $orderDetails = $this->orderModel->getOrderDetails($maDH);
            header('Content-Type: application/json');
            echo json_encode($orderDetails);
            exit;
        }
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Mã đơn hàng không hợp lệ.']);
        exit;
    }


    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $maKH = $_POST['maKH'] ?? '';
            $tongTien = $_POST['tongTien'] ?? '';
            $trangThai = $_POST['trangThai'] ?? '';
            $phuongThucTT = $_POST['phuongThucTT'] ?? '';
            $hinhThucGH = $_POST['hinhThucGH'] ?? '';

            if (empty($maKH) || empty($tongTien) || empty($trangThai) || empty($phuongThucTT) || empty($hinhThucGH)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Vui lòng điền đầy đủ thông tin!']);
                exit;
            }

            $result = $this->orderModel->addOrder($maKH, $tongTien, $trangThai, $phuongThucTT, $hinhThucGH);

            header('Content-Type: application/json');
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Thêm đơn hàng thành công!', 'newId' => $result]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Thêm đơn hàng thất bại!']);
                
            }
           
            exit;
        }
         
        header('Location: /websitebanhangtaphoa/OrderController/index'); // <-- Đã đổi
        exit;
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $maDH = $_POST['edit_maDH'] ?? '';
            $maKH = $_POST['edit_maKH'] ?? '';
            $ngayDat = $_POST['edit_ngayDat'] ?? '';
            $tongTien = $_POST['edit_tongTien'] ?? '';
            $trangThai = $_POST['edit_trangThai'] ?? '';
            $phuongThucTT = $_POST['edit_phuongThucTT'] ?? '';
            $hinhThucGH = $_POST['edit_hinhThucGH'] ?? '';

            if (empty($maDH) || empty($maKH) || empty($ngayDat) || empty($tongTien) || empty($trangThai) || empty($phuongThucTT) || empty($hinhThucGH)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Vui lòng điền đầy đủ thông tin!']);
                exit;
            }

            $result = $this->orderModel->updateOrder($maDH, $maKH, $ngayDat, $tongTien, $trangThai, $phuongThucTT, $hinhThucGH);

            header('Content-Type: application/json');
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Cập nhật đơn hàng thành công!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Cập nhật đơn hàng thất bại!']);
            }
            exit;
        }
        header('Location: /websitebanhangtaphoa/OrderController/index'); // <-- Đã đổi
        exit;
    }

    public function delete($maDH) {
    header('Content-Type: application/json');

    if ($this->orderModel->deleteOrder($maDH)) {
        echo json_encode(['success' => true, 'message' => 'Xóa khách hàng thành công!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Xóa khách hàng thất bại.']);
    }
}

}