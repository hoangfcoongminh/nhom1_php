<?php require_once 'views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning">
                    <h4 class="mb-0">Cập nhật lịch đặt sân</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php 
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                            ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="index.php?controller=booking&action=update&id=<?php echo $booking['id']; ?>" method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label class="form-label">Sân</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($booking['field_name']); ?>" readonly>
                        </div>

                        <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                            <div class="mb-3">
                                <label for="status" class="form-label">Trạng thái</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="pending" <?php echo $booking['status'] === 'pending' ? 'selected' : ''; ?>>Chờ xác nhận</option>
                                    <option value="confirmed" <?php echo $booking['status'] === 'confirmed' ? 'selected' : ''; ?>>Đã xác nhận</option>
                                    <option value="cancelled" <?php echo $booking['status'] === 'cancelled' ? 'selected' : ''; ?>>Đã hủy</option>
                                </select>
                            </div>
                        <?php else: ?>
                            <div class="mb-3">
                                <label for="booking_date" class="form-label">Ngày đặt</label>
                                <input type="date" class="form-control" id="booking_date" name="booking_date" 
                                       value="<?php echo $booking['booking_date']; ?>" min="<?php echo date('Y-m-d'); ?>" required>
                                <div class="invalid-feedback">Vui lòng chọn ngày đặt</div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="start_time" class="form-label">Giờ bắt đầu</label>
                                    <input type="time" class="form-control" id="start_time" name="start_time" 
                                           value="<?php echo date('H:i', strtotime($booking['start_time'])); ?>" required>
                                    <div class="invalid-feedback">Vui lòng chọn giờ bắt đầu</div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="end_time" class="form-label">Giờ kết thúc</label>
                                    <input type="time" class="form-control" id="end_time" name="end_time" 
                                           value="<?php echo date('H:i', strtotime($booking['end_time'])); ?>" required>
                                    <div class="invalid-feedback">Vui lòng chọn giờ kết thúc</div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Cập nhật
                            </button>
                            <a href="index.php?controller=booking&action=list" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Form validation
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()

// Time validation
document.getElementById('end_time')?.addEventListener('change', function() {
    var start = document.getElementById('start_time').value;
    var end = this.value;
    if (start && end && start >= end) {
        alert('Giờ kết thúc phải sau giờ bắt đầu');
        this.value = '';
    }
});
</script>

<?php require_once 'views/layouts/footer.php'; ?> 