<?php require_once 'views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Danh sách sân</h2>
            
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

            <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                <a href="index.php?controller=field&action=create" class="btn btn-primary mb-3">
                    <i class="fas fa-plus"></i> Thêm sân mới
                </a>
            <?php endif; ?>

            <div class="row">
                <?php foreach ($fields as $field): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($field['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($field['description']); ?></p>
                                <p class="card-text">
                                    <strong>Giá:</strong> <?php echo number_format($field['price_per_hour']); ?> VNĐ/giờ
                                </p>
                                <p class="card-text">
                                    <strong>Trạng thái:</strong>
                                    <span class="badge <?php echo $field['status'] === 'available' ? 'bg-success' : 'bg-danger'; ?>">
                                        <?php echo $field['status'] === 'available' ? 'Có sẵn' : 'Không khả dụng'; ?>
                                    </span>
                                </p>
                            </div>
                            <div class="card-footer bg-transparent border-top-0">
                                <?php if ($field['status'] === 'available'): ?>
                                    <?php if (isset($_SESSION['user'])): ?>
                                        <a href="index.php?controller=booking&action=create&field_id=<?php echo $field['id']; ?>" 
                                           class="btn btn-primary w-100">
                                            <i class="fas fa-calendar-plus"></i> Đặt sân
                                        </a>
                                    <?php else: ?>
                                        <a href="index.php?controller=user&action=login" class="btn btn-outline-primary w-100">
                                            <i class="fas fa-sign-in-alt"></i> Đăng nhập để đặt sân
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                                    <div class="mt-2">
                                        <a href="index.php?controller=field&action=update&id=<?php echo $field['id']; ?>" 
                                           class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
                                        <a href="index.php?controller=field&action=delete&id=<?php echo $field['id']; ?>" 
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Bạn có chắc chắn muốn xóa sân này?')">
                                            <i class="fas fa-trash"></i> Xóa
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?> 