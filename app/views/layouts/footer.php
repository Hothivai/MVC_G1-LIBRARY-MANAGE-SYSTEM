<footer class="main-footer" style="background: #145c38; color: #ecf0f1; margin-top: 60px; padding-top: 40px;">
    <div class="container">
        <div class="row">
            <div class="col-md-4 footer-col">
                <h4 class="footer-title">DIGITAL LIBRARY</h4>
                <p>A modern online library management system. Connecting readers to knowledge anytime, anywhere.</p>
                <img src="/public/images/logo.jpg" alt="Logo" style="max-width: 120px; margin-top: 15px;">
            </div>
            
            <div class="col-md-4 footer-col">
                <h4 class="footer-title">CONTACT</h4>
                <ul class="list-unstyled contact-list">
                    <li><i class="fa fa-map-marker"></i> 99 To Hien Thanh, Son Tra, Da Nang</li>
                    <li><i class="fa fa-phone"></i> (028) 1234 5678</li>
                    <li><i class="fa fa-envelope"></i> info@thuvienso.edu.vn</li>
                    <li><i class="fa fa-clock-o"></i> Open: 8:00 - 20:00 (Mon - Sat)</li>
                </ul>
            </div>
            
            <div class="col-md-4 footer-col">
                <h4 class="footer-title">CONNECT WITH US</h4>
                <div class="social-links">
                    <a href="#" class="social-btn facebook"><i class="fa fa-facebook"></i></a>
                    <a href="#" class="social-btn youtube"><i class="fa fa-youtube"></i></a>
                    <a href="#" class="social-btn twitter"><i class="fa fa-twitter"></i></a>
                    <a href="#" class="social-btn linkedin"><i class="fa fa-linkedin"></i></a>
                </div>
                
                <h5 style="margin-top: 25px; margin-bottom: 15px;">SUBSCRIBE TO NEWSLETTER</h5>
                <form class="form-inline">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Your email">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button">Subscribe</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        
        <hr style="border-color: #00af3a; margin: 30px 0;">
        
        <div class="row">
            <div class="col-md-6">
                <ul class="list-inline footer-links">
                    <li><a href="index.php?action=home_about">About</a></li>
                    <li><a href="#">Borrowing Policy</a></li>
                    <li><a href="#">Terms of Use</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="col-md-6 text-right">
                <p class="copyright">
                    &copy; <?= date('Y') ?> <strong>Digital Library</strong>. All Rights Reserved.<br>
                    Developed by <strong>PNV27 Team</strong>
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