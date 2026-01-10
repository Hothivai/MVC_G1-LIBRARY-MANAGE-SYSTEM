<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'MVC Example' ?> - <?= APP_NAME ?></title>
  <link rel="stylesheet" href="<?= URL_ROOT ?>/css/style.css">
</head>

<body>
  <header>
    <div class="container">
      <h1><?= APP_NAME ?></h1>
      <nav>
        <ul>
          <li><a href="<?= URL_ROOT ?>/book">All Books</a></li>
          <li><a href="<?= URL_ROOT ?>/book/create">Add Book</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main>
    <div class="container">
      <?php
      // Display flash messages
      if (isset($_SESSION['success'])):
        ?>
        <div class="alert alert-success">
          <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
      <?php endif; ?>

      <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
          <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
      <?php endif; ?>

      <?php if (isset($_SESSION['errors']) && is_array($_SESSION['errors'])): ?>
        <div class="alert alert-error">
          <ul>
            <?php foreach ($_SESSION['errors'] as $error): ?>
              <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php unset($_SESSION['errors']); ?>
      <?php endif; ?>