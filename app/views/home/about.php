<?php 
// Nạp các thành phần layout dùng chung
    require_once __DIR__ . '/../layouts/header.php';
    require_once __DIR__ . '/../layouts/navbar.php';
?>

<section class="about-hero" style="background-color: #145c38; color: white; padding: 60px 0; text-align: center;">
    <div class="container">
        <h1 style="font-weight: 800; font-size: 36px; margin-bottom: 20px;">ABOUT TMV DIGITAL LIBRARY</h1>
        <p style="font-size: 18px; max-width: 800px; margin: 0 auto; opacity: 0.9;">
            Connecting knowledge, nurturing passion. We provide a modern reading space and a rich digital library for the community of Da Nang.
        </p>
    </div>
</section>

<div class="container" style="margin-top: 50px; margin-bottom: 80px;">
    <div class="row">
        <div class="col-md-6">
            <h3 style="color: #16A34A; font-weight: 700; margin-bottom: 25px; border-left: 5px solid #16A34A; padding-left: 15px;">
                Our Mission
            </h3>
            <p style="line-height: 1.8; text-align: justify;">
                TMV Digital Library is not just a repository of books, but also a cultural and educational center in Son Tra District. With the goal of promoting reading culture, we continuously update our collection with the latest titles in technology, economics, psychology, and world literature.
            </p>
            <p style="line-height: 1.8; text-align: justify;">
                Founded by the <strong>PNV27 Team</strong>, we are committed to providing a smart, transparent, and convenient book borrowing and returning system for all readers.
            </p>
            
            <div class="row mt-4">
                <div class="col-xs-6">
                    <div class="stat-box" style="text-align: center; padding: 20px; border: 1px solid #eee; border-radius: 12px; transition: 0.3s;">
                        <h2 style="color: #16A34A; font-weight: 800; margin-bottom: 5px;">5000+</h2>
                        <span class="text-muted">Books</span>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="stat-box" style="text-align: center; padding: 20px; border: 1px solid #eee; border-radius: 12px; transition: 0.3s;">
                        <h2 style="color: #16A34A; font-weight: 800; margin-bottom: 5px;">1200+</h2>
                        <span class="text-muted">Readers</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="contact-card shadow-sm p-4 bg-white rounded border-top border-success border-4" style="margin-bottom: 30px;">
                <h4 class="fw-bold mb-4 text-success" style="font-weight: 700;"><i class="fa fa-map-marker me-2"></i> Contact Information</h4>
                <ul class="list-unstyled" style="line-height: 2.5;">
                    <li><i class="fa fa-home text-success" style="width: 25px;"></i> <strong>Address:</strong> 99 To Hien Thanh, Phuoc My, Son Tra, Da Nang</li>
                    <li><i class="fa fa-phone text-success" style="width: 25px;"></i> <strong>Hotline:</strong> (028) 1234 5678</li>
                    <li><i class="fa fa-envelope text-success" style="width: 25px;"></i> <strong>Email:</strong> info@thuvienso.edu.vn</li>
                    <li><i class="fa fa-clock-o text-success" style="width: 25px;"></i> <strong>Opening Hours:</strong> 8:00 - 20:00 (Monday - Saturday)</li>
                </ul>
            </div>

            <div class="map-container shadow-sm" style="border-radius: 12px; overflow: hidden; height: 300px; border: 1px solid #eee;">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3834.1103350106176!2d108.24146331485848!3d16.059758288887413!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3142177f191ba369%3A0xc315c1064104760a!2zOTkgVMO0IEhp4bq_biBUaMOgbmgsIFBox4bubYyBN4bu5LCBTxqWbiIFRyw6AsIMSQw6AgTuG6tW5n!5e0!3m2!1svi!2s!4v1700000000000!5m2!1svi!2s" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
            <div class="text-center mt-2">
                <a href="https://maps.app.goo.gl/YfSgW6X7Z6v9" target="_blank" class="btn btn-link text-success small" style="text-decoration: none;">
                    <i class="fa fa-external-link"></i> View on Google Maps
                </a>
            </div>
        </div>
    </div>
</div>

<style>
/* Hiệu ứng hover cho các ô thống kê */
.stat-box:hover {
    border-color: #16A34A !important;
    background-color: #f0f9f4;
    transform: translateY(-5px);
}
/* Đồng bộ màu sắc với dự án */
.text-success { color: #16A34A !important; }
.border-success { border-color: #16A34A !important; }
.bg-success { background-color: #16A34A !important; }
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>