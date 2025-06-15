<?php require_once 'views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Quản lý Sân</h2>
        <a href="index.php?controller=field&action=create" class="btn btn-primary">Thêm sân mới</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sân</th>
                    <th>Loại sân</th>
                    <th>Giá</th>
                    <th>Trạng thái</th>
                    <th>Mô tả</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fields as $field): ?>
                <tr>
                    <td><?php echo $field['id']; ?></td>
                    <td><?php echo $field['name']; ?></td>
                    <td><?php echo $field['type']; ?></td>
                    <td><?php echo number_format($field['price_per_hour']); ?> VNĐ</td>
                    <td>
                        <span class="badge bg-<?php 
                            echo $field['status'] == 'available' ? 'success' : 
                                ($field['status'] == 'maintenance' ? 'warning' : 'danger'); 
                        ?>">
                            <?php echo $field['status']; ?>
                        </span>
                    </td>
                    <td><?php echo $field['description']; ?></td>
                    <td>
                        <a href="index.php?controller=field&action=update&id=<?php echo $field['id']; ?>" class="btn btn-sm btn-warning">Sửa</a>
                        <a href="index.php?controller=field&action=delete&id=<?php echo $field['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?> 