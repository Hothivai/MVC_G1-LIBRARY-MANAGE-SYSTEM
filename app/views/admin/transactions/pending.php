<?php ?>
<?php include '../app/views/layouts/header.php'; ?>

<section class="admin-pending-transactions">
    <h1>Yêu Cầu Mượn Sách Chờ Duyệt</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Người Dùng</th>
                <th>Sách</th>
                <th>Ngày Yêu Cầu</th>
                <th>Ngày Trả Dự Kiến</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <!-- Pending transactions will be displayed here -->
        </tbody>
    </table>
</section>

<?php include '../app/views/layouts/footer.php'; ?>
