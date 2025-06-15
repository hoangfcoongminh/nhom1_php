<?php require_once 'views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Quản lý đặt sân</h2>
        <a href="index.php?controller=booking&action=create" class="btn btn-primary">Đặt sân mới</a>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php 
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sân</th>
                    <th>Người đặt</th>
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
                    <td><?php echo $booking['field_name']; ?></td>
                    <td><?php echo $booking['username']; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($booking['booking_date'])); ?></td>
                    <td><?php echo date('H:i', strtotime($booking['start_time'])); ?></td>
                    <td><?php echo date('H:i', strtotime($booking['end_time'])); ?></td>
                    <td><?php echo number_format($booking['total_price']); ?> VNĐ</td>
                    <td>
                        <span class="badge bg-<?php 
                            echo $booking['status'] == 'confirmed' ? 'success' : 
                                ($booking['status'] == 'pending' ? 'warning' : 
                                ($booking['status'] == 'cancelled' ? 'danger' : 'secondary')); 
                        ?>">
                            <?php echo $booking['status']; ?>
                        </span>
                    </td>
                    <td>
                        <a href="index.php?controller=booking&action=update&id=<?php echo $booking['id']; ?>" class="btn btn-sm btn-warning">Sửa</a>
                        <a href="index.php?controller=booking&action=delete&id=<?php echo $booking['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?> 