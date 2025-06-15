<?php
session_start();

// Định nghĩa các hằng số
define('ROOT_PATH', __DIR__);
define('BASE_URL', 'http://localhost/Nhom1_PHP');

// Autoload các class
spl_autoload_register(function ($class_name) {
    $file = ROOT_PATH . '/' . str_replace('\\', '/', $class_name) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Xử lý routing
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Nếu không có controller và action, mặc định hiển thị trang chủ
if (empty($_GET)) {
    $controller = 'home';
    $action = 'index';
}

// Kiểm tra và load controller
$controller_file = ROOT_PATH . '/controllers/' . ucfirst($controller) . 'Controller.php';
if (file_exists($controller_file)) {
    require_once $controller_file;
    $controller_class = ucfirst($controller) . 'Controller';
    $controller_instance = new $controller_class();
    
    // Kiểm tra và gọi action
    if (method_exists($controller_instance, $action)) {
        $controller_instance->$action();
    } else {
        // Nếu action không tồn tại, chuyển hướng về trang chủ
        header('Location: ' . BASE_URL);
        exit();
    }
} else {
    // Nếu controller không tồn tại, chuyển hướng về trang chủ
    header('Location: ' . BASE_URL);
    exit();
}
