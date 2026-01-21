<?php ?>
<?php include '../app/views/layouts/header.php'; ?>

<!-- <section class="profile">
    <h1>Thông Tin Cá Nhân</h1>
    <div class="profile-info">
        User profile information will be displayed here
    </div>
    <a href="/profile/edit" class="btn btn-primary">Chỉnh Sửa Thông Tin</a>
</section> -->

<h2>User Profile</h2>

<p><strong>Name:</strong> <?= $user['full_name'] ?></p>
<p><strong>Email:</strong> <?= $user['email'] ?></p>
<p><strong>Phone:</strong> <?= $user['phone'] ?></p>
<p><strong>Address:</strong> <?= $user['address'] ?></p>

<a href="/public/profile/edit">Edit Profile</a>

<?php include '../app/views/layouts/footer.php'; ?>
