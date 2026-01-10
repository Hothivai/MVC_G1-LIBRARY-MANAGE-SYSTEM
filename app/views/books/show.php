<?php
/**
 * Book Show View
 * Displays detailed information about a single book
 */
require_once '../app/views/layouts/header.php';
?>

<div class="card">
  <div class="card-header">
    <h2><?= htmlspecialchars($book['title']) ?></h2>
  </div>

  <div class="mb-2">
    <p><strong>ID:</strong> <?= $book['id'] ?></p>
    <p><strong>Author:</strong> <?= htmlspecialchars($book['author']) ?></p>
    <p><strong>ISBN:</strong> <?= htmlspecialchars($book['isbn']) ?></p>
    <p><strong>Publisher:</strong> <?= htmlspecialchars($book['publisher'] ?? 'N/A') ?></p>
    <p><strong>Publication Year:</strong> <?= htmlspecialchars($book['publication_year'] ?? 'N/A') ?></p>
    <p><strong>Category:</strong> <?= htmlspecialchars($book['category'] ?? 'N/A') ?></p>

    <?php if (!empty($book['description'])): ?>
      <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($book['description'])) ?></p>
    <?php endif; ?>

    <p><strong>Added:</strong> <?= date('F d, Y', strtotime($book['created_at'])) ?></p>
    <?php if ($book['updated_at'] !== $book['created_at']): ?>
      <p><strong>Last Updated:</strong> <?= date('F d, Y', strtotime($book['updated_at'])) ?></p>
    <?php endif; ?>
  </div>

  <!-- Actions -->
  <div class="mt-2 d-flex gap-1">
    <a href="<?= URL_ROOT ?>/book" class="btn btn-secondary">Back to Books</a>
    <a href="<?= URL_ROOT ?>/book/edit/<?= $book['id'] ?>" class="btn btn-primary">Edit Book</a>
    <a href="<?= URL_ROOT ?>/book/delete/<?= $book['id'] ?>" class="btn btn-danger"
      onclick="return confirm('Are you sure you want to delete this book?')">Delete Book</a>
  </div>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>