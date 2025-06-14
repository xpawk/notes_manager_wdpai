<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Note</title>
  <link rel="stylesheet" href="/public/styles/main.css">
  <link rel="stylesheet" href="/public/styles/notes/form.css">
  <?php include 'public/Views/partials/header.php'; ?>
</head>
<body>

<main class="note-form-wrapper">
  <?php if (isset($error)): ?>
    <p class="error-msg"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <form action="/noteUpdate" method="POST" class="note-form">
      <input type="hidden" name="id" value="<?= $note->getId(); ?>">

      <label>Title
          <input type="text" name="title"
                 value="<?= htmlspecialchars($note->getTitle()); ?>" required>
      </label>

      <label>Content
          <textarea name="content" rows="8"><?= htmlspecialchars($note->getContent()); ?></textarea>
      </label>

      <label>Tags <span class="hint">(comma-separated)</span>
          <input type="text" name="tags"
                 value="<?= htmlspecialchars(implode(', ', $note->getTags())); ?>">
      </label>

      <button type="submit" class="btn-primary">Update</button>
  </form>
</main>

</body>
</html>
