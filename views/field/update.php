<?php require_once 'views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Cập nhật thông tin sân</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?controller=field&action=update&id=<?php echo $field['id']; ?>" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sân</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $field['name']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Loại sân</label>
                            <input type="text" class="form-control" id="type" name="type" value="<?php echo $field['type']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="price_per_hour" class="form-label">Giá theo giờ (VNĐ)</label>
                            <input type="number" class="form-control" id="price_per_hour" name="price_per_hour" value="<?php echo $field['price_per_hour']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="available" <?php echo $field['status'] == 'available' ? 'selected' : ''; ?>>Có sẵn</option>
                                <option value="maintenance" <?php echo $field['status'] == 'maintenance' ? 'selected' : ''; ?>>Bảo trì</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?php echo $field['description']; ?></textarea>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="index.php?controller=field&action=index" class="btn btn-secondary">Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?> 