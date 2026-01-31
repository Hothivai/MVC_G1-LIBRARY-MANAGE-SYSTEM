<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Import Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/admin.css">
</head>
<body>
<div class="d-flex">
    <?php require_once APP_PATH . '/views/admin/sidebarAdmin.php'; ?>

    <div class="main-content flex-grow-1 bg-light">
        <nav class="navbar navbar-light bg-white px-4 border-bottom">
            <span class="navbar-brand fw-bold">Import Books from Excel/CSV</span>
            <div class="d-flex align-items-center">
                <span class="me-2 fw-bold">Admin</span>
                <i class="bi bi-person-circle fs-3"></i>
            </div>
        </nav>

        <div class="p-4">
            <div class="card border-0 shadow-sm" style="max-width: 900px; margin: 0 auto;">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-file-earmark-spreadsheet me-2"></i>Import Sách từ Excel/CSV</h5>
                </div>
                <div class="card-body p-4">
                    
                    <!-- Instructions -->
                    <div class="alert alert-info mb-4">
                        <h6 class="alert-heading"><i class="bi bi-info-circle-fill me-2"></i>Hướng dẫn:</h6>
                        <ol class="mb-0 ps-3">
                            <li>Hỗ trợ các định dạng file: <strong>.xlsx, .xls, .csv</strong></li>
                            <li>File phải có dòng tiêu đề (header) với các cột theo thứ tự: <br>
                                <code class="bg-light p-1 rounded">Title, Author, Category Name, ISBN, Publisher, Year, Quantity, Description</code>
                            </li>
                            <li>Cột <strong>Category Name</strong> phải khớp với danh mục có sẵn trong hệ thống (hoặc chọn tự động tạo danh mục mới).</li>
                            <li>Cột <strong>Title</strong> là bắt buộc, các cột khác có thể để trống.</li>
                        </ol>
                    </div>

                    <!-- Supported Formats -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="border rounded p-3 text-center h-100">
                                <i class="bi bi-file-earmark-excel text-success fs-1"></i>
                                <p class="mb-0 mt-2"><strong>.xlsx</strong></p>
                                <small class="text-muted">Excel 2007+</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-3 text-center h-100">
                                <i class="bi bi-file-earmark-excel text-success fs-1"></i>
                                <p class="mb-0 mt-2"><strong>.xls</strong></p>
                                <small class="text-muted">Excel 97-2003</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border rounded p-3 text-center h-100">
                                <i class="bi bi-filetype-csv text-primary fs-1"></i>
                                <p class="mb-0 mt-2"><strong>.csv</strong></p>
                                <small class="text-muted">Comma Separated</small>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Form -->
                    <form action="<?= defined('URLROOT') ? URLROOT : '' ?>/index.php?action=admin_books_import_store" method="POST" enctype="multipart/form-data" id="importForm">
                        <div class="mb-4">
                            <label for="import_file" class="form-label fw-bold">
                                <i class="bi bi-cloud-upload me-1"></i> Chọn file Excel/CSV
                            </label>
                            <input type="file" name="import_file" id="import_file" class="form-control form-control-lg" 
                                   accept=".xlsx,.xls,.csv" required>
                            <div class="form-text">Kích thước tối đa: 10MB</div>
                        </div>

                        <!-- Options -->
                        <div class="mb-4 p-3 bg-light rounded">
                            <h6 class="fw-bold mb-3"><i class="bi bi-gear me-1"></i> Tùy chọn Import</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="create_category" value="1" id="create_category">
                                <label class="form-check-label" for="create_category">
                                    Tự động tạo danh mục mới nếu không tìm thấy trong hệ thống
                                </label>
                            </div>
                        </div>

                        <!-- File Preview (JavaScript) -->
                        <div id="filePreview" class="mb-4 d-none">
                            <div class="alert alert-secondary">
                                <i class="bi bi-file-earmark me-2"></i>
                                <strong>File đã chọn:</strong> <span id="fileName"></span>
                                <span class="badge bg-primary ms-2" id="fileSize"></span>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="<?= defined('URLROOT') ? URLROOT : '' ?>/index.php?action=admin_books_import_sample" class="btn btn-outline-primary" download>
                                <i class="bi bi-download me-1"></i> Tải File Mẫu (.xlsx)
                            </a>
                            <div>
                                <a href="<?= defined('URLROOT') ? URLROOT : '' ?>/index.php?action=admin_books_index" class="btn btn-secondary me-2">
                                    <i class="bi bi-x-lg me-1"></i> Hủy
                                </a>
                                <button type="submit" class="btn btn-success fw-bold px-4" id="submitBtn">
                                    <i class="bi bi-upload me-1"></i> Upload & Import
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Help Section -->
                <div class="card-footer bg-white">
                    <details>
                        <summary class="fw-bold cursor-pointer" style="cursor: pointer;">
                            <i class="bi bi-question-circle me-1"></i> Xem cấu trúc file mẫu
                        </summary>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered table-sm">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Category Name</th>
                                        <th>ISBN</th>
                                        <th>Publisher</th>
                                        <th>Year</th>
                                        <th>Quantity</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>The Great Gatsby</td>
                                        <td>F. Scott Fitzgerald</td>
                                        <td>Fiction</td>
                                        <td>978-0743273565</td>
                                        <td>Scribner</td>
                                        <td>1925</td>
                                        <td>5</td>
                                        <td>A novel about the American Dream</td>
                                    </tr>
                                    <tr>
                                        <td>Clean Code</td>
                                        <td>Robert C. Martin</td>
                                        <td>Programming</td>
                                        <td>978-0132350884</td>
                                        <td>Prentice Hall</td>
                                        <td>2008</td>
                                        <td>3</td>
                                        <td>A handbook of agile software craftsmanship</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/public/js/admin.js"></script>
<script>
// File preview
document.getElementById('import_file').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('filePreview');
    
    if (file) {
        document.getElementById('fileName').textContent = file.name;
        document.getElementById('fileSize').textContent = formatFileSize(file.size);
        preview.classList.remove('d-none');
    } else {
        preview.classList.add('d-none');
    }
});

// Format file size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Form submission loading state
document.getElementById('importForm').addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang xử lý...';
});
</script>
</body>
</html>