<?php ?>
<?php include '../app/views/layouts/header.php'; ?>

<section class="admin-categories">
    <h1>Category Management</h1>
    <a href="/admin/categories/create" class="btn btn-primary">Add Category</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Categories will be displayed here -->
        </tbody>
    </table>
</section>

<?php include '../app/views/layouts/footer.php'; ?>
