<?php include '../app/views/layouts/header.php'; ?>

<!-- <section class="profile-edit">
    <h1>Chỉnh Sửa Thông Tin Cá Nhân</h1>
    <form method="POST" action="/profile">
        <div class="form-group">
            <label for="name">Tên:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="phone">Điện Thoại:</label>
            <input type="tel" id="phone" name="phone">
        </div>
        <div class="form-group">
            <label for="address">Địa Chỉ:</label>
            <input type="text" id="address" name="address">
        </div>
        <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
    </form>
</section> -->
<h2>Edit Profile</h2>

<form method="POST" action="/public/profile/edit">
    <div>
        <label>Full Name</label>
        <input type="text" name="full_name" value="<?= $user['full_name'] ?>">
    </div>

    <div>
        <label>Email</label>
        <input type="email" name="email" value="<?= $user['email'] ?>">
    </div>
    
    <div>
        <label>Phone</label>
        <input type="text" name="phone" value="<?= $user['phone'] ?>">
    </div>

    <div>
        <label>Address</label>
        <input type="text" name="address" value="<?= $user['address'] ?>">
    </div>

    <button type="submit">Save</button>
    <a href="/public/profile">Cancel</a>
</form>

<?php include '../app/views/layouts/footer.php'; ?>
