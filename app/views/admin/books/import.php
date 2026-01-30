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
            <div class="card border-0 shadow-sm" style="max-width: 800px; margin: 0 auto;">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-file-earmark-spreadsheet me-2"></i>Import Data</h5>
                </div>
                <div class="card-body p-4">
                    
                    <div class="alert alert-info mb-4">
                        <h6><i class="bi bi-info-circle-fill me-2"></i>Instructions:</h6>
                        <ol class="mb-0 ps-3">
                            <li>Please prepare your Excel file and <strong>Save As .CSV (Comma delimited)</strong>.</li>
                            <li>The file must have a header row with columns in this order: <br>
                                <code>Title, Author, Category Name, ISBN, Publisher, Year, Quantity, Description</code>
                            </li>
                            <li>Ensure "Category Name" matches exactly with existing categories (or new ones will be ignored/defaulted).</li>
                        </ol>
                    </div>

                    <form action="index.php?action=admin_books_import_store" method="POST" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label for="csv_file" class="form-label fw-bold">Choose CSV File</label>
                            <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv" required>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="/public/sample_books.csv" download class="text-decoration-none fw-bold text-primary">
                                <i class="bi bi-download"></i> Download Sample File
                            </a>
                            <div>
                                <a href="index.php?action=admin_books_index" class="btn btn-secondary me-2">Cancel</a>
                                <button type="submit" class="btn btn-success fw-bold px-4">
                                    <i class="bi bi-upload"></i> Upload & Import
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>