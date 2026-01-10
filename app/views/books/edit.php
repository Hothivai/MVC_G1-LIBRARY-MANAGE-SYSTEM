<?php
/**
 * Book Edit View
 * Displays a form to edit an existing book
 */
require_once '../app/views/layouts/header.php';
$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);
?>

<div class="card">
  <div class="card-header">
    <h2>Edit Book</h2>
  </div>

  <form method="POST" action="<?= URL_ROOT ?>/book/update/<?= $book['id'] ?>" data-validate>
    <div class="form-group">
      <label for="title">Title *</label>
      <input type="text" id="title" name="title" class="form-control"
        value="<?= htmlspecialchars($old['title'] ?? $book['title']) ?>" required>
    </div>

    <div class="form-group">
      <label for="author">Author *</label>
      <input type="text" id="author" name="author" class="form-control"
        value="<?= htmlspecialchars($old['author'] ?? $book['author']) ?>" required>
    </div>

    <div class="form-group">
      <label for="isbn">ISBN *</label>
      <input type="text" id="isbn" name="isbn" class="form-control"
        value="<?= htmlspecialchars($old['isbn'] ?? $book['isbn']) ?>" required>
    </div>

    <div class="form-group">
      <label for="publisher">Publisher</label>
      <input type="text" id="publisher" name="publisher" class="form-control"
        value="<?= htmlspecialchars($old['publisher'] ?? $book['publisher']) ?>">
    </div>

    <div class="form-group">
      <label for="publication_year">Publication Year</label>
      <input type="number" id="publication_year" name="publication_year" class="form-control" min="1000"
        max="<?= date('Y') ?>" value="<?= htmlspecialchars($old['publication_year'] ?? $book['publication_year']) ?>">
    </div>

    <div class="form-group">
      <label for="category">Category</label>
      <input type="text" id="category" name="category" class="form-control"
        value="<?= htmlspecialchars($old['category'] ?? $book['category']) ?>">
    </div>

    <div class="form-group">
      <label for="description">Description</label>
      <textarea id="description" name="description"
        class="form-control"><?= htmlspecialchars($old['description'] ?? $book['description']) ?></textarea>
    </div>

    <div class="d-flex gap-1">
      <button type="submit" class="btn btn-primary">Update Book</button>
      <a href="<?= URL_ROOT ?>/book/show/<?= $book['id'] ?>" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>