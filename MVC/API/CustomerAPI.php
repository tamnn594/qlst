<?php
// Đảm bảo có thể truy cập model và các lớp cần thiết
if (!class_exists('controller')) {
    require_once __DIR__ . '/../Core/controller.php';
}
require_once __DIR__ . '/../Models/CustomerModel.php';

class CustomerAPI {
    private $customerModel;

    public function __construct() {
        $this->customerModel = new CustomerModel();
    }

    // API để thêm khách hàng
    public function add($data) {
        if (empty($data['username']) || empty($data['password']) || empty($data['fullname'])) {
            return ['success' => false, 'message' => 'Tên đăng nhập, mật khẩu, và họ tên là bắt buộc!'];
        }
        if ($this->customerModel->createCustomer($data)) {
            return ['success' => true, 'message' => 'Thêm khách hàng thành công!'];
        } else {
            return ['success' => false, 'message' => 'Thêm khách hàng thất bại. Tên đăng nhập có thể đã tồn tại.'];
        }
    }

    // API để lấy thông tin một khách hàng
    public function get($id) {
        return $this->customerModel->getCustomerById($id);
    }

    // API để cập nhật khách hàng
    public function update($data) {
        if (empty($data['id']) || empty($data['username']) || empty($data['fullname'])) {
            return ['success' => false, 'message' => 'Dữ liệu không hợp lệ. Vui lòng thử lại.'];
        }
        if ($this->customerModel->updateCustomer($data['id'], $data)) {
            return ['success' => true, 'message' => 'Cập nhật thành công!'];
        } else {
            return ['success' => false, 'message' => 'Cập nhật thất bại. Tên đăng nhập có thể đã tồn tại.'];
        }
    }

    // API để xóa khách hàng
    public function delete($id) {
        if ($this->customerModel->hasOrders($id)) {
            return ['success' => false, 'message' => 'Không thể xóa khách hàng đã có đơn hàng.'];
        }
        if ($this->customerModel->deleteCustomer($id)) {
            return ['success' => true, 'message' => 'Xóa khách hàng thành công!'];
        } else {
            return ['success' => false, 'message' => 'Xóa khách hàng thất bại.'];
        }
    }

    // API để tìm kiếm
    public function search($keyword) {
        return $this->customerModel->searchCustomers($keyword);
    }

    // API để lấy lịch sử đơn hàng
    public function getOrders($customerId) {
        return $this->customerModel->getCustomerOrders($customerId);
    }

    // API để lấy chi tiết đơn hàng
    public function getDetails($orderId) {
        return $this->customerModel->getOrderDetails($orderId);
    }
}
?>
