<?php
require_once 'models/Field.php';

class FieldController {
    private $fieldModel;

    public function __construct() {
        $this->fieldModel = new Field();
    }

    public function index() {
        $fields = $this->fieldModel->getAllFields();
        require_once 'views/field/index.php';
    }

    public function list() {
        $fields = $this->fieldModel->getAvailableFields();
        require_once 'views/field/list.php';
    }

    public function create() {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['error'] = 'Bạn không có quyền truy cập trang này';
            header('Location: index.php');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $type = trim($_POST['type'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price_per_hour = floatval($_POST['price_per_hour'] ?? 0);
            $status = 'available';

            if (empty($name) || empty($type) || $price_per_hour <= 0) {
                $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin';
                header('Location: index.php?controller=field&action=create');
                exit();
            }

            $fieldData = [
                'name' => $name,
                'type' => $type,
                'description' => $description,
                'price_per_hour' => $price_per_hour,
                'status' => $status
            ];

            if ($this->fieldModel->createField($fieldData)) {
                $_SESSION['success'] = 'Thêm sân thành công';
                header('Location: index.php?controller=field&action=list');
                exit();
            } else {
                $_SESSION['error'] = 'Thêm sân thất bại';
                header('Location: index.php?controller=field&action=create');
                exit();
            }
        }

        require_once 'views/field/create.php';
    }

    public function update() {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['error'] = 'Bạn không có quyền truy cập trang này';
            header('Location: index.php');
            exit();
        }

        if (!isset($_GET['id'])) {
            $_SESSION['error'] = 'Không tìm thấy sân';
            header('Location: index.php?controller=field&action=list');
            exit();
        }

        $field = $this->fieldModel->getFieldById($_GET['id']);
        if (!$field) {
            $_SESSION['error'] = 'Không tìm thấy sân';
            header('Location: index.php?controller=field&action=list');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $type = trim($_POST['type'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price_per_hour = floatval($_POST['price_per_hour'] ?? 0);
            $status = $_POST['status'] ?? 'available';

            if (empty($name) || empty($type) || empty($description) || $price_per_hour <= 0) {
                $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin';
                header('Location: index.php?controller=field&action=update&id=' . $_GET['id']);
                exit();
            }

            $fieldData = [
                'name' => $name,
                'type' => $type,
                'description' => $description,
                'price_per_hour' => $price_per_hour,
                'status' => $status
            ];

            if ($this->fieldModel->updateField($_GET['id'], $fieldData)) {
                $_SESSION['success'] = 'Cập nhật sân thành công';
                header('Location: index.php?controller=field&action=list');
                exit();
            } else {
                $_SESSION['error'] = 'Cập nhật sân thất bại';
                header('Location: index.php?controller=field&action=update&id=' . $_GET['id']);
                exit();
            }
        }

        require_once 'views/field/update.php';
    }

    public function delete() {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['error'] = 'Bạn không có quyền truy cập trang này';
            header('Location: index.php');
            exit();
        }

        if (!isset($_GET['id'])) {
            $_SESSION['error'] = 'Không tìm thấy sân';
            header('Location: index.php?controller=field&action=list');
            exit();
        }

        if ($this->fieldModel->deleteField($_GET['id'])) {
            $_SESSION['success'] = 'Xóa sân thành công';
        } else {
            $_SESSION['error'] = 'Xóa sân thất bại';
        }

        header('Location: index.php?controller=field&action=list');
        exit();
    }
}
?> 