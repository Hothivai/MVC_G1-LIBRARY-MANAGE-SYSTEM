<?php ?>
<?php include '../app/views/layouts/header.php'; ?>

<section class="admin-transactions">
    <h1>Quản Lý Giao Dịch Mượn/Trả</h1>
    <a href="/admin/transactions/pending" class="btn btn-primary">Yêu Cầu Chờ Duyệt</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Người Dùng</th>
                <th>Sách</th>
                <th>Ngày Mượn</th>
                <th>Ngày Trả</th>
                <th>Trạng Thái</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <!-- Transactions will be displayed here -->
        </tbody>
    </table>
</section>

<?php include '../app/views/layouts/footer.php'; ?>
