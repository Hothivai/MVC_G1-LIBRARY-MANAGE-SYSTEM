<?php ?>
<?php include '../app/views/layouts/header.php'; ?>

<section class="search-books">
    <h1>Tìm Kiếm Sách</h1>
    <form method="GET" action="/books/search">
        <input type="text" name="q" placeholder="Tìm kiếm sách...">
        <button type="submit" class="btn btn-primary">Tìm Kiếm</button>
    </form>
</section>

<?php include '../app/views/layouts/footer.php'; ?>
