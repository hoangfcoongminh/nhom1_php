<?php
require_once 'models/Booking.php';
require_once 'models/Field.php';

class BookingController {
    private $bookingModel;
    private $fieldModel;

    public function __construct() {
        $this->bookingModel = new Booking();
        $this->fieldModel = new Field();
    }

    public function list() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để xem lịch đặt sân';
            header('Location: index.php?controller=user&action=login');
            exit();
        }

        // Nếu là admin thì xem tất cả, nếu là user thì chỉ xem của mình
        if ($_SESSION['user']['role'] === 'admin') {
            $bookings = $this->bookingModel->getAllBookings();
        } else {
            $bookings = $this->bookingModel->getBookingsByUserId($_SESSION['user']['id']);
        }
        
        require_once 'views/booking/list.php';
    }

    public function create() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để đặt sân';
            header('Location: index.php?controller=user&action=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $field_id = intval($_POST['field_id'] ?? 0);
            $booking_date = trim($_POST['booking_date'] ?? '');
            $start_time = trim($_POST['start_time'] ?? '');
            $end_time = trim($_POST['end_time'] ?? '');
            $user_id = $_SESSION['user']['id'];

            // Validate input
            if (empty($field_id) || empty($booking_date) || empty($start_time) || empty($end_time)) {
                $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin';
                header('Location: index.php?controller=booking&action=create');
                exit();
            }

            // Kiểm tra sân có tồn tại không
            $field = $this->fieldModel->getFieldById($field_id);
            if (!$field) {
                $_SESSION['error'] = 'Không tìm thấy sân';
                header('Location: index.php?controller=booking&action=create');
                exit();
            }

            // Kiểm tra sân có khả dụng không
            if ($field['status'] !== 'available') {
                $_SESSION['error'] = 'Sân không khả dụng';
                header('Location: index.php?controller=booking&action=create');
                exit();
            }

            // Kiểm tra thời gian đặt
            $booking_datetime = strtotime($booking_date . ' ' . $start_time);
            if ($booking_datetime < time()) {
                $_SESSION['error'] = 'Không thể đặt sân trong quá khứ';
                header('Location: index.php?controller=booking&action=create');
                exit();
            }

            // Kiểm tra xem sân đã được đặt trong khoảng thời gian này chưa
            if (!$this->bookingModel->isFieldAvailable($field_id, $booking_date, $start_time, $end_time)) {
                $_SESSION['error'] = 'Sân đã được đặt trong khoảng thời gian này';
                header('Location: index.php?controller=booking&action=create');
                exit();
            }

            // Tính tổng tiền
            $start = strtotime($start_time);
            $end = strtotime($end_time);
            $hours = ($end - $start) / 3600;
            $total_price = $hours * $field['price_per_hour'];

            $bookingData = [
                'field_id' => $field_id,
                'user_id' => $user_id,
                'booking_date' => $booking_date,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'total_price' => $total_price,
                'status' => 'pending'
            ];

            if ($this->bookingModel->createBooking($bookingData)) {
                $_SESSION['success'] = 'Đặt sân thành công';
                header('Location: index.php?controller=booking&action=list');
                exit();
            } else {
                $_SESSION['error'] = 'Đặt sân thất bại';
                header('Location: index.php?controller=booking&action=create');
                exit();
            }
        }

        // Lấy danh sách sân khả dụng
        $fields = $this->fieldModel->getAvailableFields();
        require_once 'views/booking/create.php';
    }

    public function update() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để cập nhật đặt sân';
            header('Location: index.php?controller=user&action=login');
            exit();
        }

        if (!isset($_GET['id'])) {
            $_SESSION['error'] = 'Không tìm thấy lịch đặt sân';
            header('Location: index.php?controller=booking&action=list');
            exit();
        }

        $booking = $this->bookingModel->getBookingById($_GET['id']);
        if (!$booking) {
            $_SESSION['error'] = 'Không tìm thấy lịch đặt sân';
            header('Location: index.php?controller=booking&action=list');
            exit();
        }

        // Kiểm tra quyền (admin hoặc chủ đặt sân)
        if ($_SESSION['user']['role'] !== 'admin' && $booking['user_id'] !== $_SESSION['user']['id']) {
            $_SESSION['error'] = 'Bạn không có quyền cập nhật lịch đặt sân này';
            header('Location: index.php?controller=booking&action=list');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'] ?? 'pending';

            // Chỉ admin mới được cập nhật trạng thái
            if ($_SESSION['user']['role'] === 'admin') {
                $bookingData = ['status' => $status];
            } else {
                // User chỉ được cập nhật thời gian
                $booking_date = trim($_POST['booking_date'] ?? '');
                $start_time = trim($_POST['start_time'] ?? '');
                $end_time = trim($_POST['end_time'] ?? '');

                if (empty($booking_date) || empty($start_time) || empty($end_time)) {
                    $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin';
                    header('Location: index.php?controller=booking&action=update&id=' . $_GET['id']);
                    exit();
                }

                // Kiểm tra thời gian đặt
                $booking_datetime = strtotime($booking_date . ' ' . $start_time);
                if ($booking_datetime < time()) {
                    $_SESSION['error'] = 'Không thể đặt sân trong quá khứ';
                    header('Location: index.php?controller=booking&action=update&id=' . $_GET['id']);
                    exit();
                }

                // Kiểm tra xem sân đã được đặt trong khoảng thời gian này chưa
                if (!$this->bookingModel->isFieldAvailable($booking['field_id'], $booking_date, $start_time, $end_time)) {
                    $_SESSION['error'] = 'Sân đã được đặt trong khoảng thời gian này';
                    header('Location: index.php?controller=booking&action=update&id=' . $_GET['id']);
                    exit();
                }

                // Tính lại tổng tiền
                $field = $this->fieldModel->getFieldById($booking['field_id']);
                $start = strtotime($start_time);
                $end = strtotime($end_time);
                $hours = ($end - $start) / 3600;
                $total_price = $hours * $field['price_per_hour'];

                $bookingData = [
                    'booking_date' => $booking_date,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'total_price' => $total_price
                ];
            }

            if ($this->bookingModel->updateBooking($_GET['id'], $bookingData)) {
                $_SESSION['success'] = 'Cập nhật lịch đặt sân thành công';
                header('Location: index.php?controller=booking&action=list');
                exit();
            } else {
                $_SESSION['error'] = 'Cập nhật lịch đặt sân thất bại';
                header('Location: index.php?controller=booking&action=update&id=' . $_GET['id']);
                exit();
            }
        }

        require_once 'views/booking/update.php';
    }

    public function delete() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để xóa lịch đặt sân';
            header('Location: index.php?controller=user&action=login');
            exit();
        }

        if (!isset($_GET['id'])) {
            $_SESSION['error'] = 'Không tìm thấy lịch đặt sân';
            header('Location: index.php?controller=booking&action=list');
            exit();
        }

        $booking = $this->bookingModel->getBookingById($_GET['id']);
        if (!$booking) {
            $_SESSION['error'] = 'Không tìm thấy lịch đặt sân';
            header('Location: index.php?controller=booking&action=list');
            exit();
        }

        // Kiểm tra quyền (admin hoặc chủ đặt sân)
        if ($_SESSION['user']['role'] !== 'admin' && $booking['user_id'] !== $_SESSION['user']['id']) {
            $_SESSION['error'] = 'Bạn không có quyền xóa lịch đặt sân này';
            header('Location: index.php?controller=booking&action=list');
            exit();
        }

        if ($this->bookingModel->deleteBooking($_GET['id'])) {
            $_SESSION['success'] = 'Xóa lịch đặt sân thành công';
        } else {
            $_SESSION['error'] = 'Xóa lịch đặt sân thất bại';
        }

        header('Location: index.php?controller=booking&action=list');
        exit();
    }
}
?> 