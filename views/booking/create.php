<?php require_once 'views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Đặt sân</h4>
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

                    <form action="index.php?controller=booking&action=create" method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="field_id" class="form-label">Chọn sân</label>
                            <select class="form-select" id="field_id" name="field_id" required>
                                <option value="">Chọn sân...</option>
                                <?php foreach ($fields as $field): ?>
                                    <option value="<?php echo $field['id']; ?>" 
                                            <?php echo isset($_GET['field_id']) && $_GET['field_id'] == $field['id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($field['name']); ?> - 
                                        <?php echo number_format($field['price_per_hour']); ?> VNĐ/giờ
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Vui lòng chọn sân</div>
                        </div>

                        <div class="mb-3">
                            <label for="booking_date" class="form-label">Ngày đặt</label>
                            <input type="date" class="form-control" id="booking_date" name="booking_date" 
                                   min="<?php echo date('Y-m-d'); ?>" required>
                            <div class="invalid-feedback">Vui lòng chọn ngày đặt</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_time" class="form-label">Giờ bắt đầu</label>
                                <input type="time" class="form-control" id="start_time" name="start_time" required>
                                <div class="invalid-feedback">Vui lòng chọn giờ bắt đầu</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="end_time" class="form-label">Giờ kết thúc</label>
                                <input type="time" class="form-control" id="end_time" name="end_time" required>
                                <div class="invalid-feedback">Vui lòng chọn giờ kết thúc</div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-calendar-check"></i> Đặt sân
                            </button>
                            <a href="index.php?controller=field&action=list" class="btn btn-secondary">
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
document.getElementById('end_time').addEventListener('change', function() {
    var start = document.getElementById('start_time').value;
    var end = this.value;
    if (start && end && start >= end) {
        alert('Giờ kết thúc phải sau giờ bắt đầu');
        this.value = '';
    }
});
</script>

<?php require_once 'views/layouts/footer.php'; ?> 