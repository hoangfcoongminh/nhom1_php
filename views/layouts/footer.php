    </div> <!-- Đóng container từ header -->
    
    <div class="content">
        <footer class="footer bg-dark text-light py-4 mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h5>Liên hệ</h5>
                        <p><i class="fas fa-map-marker-alt me-2"></i> 123 Đường ABC, Quận XYZ, HÀ NỘI</p>
                        <p><i class="fas fa-phone me-2"></i> (098) 1234 5678</p>
                        <p><i class="fas fa-envelope me-2"></i> info@sanbong.com</p>
                    </div>
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h5>Giờ mở cửa</h5>
                        <p>Thứ 2 - Thứ 6: 6:00 - 22:00</p>
                        <p>Thứ 7 - Chủ nhật: 6:00 - 23:00</p>
                    </div>
                    <div class="col-md-4">
                        <h5>Theo dõi chúng tôi</h5>
                        <div class="social-links">
                            <a href="#" class="text-light me-3"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-light me-3"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-light"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <hr class="my-4">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="mb-0">&copy; 2025 Quản lý sân bóng. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <a href="#" class="text-light text-decoration-none me-3">Điều khoản sử dụng</a>
                        <a href="#" class="text-light text-decoration-none">Chính sách bảo mật</a>
                    </div>
                </div>
            </div>
        </footer>
    </div> <!-- End of content -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Thêm hiệu ứng hover cho các nút
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('mouseover', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.transition = 'all 0.3s ease';
            });
            button.addEventListener('mouseout', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Thêm hiệu ứng shadow cho các card
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mouseover', function() {
                this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
                this.style.transition = 'all 0.3s ease';
            });
            card.addEventListener('mouseout', function() {
                this.style.boxShadow = 'none';
            });
        });
    </script>
</body>
</html> 