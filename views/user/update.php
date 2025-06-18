<?php require_once 'views/layouts/header.php'; ?>

<div class="container mt-4">
    <h2>Cập nhật người dùng</h2>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php 
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>
    <form action="index.php?controller=user&action=update&id=<?php echo $user['id']; ?>" method="POST" class="needs-validation" novalidate>
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <div class="mb-3">
            <label for="username" class="form-label">Tên đăng nhập</label>
            <input type="text" class="form-control" id="username" name="username" 
                   value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu mới (để trống nếu không muốn thay đổi)</label>
            <input type="password" class="form-control" id="newPassword" name="newPassword">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" 
                   value="<?php echo htmlspecialchars($user['email']); ?>">
        </div>
        <div class="mb-3">
            <label for="full_name" class="form-label">Họ và tên</label>
            <input type="text" class="form-control" id="full_name" name="full_name" 
                   value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại</label>
            <input type="tel" class="form-control" id="phone" name="phone" 
                   value="<?php echo htmlspecialchars($user['phone']); ?>">
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Vai trò</label>
            <select class="form-select" id="role" name="role" required>
                <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>Người dùng</option>
                <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Quản trị viên</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="index.php?controller=user&action=index" class="btn btn-secondary">Quay lại</a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.needs-validation');
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});
</script>

<?php require_once 'views/layouts/footer.php'; ?> 