<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Library - My Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/public/css/user.css">
</head>
<body class="bg-light">

<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-success p-3 rounded shadow-sm">
            <li class="breadcrumb-item"><a href="/" class="text-white text-decoration-none"><i class="fas fa-home me-1"></i> Home</a></li>
            <li class="breadcrumb-item active text-white-50" aria-current="page">My Profile</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-lg-4 col-xl-3">
            <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                <div class="card-body text-center pt-4">
                    <div class="avatar-circle mx-auto mb-3 shadow-sm bg-success text-white d-flex align-items-center justify-content-center fw-bold fs-2">
                        <?= strtoupper(substr($user['full_name'] ?? 'U', 0, 2)) ?>
                    </div>
                    <h5 class="fw-bold mb-0 text-dark"><?= htmlspecialchars($user['full_name']) ?></h5>
                    <p class="text-muted small mb-3">@<?= htmlspecialchars($user['username']) ?></p>
                    <span class="badge rounded-pill bg-success-light text-success border border-success px-3 py-2">
                        <i class="fas fa-check-circle me-1"></i> <?= ucfirst($user['status']) ?>
                    </span>
                </div>
                
                <div class="card-body border-top bg-white">
                    <div class="d-flex mb-3 align-items-start">
                        <i class="fas fa-envelope text-success mt-1 me-3"></i>
                        <div><small class="text-muted d-block">Email</small><span class="fw-medium small text-break"><?= $user['email'] ?></span></div>
                    </div>
                    <div class="d-flex mb-3 align-items-start">
                        <i class="fas fa-phone text-success mt-1 me-3"></i>
                        <div><small class="text-muted d-block">Phone Number</small><span class="fw-medium small"><?= $user['phone'] ?? 'Not updated' ?></span></div>
                    </div>
                    <div class="d-flex mb-3 align-items-start">
                        <i class="fas fa-map-marker-alt text-success mt-1 me-3"></i>
                        <div><small class="text-muted d-block">Address</small><span class="fw-medium small"><?= $user['address'] ?? 'Not updated' ?></span></div>
                    </div>
                    <div class="d-flex align-items-start">
                        <i class="fas fa-calendar-alt text-success mt-1 me-3"></i>
                        <div><small class="text-muted d-block">Member Since</small><span class="fw-medium small"><?= date('M d, Y', strtotime($user['created_at'])) ?></span></div>
                    </div>
                </div>

                <div class="card-footer bg-light border-0 p-3">
                    <div class="d-grid gap-2">
                        <a href="/profile/edit" class="btn btn-outline-dark btn-sm py-2 shadow-sm"><i class="fas fa-user-edit me-2"></i>Edit Profile</a>
                        <a href="/profile/change-password" class="btn btn-dark btn-sm py-2 shadow-sm"><i class="fas fa-key me-2"></i>Change Password</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 col-xl-9">
            <div class="row g-3 mb-4 text-center">
                <div class="col-6 col-md-4">
                    <div class="card border-0 shadow-sm h-100 p-3 stat-card">
                        <p class="text-muted small text-uppercase mb-1 fw-bold">Borrowed</p>
                        <h2 class="fw-bold text-primary mb-0"><?= $stats['currently_borrowed'] ?></h2>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="card border-0 shadow-sm h-100 p-3 stat-card">
                        <p class="text-muted small text-uppercase mb-1 fw-bold">Returned</p>
                        <h2 class="fw-bold text-success mb-0"><?= $stats['returned_books'] ?></h2>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-sm h-100 p-3 stat-card border-bottom border-warning border-4">
                        <p class="text-muted small text-uppercase mb-1 fw-bold">Reliability</p>
                        <h2 class="fw-bold text-warning mb-0"><?= $stats['on_time_percentage'] ?>%</h2>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-book text-success me-2"></i>Recent Borrowing Activity</h6>
                    <span class="badge bg-light text-dark border fw-normal">Active Records</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Book Title</th>
                                <th>Borrowed Date</th>
                                <th>Due Date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($borrowedBooks)): foreach($borrowedBooks as $book): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-dark"><?= htmlspecialchars($book['title']) ?></td>
                                <td class="text-muted"><?= date('M d, Y', strtotime($book['borrow_date'])) ?></td>
                                <td>
                                    <span class="<?= ($book['status'] == 'overdue') ? 'text-danger fw-bold' : 'text-dark' ?>">
                                        <?= date('M d, Y', strtotime($book['due_date'])) ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill <?= ($book['status'] == 'overdue') ? 'bg-danger text-white' : 'bg-info-light text-info border border-info' ?>" style="font-size: 0.7rem;">
                                        <?= strtoupper($book['status']) ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-success rounded-pill px-3 py-1" style="font-size: 0.75rem;">Renewal</button>
                                </td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr><td colspan="5" class="text-center py-5 text-muted">No active borrowing records found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="alert alert-warning border-0 shadow-sm mt-4 p-3 d-flex align-items-start" role="alert">
                <i class="fas fa-info-circle mt-1 me-3 fs-4 text-warning"></i>
                <div>
                    <h6 class="alert-heading fw-bold mb-1">LIBRARY REGULATIONS:</h6>
                    <p class="mb-0 small text-muted">Maximum 3 books per member. Standard period: 14 days. Accounts will be suspended if books are returned more than 7 days late.</p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>