<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/navbar.php'; ?>

<div class="container" style="padding: 2rem 0;">
  <h1 style="margin-bottom: 2rem;">Browse Books</h1>

  <!-- Filters -->
  <div class="filters-section">
    <form method="GET" action="/book" class="filters-container">
      <div class="filter-group">
        <label for="search">Search</label>
        <input type="text" id="search" name="search" placeholder="Title, Author, ISBN..."
          value="<?= htmlspecialchars($searchQuery ?? '') ?>" style="min-width: 300px;">
      </div>

      <div class="filter-group">
        <label for="category">Category</label>
        <select id="category" name="category">
          <option value="">All Categories</option>
          <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['category_id'] ?>" <?= ($selectedCategory == $cat['category_id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($cat['category_name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="filter-group" style="align-self: flex-end;">
        <button type="submit" class="btn btn-primary">Filter</button>
      </div>

      <?php if ($searchQuery || $selectedCategory): ?>
        <div class="filter-group" style="align-self: flex-end;">
          <a href="/book" class="btn btn-outline">Clear Filters</a>
        </div>
      <?php endif; ?>
    </form>
  </div>

  <!-- Results Info -->
  <div style="margin-bottom: 1.5rem;">
    <p style="color: var(--text-light);">
      Showing <?= count($books) ?> of <?= $totalBooks ?> books
      <?php if ($searchQuery): ?>
        matching "<?= htmlspecialchars($searchQuery) ?>"
      <?php endif; ?>
    </p>
  </div>

  <!-- Books Grid -->
  <?php if (!empty($books)): ?>
    <div class="books-grid">
      <?php foreach ($books as $book): ?>
        <a href="/book/show/<?= $book['book_id'] ?>" class="book-card">
          <div class="book-cover">
            <?php if (!empty($book['image_url'])): ?>
              <img src="/<?= htmlspecialchars($book['image_url']) ?>"
                alt="<?= htmlspecialchars($book['title']) ?>">
            <?php else: ?>
              <div class="book-placeholder">
                <span><?= strtoupper(substr($book['title'], 0, 1)) ?></span>
              </div>
            <?php endif; ?>
          </div>
          <div class="book-info">
            <h3 class="book-title"><?= htmlspecialchars($book['title']) ?></h3>
            <p class="book-author"><?= htmlspecialchars($book['author']) ?></p>
            <p class="book-availability">
              <?= $book['available_copies'] ?> available
            </p>
          </div>
        </a>
      <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
      <div class="pagination">
        <?php if ($currentPage > 1): ?>
          <a
            href="/book?page=<?= $currentPage - 1 ?><?= $searchQuery ? '&search=' . urlencode($searchQuery) : '' ?><?= $selectedCategory ? '&category=' . $selectedCategory : '' ?>">
            Previous
          </a>
        <?php else: ?>
          <span class="disabled">Previous</span>
        <?php endif; ?>

        <?php
        $startPage = max(1, $currentPage - 2);
        $endPage = min($totalPages, $currentPage + 2);

        for ($i = $startPage; $i <= $endPage; $i++):
          ?>
          <?php if ($i == $currentPage): ?>
            <span class="active"><?= $i ?></span>
          <?php else: ?>
            <a
              href="/book?page=<?= $i ?><?= $searchQuery ? '&search=' . urlencode($searchQuery) : '' ?><?= $selectedCategory ? '&category=' . $selectedCategory : '' ?>">
              <?= $i ?>
            </a>
          <?php endif; ?>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
          <a
            href="/book?page=<?= $currentPage + 1 ?><?= $searchQuery ? '&search=' . urlencode($searchQuery) : '' ?><?= $selectedCategory ? '&category=' . $selectedCategory : '' ?>">
            Next
          </a>
        <?php else: ?>
          <span class="disabled">Next</span>
        <?php endif; ?>
      </div>
    <?php endif; ?>

  <?php else: ?>
    <div class="empty-state">
      <svg class="empty-state-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 19.5A2.5 2.5 0 0 0 6.5 22H20M4 19.5V4.5A2.5 2.5 0 0 1 6.5 2H17l5 5v10"
          stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
      <h3>No books found</h3>
      <p>Try adjusting your search or filters</p>
      <a href="<=/book" class="btn btn-primary">Clear Filters</a>
    </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>