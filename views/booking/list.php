<?php require_once 'views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Quản lý Danh sách đơn đặt sân</h2>

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

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Sân</th>
                            <th>Ngày đặt</th>
                            <th>Giờ bắt đầu</th>
                            <th>Giờ kết thúc</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td><?php echo $booking['id']; ?></td>
                                <td><?php echo htmlspecialchars($booking['field_name']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($booking['booking_date'])); ?></td>
                                <td><?php echo date('H:i', strtotime($booking['start_time'])); ?></td>
                                <td><?php echo date('H:i', strtotime($booking['end_time'])); ?></td>
                                <td><?php echo number_format($booking['total_price']); ?> VNĐ</td>
                                <td>
                                    <span class="badge <?php 
                                        echo match($booking['status']) {
                                            'pending' => 'bg-warning',
                                            'confirmed' => 'bg-success',
                                            'cancelled' => 'bg-danger',
                                            default => 'bg-secondary'
                                        };
                                    ?>">
                                        <?php 
                                        echo match($booking['status']) {
                                            'pending' => 'Chờ xác nhận',
                                            'confirmed' => 'Đã xác nhận',
                                            'cancelled' => 'Đã hủy',
                                            default => 'Không xác định'
                                        };
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($_SESSION['user']['role'] === 'admin' || $booking['user_id'] === $_SESSION['user']['id']): ?>
                                        <a href="index.php?controller=booking&action=update&id=<?php echo $booking['id']; ?>" 
                                           class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
                                        <a href="index.php?controller=booking&action=delete&id=<?php echo $booking['id']; ?>" 
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Bạn có chắc chắn muốn xóa lịch đặt sân này?')">
                                            <i class="fas fa-trash"></i> Xóa
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?> 