<?php require_once 'views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Quản lý Người dùng</h2>
        <a href="index.php?controller=user&action=create" class="btn btn-primary">Thêm người dùng</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên đăng nhập</th>
                    <th>Email</th>
                    <th>Họ tên</th>
                    <th>Số điện thoại</th>
                    <th>Vai trò</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td><?php echo $u['id']; ?></td>
                    <td><?php echo $u['username']; ?></td>
                    <td><?php echo $u['email']; ?></td>
                    <td><?php echo $u['full_name']; ?></td>
                    <td><?php echo $u['phone']; ?></td>
                    <td><?php echo $u['role']; ?></td>
                    <td>
                        <a href="index.php?controller=user&action=update&id=<?php echo $u['id']; ?>" class="btn btn-sm btn-warning">Sửa</a>
                        <a href="index.php?controller=user&action=delete&id=<?php echo $u['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?> 