<?php
require_once 'models/User.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function index() {
        $users = $this->userModel->getAllUsers();
        require_once 'views/user/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $full_name = $_POST['full_name'];
            $phone = $_POST['phone'];
            $role = $_POST['role'];

            if ($this->userModel->createUser($username, $password, $email, $full_name, $phone, $role)) {
                header('Location: index.php?controller=user&action=index');
                exit();
            }
        }
        require_once 'views/user/create.php';
    }

    public function update() {
        // Check login
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để cập nhật thông tin';
            header('Location: index.php?controller=user&action=login');
            exit();
        }

        $userId = $_SESSION['user']['id'];
        $user = $this->userModel->getUserById($userId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get and trim input
            $email = trim($_POST['email'] ?? '');
            $full_name = trim($_POST['full_name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $current_password = trim($_POST['current_password'] ?? '');
            $new_password = trim($_POST['new_password'] ?? '');
            $confirm_password = trim($_POST['confirm_password'] ?? '');

            // Validate input
            if (empty($full_name)) {
                $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin bắt buộc';
                header('Location: index.php?controller=user&action=update');
                exit();
            }

            // Check email exists (if changed)
            if ($email !== $user['email'] && $this->userModel->getUserByEmail($email)) {
                $_SESSION['error'] = 'Email đã tồn tại';
                header('Location: index.php?controller=user&action=update');
                exit();
            }

            // Prepare update data
            $updateData = [
                'email' => $email,
                'full_name' => $full_name,
                'phone' => $phone
            ];

            // Handle password change
            if (!empty($current_password)) {
                if (!password_verify($current_password, $user['password'])) {
                    $_SESSION['error'] = 'Mật khẩu hiện tại không đúng';
                    header('Location: index.php?controller=user&action=update');
                    exit();
                }

                if ($new_password !== $confirm_password) {
                    $_SESSION['error'] = 'Mật khẩu mới không khớp';
                    header('Location: index.php?controller=user&action=update');
                    exit();
                }

                $updateData['password'] = $new_password;
            }

            // Update user
            if ($this->userModel->updateUser($userId, $updateData)) {
                // Update session
                $_SESSION['user']['email'] = $email;
                $_SESSION['user']['full_name'] = $full_name;
                
                $_SESSION['success'] = 'Cập nhật thông tin thành công!';
                header('Location: index.php?controller=user&action=update');
                exit();
            } else {
                $_SESSION['error'] = 'Cập nhật thông tin thất bại';
                header('Location: index.php?controller=user&action=update');
                exit();
            }
        }

        // Display update form
        require_once 'views/user/update.php';
    }

    public function delete() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($this->userModel->deleteUser($id)) {
                header('Location: index.php?controller=user&action=index');
                exit();
            }
        }
        header('Location: index.php?controller=user&action=index');
        exit();
    }

    public function login() {
        // Nếu đã đăng nhập thì chuyển về trang chủ
        if (isset($_SESSION['user'])) {
            header('Location: index.php');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            // Validate input
            if (empty($username) || empty($password)) {
                $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin';
                header('Location: index.php?controller=user&action=login');
                exit();
            }

            // Get user from database
            $user = $this->userModel->getUserByUsername($username);
            
            // Verify password and login
            if ($user && password_verify($password, $user['password'])) {
                // Set session
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'full_name' => $user['full_name'],
                    'role' => $user['role']
                ];

                // Set success message
                $_SESSION['success'] = 'Đăng nhập thành công!';

                // Redirect based on role
                if ($user['role'] === 'admin') {
                    header('Location: index.php?controller=admin&action=dashboard');
                } else {
                    header('Location: index.php');
                }
                exit();
            } else {
                $_SESSION['error'] = 'Tên đăng nhập hoặc mật khẩu không đúng';
                header('Location: index.php?controller=user&action=login');
                exit();
            }
        }

        // Display login form
        require_once 'views/user/login.php';
    }

    public function logout() {
        // Clear all session data
        session_unset();
        session_destroy();
        
        // Start new session for messages
        session_start();
        $_SESSION['success'] = 'Đăng xuất thành công!';
        
        // Redirect to home
        header('Location: index.php');
        exit();
    }

    public function register() {
        // Nếu đã đăng nhập thì chuyển về trang chủ
        if (isset($_SESSION['user'])) {
            header('Location: index.php');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get and trim input
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $confirm_password = trim($_POST['confirm_password'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $full_name = trim($_POST['full_name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');

            // Validate input
            if (empty($username) || empty($password) || empty($confirm_password) || empty($full_name)) {
                $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin bắt buộc';
                header('Location: index.php?controller=user&action=register');
                exit();
            }

            // Check password match
            if ($password !== $confirm_password) {
                $_SESSION['error'] = 'Mật khẩu xác nhận không khớp';
                header('Location: index.php?controller=user&action=register');
                exit();
            }

            // Check username exists
            if ($this->userModel->getUserByUsername($username)) {
                $_SESSION['error'] = 'Tên đăng nhập đã tồn tại';
                header('Location: index.php?controller=user&action=register');
                exit();
            }

            // Check email exists
            if ($this->userModel->getUserByEmail($email)) {
                $_SESSION['error'] = 'Email đã tồn tại';
                header('Location: index.php?controller=user&action=register');
                exit();
            }

            // Create user data array
            $userData = [
                'username' => $username,
                'password' => $password,
                'email' => $email,
                'full_name' => $full_name,
                'phone' => $phone,
                'role' => 'user'
            ];

            // Create user
            if ($this->userModel->createUser($userData)) {
                // Get created user
                $user = $this->userModel->getUserByUsername($username);
                
                // Set session
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'full_name' => $user['full_name'],
                    'role' => $user['role']
                ];

                // Set success message
                $_SESSION['success'] = 'Đăng ký thành công!';

                // Redirect to home
                header('Location: index.php');
                exit();
            } else {
                $_SESSION['error'] = 'Đăng ký thất bại, vui lòng thử lại';
                header('Location: index.php?controller=user&action=register');
                exit();
            }
        }

        // Display register form
        require_once 'views/user/register.php';
    }
}
?> 