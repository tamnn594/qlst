<?php
// Đảm bảo controller này có thể truy cập lớp controller cơ sở
if (!class_exists('controller')) {
    require_once './MVC/Core/controller.php';
}

class CustomerController extends controller {
    private $customerModel;
    private $customerAPI;

    public function __construct() {
        $this->customerModel = $this->model('CustomerModel');
        require_once __DIR__ . '/../API/CustomerAPI.php';
        $this->customerAPI = new CustomerAPI();
    }

    // Action mặc định, hiển thị trang quản lý
    public function Get_data_kh() {
    $keyword = $_GET['keyword'] ?? '';
    if (!empty($keyword)) {
        $customers = $this->customerModel->searchCustomers($keyword);
    } else {
        $customers = $this->customerModel->getAllCustomers();
    }

    $this->view('Pages/CustomerManager_v', [
        'customers' => $customers
    ]);
}


    // Gọi API thêm khách hàng
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            header('Content-Type: application/json');
            $data = [
                'username' => $_POST['username'] ?? '',
                'password' => $_POST['password'] ?? '',
                'fullname' => $_POST['fullname'] ?? '',
                'email'    => $_POST['email'] ?? '',
                'phone'    => $_POST['phone'] ?? '',
                'address'  => $_POST['address'] ?? '',
            ];
            $result = $this->customerAPI->add($data);
            echo json_encode($result);
        }
    }

    // Gọi API lấy thông tin một khách hàng
    public function get($id) {
        header('Content-Type: application/json');
        $customer = $this->customerAPI->get($id);
        echo json_encode($customer);
    }
    
    // Gọi API cập nhật khách hàng
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            header('Content-Type: application/json');
            $data = [
                'id'       => $_POST['edit_id'] ?? 0,
                'username' => $_POST['edit_username'] ?? '',
                'password' => $_POST['edit_password'] ?? '',
                'fullname' => $_POST['edit_fullname'] ?? '',
                'email'    => $_POST['edit_email'] ?? '',
                'phone'    => $_POST['edit_phone'] ?? '',
                'address'  => $_POST['edit_address'] ?? '',
            ];
            $result = $this->customerAPI->update($data);
            echo json_encode($result);
        }
    }

    // Gọi API xóa khách hàng
    public function delete($id) {
        header('Content-Type: application/json');
        $result = $this->customerAPI->delete($id);
        echo json_encode($result);
    }
    
    // Gọi API tìm kiếm
    public function search() {
        header('Content-Type: application/json');
        $keyword = $_GET['keyword'] ?? '';
        $customers = $this->customerAPI->search($keyword);
        echo json_encode($customers);
    }

    // Gọi API lấy lịch sử đơn hàng
    public function getOrders($customerId) {
        header('Content-Type: application/json');
        $orders = $this->customerAPI->getOrders($customerId);
        echo json_encode($orders);
    }

    // Gọi API lấy chi tiết đơn hàng
    public function getDetails($orderId) {
        header('Content-Type: application/json');
        $details = $this->customerAPI->getDetails($orderId);
        echo json_encode($details);
    }
}
?>
