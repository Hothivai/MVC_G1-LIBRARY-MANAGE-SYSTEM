<?php
/**
 * Books Index View
 * This view displays a list of all books
 * Demonstrates how a View receives and displays data from Controller
 */
require_once '../app/views/layouts/header.php';
?>

<div class="card">
  <div class="card-header d-flex justify-between align-center">
    <h2>All Books</h2>
    <a href="<?= URL_ROOT ?>/book/create" class="btn btn-primary">Add New Book</a>
  </div>

  <!-- Books Table -->
  <?php if (!empty($books)): ?>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Author</th>
          <th>ISBN</th>
          <th>Category</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($books as $book): ?>
          <tr>
            <td><?= $book['id'] ?></td>
            <td><?= htmlspecialchars($book['title']) ?></td>
            <td><?= htmlspecialchars($book['author']) ?></td>
            <td><?= htmlspecialchars($book['isbn']) ?></td>
            <td><?= htmlspecialchars($book['category'] ?? '-') ?></td>
            <td>
              <a href="<?= URL_ROOT ?>/book/show/<?= $book['id'] ?>" class="btn btn-sm btn-secondary">View</a>
              <a href="<?= URL_ROOT ?>/book/edit/<?= $book['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
              <a href="<?= URL_ROOT ?>/book/delete/<?= $book['id'] ?>" class="btn btn-sm btn-danger btn-delete"
                onclick="return confirm('Are you sure you want to delete this book?')">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p class="text-center">No books available in the library.</p>
    <p class="text-center">
      <a href="<?= URL_ROOT ?>/book/create" class="btn btn-primary">Add your first book</a>
    </p>
  <?php endif; ?>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>