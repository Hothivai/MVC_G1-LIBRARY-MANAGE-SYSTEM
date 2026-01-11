<?php ?>
<?php include '../app/views/layouts/header.php'; ?>

<section class="borrow-request">
    <h1>Yêu Cầu Mượn Sách</h1>
    <form method="POST" action="/borrow">
        <div class="form-group">
            <label for="book_id">Chọn Sách:</label>
            <select id="book_id" name="book_id" required>
                <!-- Books will be listed here -->
            </select>
        </div>
        <div class="form-group">
            <label for="due_date">Ngày Trả Dự Kiến:</label>
            <input type="date" id="due_date" name="due_date" required>
        </div>
        <button type="submit" class="btn btn-primary">Gửi Yêu Cầu</button>
    </form>
</section>

<?php include '../app/views/layouts/footer.php'; ?>
