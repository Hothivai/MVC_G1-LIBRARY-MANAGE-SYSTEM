<?php ?>
<?php include '../app/views/layouts/header.php'; ?>

<section class="admin-books">
    <h1>Book Management</h1>
    <a href="/admin/books/create" class="btn btn-primary">Add New Book</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Books will be displayed here -->
        </tbody>
    </table>
</section>

<?php include '../app/views/layouts/footer.php'; ?>
