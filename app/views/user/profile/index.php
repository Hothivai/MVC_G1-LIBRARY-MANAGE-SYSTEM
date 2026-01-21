<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Library - Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="/public/css/user.css">
</head>
<body>

<div class="container-fluid py-3">
    <nav aria-label="breadcrumb" class="bg-success text-white p-2 mb-4 rounded">
        <span class="ms-2">Home > Book > PHP Fundamentals</span>
    </nav>

    <div class="row">
        <div class="col-md-3">
            <div class="card p-3 text-center mb-3">
                <div class="avatar-circle mx-auto mb-3">NV</div>
                <h4 class="fw-bold">Nguyen Van</h4>
                <span class="badge bg-success-light text-success border border-success mb-3">
                    <i class="fas fa-check-square me-1"></i> Active
                </span>
            </div>

            <div class="card p-3 mb-3 info-section">
                <p><i class="fas fa-envelope me-2"></i> <strong>Email:</strong></p>
                <hr>
                <p><i class="fas fa-phone me-2"></i> <strong>Phone:</strong></p>
                <hr>
                <p><i class="fas fa-map-marker-alt me-2"></i> <strong>Address:</strong></p>
                <hr>
                <p><i class="fas fa-calendar-alt me-2"></i> <strong>Start date:</strong></p>
            </div>

            <button class="btn btn-outline-dark w-100 mb-2 py-2">
                <i class="fas fa-edit me-2"></i> Edit information (LMS-31)
            </button>
            <button class="btn btn-outline-dark w-100 py-2">
                <i class="fas fa-key me-2"></i> Change password (LMS-33)
            </button>
        </div>

        <div class="col-md-9">
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="stat-card p-3 text-center">
                        <small>Currently borrowed</small>
                        <h3>3</h3>
                        <a href="#" class="text-decoration-none text-muted small">View Details</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card p-3 text-center">
                        <small>Returned books</small>
                        <h3>15</h3>
                        <a href="#" class="text-decoration-none text-muted small">View History</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card p-3 text-center">
                        <small>On-time books</small>
                        <h3>15</h3>
                        <p class="text-muted small mb-0">Overdue books</p>
                    </div>
                </div>
            </div>

            <div class="table-responsive shadow-sm">
                <table class="table align-middle border">
                    <thead class="table-success-custom">
                        <tr>
                            <th>Book title</th>
                            <th>Borrowed date</th>
                            <th>Return date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>PHP Fundamentals</strong></td>
                            <td>01/12/2024</td>
                            <td class="text-success">15/12/2024</td>
                            <td class="text-center"><button class="btn btn-sm btn-outline-secondary px-3">Renewal</button></td>
                        </tr>
                        <tr>
                            <td><strong>Database design</strong></td>
                            <td>25/11/2024</td>
                            <td class="text-warning">09/12/2024</td>
                            <td class="text-center"><button class="btn btn-sm btn-outline-secondary px-3">Return</button></td>
                        </tr>
                        <tr>
                            <td><strong>Communication</strong></td>
                            <td>28/11/2024</td>
                            <td class="text-success">12/12/2024</td>
                            <td class="text-center"><button class="btn btn-sm btn-outline-secondary px-3">Renewal</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="alert alert-secondary mt-4 regulation-box">
                <h6><i class="fas fa-lightbulb text-warning me-2"></i> REGULATIONS :</h6>
                <ul class="small mb-0">
                    <li>Each member can borrow a maximum of 3 books at a time</li>
                    <li>Borrowing period: 14 days</li>
                    <li>Account will be locked for 7 days if books are returned late.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

</body>
</html>