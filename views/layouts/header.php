<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sân thể thao</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1579952363873-27f3bade9f55?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            margin-bottom: 50px;
        }
        .feature-card {
            transition: transform 0.3s;
            margin-bottom: 30px;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .feature-icon {
            width: 80px;
            height: 80px;
            background: #007bff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
        }
        .stats-section {
            background-color: #f8f9fa;
            padding: 50px 0;
            margin: 50px 0;
        }
        .stat-card {
            text-align: center;
            padding: 20px;
        }
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #007bff;
        }
        .testimonial-section {
            padding: 50px 0;
        }
        .testimonial-card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .testimonial-text {
            font-style: italic;
            margin-bottom: 15px;
        }
        .testimonial-author {
            font-weight: bold;
            color: #007bff;
        }
        .cta-section {
            background: #007bff;
            color: white;
            padding: 50px 0;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php?controller=home&action=index">
                <i class="fas fa-futbol me-2"></i>
                Hệ thống sân F1
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <?php if (isset($_SESSION['user'])): ?>
                        <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                            <!-- Menu cho Admin -->
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?controller=field">
                                    <i class="fas fa-futbol me-1"></i> Quản lý sân
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?controller=booking&action=list">
                                    <i class="fas fa-calendar-alt me-1"></i> Quản lý đơn đặt
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?controller=user&action=index">
                                    <i class="fas fa-users me-1"></i> Quản lý người dùng
                                </a>
                            </li>
                        <?php else: ?>
                            <!-- Menu cho User thường -->
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?controller=field&action=list">
                                    <i class="fas fa-list me-1"></i> Danh sách sân
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?controller=booking&action=list">
                                    <i class="fas fa-calendar-check me-1"></i> Đơn đặt của tôi
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
                <div class="d-flex">
                    <?php if (isset($_SESSION['user'])): ?>
                        <span class="navbar-text me-3">
                            <i class="fas fa-user me-1"></i> <?php echo $_SESSION['user']['username']; ?>
                        </span>
                        <a href="index.php?controller=user&action=logout" class="btn btn-outline-light">
                            <i class="fas fa-sign-out-alt me-1"></i> Đăng xuất
                        </a>
                    <?php else: ?>
                        <a href="index.php?controller=user&action=login" class="btn btn-outline-light">
                            <i class="fas fa-sign-in-alt me-1"></i> Đăng nhập
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php 
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php 
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize all dropdowns
        document.addEventListener('DOMContentLoaded', function() {
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
            var dropdownList = dropdownElementList.map(function(dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl);
            });
        });
    </script>
</body>
</html> 