<footer class="main-footer" style="background: #2c3e50; color: #ecf0f1; margin-top: 60px; padding-top: 40px;">
    <div class="container">
        <div class="row">
            <div class="col-md-4 footer-col">
                <h4 class="footer-title">THƯ VIỆN SỐ</h4>
                <p>Hệ thống quản lý thư viện trực tuyến hiện đại. Kết nối độc giả với tri thức mọi lúc, mọi nơi.</p>
                <img src="/images/logo.png" alt="Logo" style="max-width: 120px; margin-top: 15px;">
            </div>
            
            <div class="col-md-4 footer-col">
                <h4 class="footer-title">LIÊN HỆ</h4>
                <ul class="list-unstyled contact-list">
                    <li><i class="fa fa-map-marker"></i> 123 Đường Sách, Quận 1, TP.HCM</li>
                    <li><i class="fa fa-phone"></i> (028) 1234 5678</li>
                    <li><i class="fa fa-envelope"></i> info@thuvienso.edu.vn</li>
                    <li><i class="fa fa-clock-o"></i> Mở cửa: 8:00 - 20:00 (T2 - T7)</li>
                </ul>
            </div>
            
            <div class="col-md-4 footer-col">
                <h4 class="footer-title">KẾT NỐI VỚI CHÚNG TÔI</h4>
                <div class="social-links">
                    <a href="#" class="social-btn facebook"><i class="fa fa-facebook"></i></a>
                    <a href="#" class="social-btn youtube"><i class="fa fa-youtube"></i></a>
                    <a href="#" class="social-btn twitter"><i class="fa fa-twitter"></i></a>
                    <a href="#" class="social-btn linkedin"><i class="fa fa-linkedin"></i></a>
                </div>
                
                <h5 style="margin-top: 25px; margin-bottom: 15px;">ĐĂNG KÝ NHẬN THÔNG BÁO</h5>
                <form class="form-inline">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Email của bạn">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button">Đăng ký</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        
        <hr style="border-color: #4a5f7a; margin: 30px 0;">
        
        <div class="row">
            <div class="col-md-6">
                <ul class="list-inline footer-links">
                    <li><a href="/about">Giới thiệu</a></li>
                    <li><a href="#">Chính sách mượn sách</a></li>
                    <li><a href="#">Điều khoản sử dụng</a></li>
                    <li><a href="#">Chính sách bảo mật</a></li>
                </ul>
            </div>
            <div class="col-md-6 text-right">
                <p class="copyright">
                    &copy; <?= date('Y') ?> <strong>Thư Viện Số</strong>. All Rights Reserved.<br>
                    Phát triển bởi <strong>PNV27 Team</strong>
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="/js/main.js"></script>
<?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
<script src="/js/admin.js"></script>
<?php else: ?>
<script src="/js/user.js"></script>
<?php endif; ?>
</body>
</html>