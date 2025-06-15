<?php include 'views/layouts/header.php'; ?>

<section class="hero-section text-center">
    <div class="container">
        <h1 class="display-4 mb-4">Hệ thống quản lý sân thể thao</h1>
        <p class="lead mb-4">Giải pháp toàn diện cho việc quản lý và đặt sân thể thao</p>
        <a href="index.php?controller=booking&action=list" class="btn btn-primary btn-lg">
            <i class="fas fa-calendar-plus me-2"></i>Đặt sân ngay
        </a>
    </div>
</section>

<?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
<section class="container">
    <h2 class="text-center mb-5">Tính năng chính</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card feature-card">
                <div class="card-body text-center">
                    <div class="feature-icon">
                        <i class="fas fa-futbol fa-2x"></i>
                    </div>
                    <h5 class="card-title">Quản lý sân</h5>
                    <p class="card-text">Quản lý thông tin sân, cập nhật trạng thái và giá cả một cách dễ dàng</p>
                    <a href="index.php?controller=field" class="btn btn-outline-primary">Xem chi tiết</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card feature-card">
                <div class="card-body text-center">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-alt fa-2x"></i>
                    </div>
                    <h5 class="card-title">Đặt sân</h5>
                    <p class="card-text">Đặt lịch nhanh chóng, theo dõi lịch sử đặt sân và quản lý đơn đặt</p>
                    <a href="index.php?controller=booking&action=list" class="btn btn-outline-primary">Xem chi tiết</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card feature-card">
                <div class="card-body text-center">
                    <div class="feature-icon">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <h5 class="card-title">Quản lý người dùng</h5>
                    <p class="card-text">Phân quyền người dùng, quản lý thông tin và theo dõi hoạt động</p>
                    <a href="index.php?controller=user&action=index" class="btn btn-outline-primary">Xem chi tiết</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="fas fa-futbol fa-2x mb-3 text-primary"></i>
                    <div class="stat-number">10+</div>
                    <div class="stat-label">Sân thể thao</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="fas fa-users fa-2x mb-3 text-primary"></i>
                    <div class="stat-number">1000+</div>
                    <div class="stat-label">Người dùng</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="fas fa-calendar-check fa-2x mb-3 text-primary"></i>
                    <div class="stat-number">5000+</div>
                    <div class="stat-label">Lượt đặt sân</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="testimonial-section">
    <div class="container">
        <h2 class="text-center mb-5">Phản hồi từ khách hàng</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="testimonial-card">
                    <p class="testimonial-text">"Hệ thống đặt sân rất tiện lợi, giúp tôi dễ dàng quản lý lịch đá bóng của mình."</p>
                    <div class="testimonial-author">- Nguyễn Văn A</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card">
                    <p class="testimonial-text">"Giao diện thân thiện, dễ sử dụng. Tôi rất hài lòng với dịch vụ này."</p>
                    <div class="testimonial-author">- Trần Thị B</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card">
                    <p class="testimonial-text">"Quản lý sân chuyên nghiệp, giá cả hợp lý. Sẽ tiếp tục sử dụng dịch vụ."</p>
                    <div class="testimonial-author">- Lê Văn C</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section text-center">
    <div class="container">
        <h2 class="mb-4">Bắt đầu sử dụng ngay hôm nay</h2>
        <p class="lead mb-4">Đăng ký tài khoản để trải nghiệm đầy đủ tính năng của hệ thống</p>
        <a href="index.php?controller=user&action=register" class="btn btn-light btn-lg">
            <i class="fas fa-user-plus me-2"></i>Đăng ký ngay
        </a>
    </div>
</section>

<?php include 'views/layouts/footer.php'; ?> 