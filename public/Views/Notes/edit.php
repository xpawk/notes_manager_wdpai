<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="/public/favicon.ico" type="image/x-icon">
  <title>Edit Note</title>
  <link rel="stylesheet" href="/public/styles/main.css">
  <link rel="stylesheet" href="/public/styles/notes/form.css">
  <link rel="stylesheet" href="/public/styles/partials/header.css">
</head>
<body>

  <header>
    <nav class="top-nav">
      <a href="/notes" class="logo">Edit Note</a>

      <?php if (isset($_SESSION['user'])): ?>
        <div class="nav-right">
          <button
            class="btn-primary"
            type="submit"
            form="noteForm">
            Update Note
          </button>

        <a href="/profileSettings" class="profile-link">
            <?php if (!empty($_SESSION['user']['avatar_path'])): ?>
                <img src="<?= htmlspecialchars($_SESSION['user']['avatar_path']) ?>"
                        alt="avatar"
                        class="avatar-pill avatar-img">
            <?php else: ?>
                <span class="avatar-pill">
                    <?= htmlspecialchars(strtoupper(substr($_SESSION['user']['email'], 0, 2))) ?>
                </span>
            <?php endif; ?>
        </a>
          <a href="/logout" class="logout-btn">Log out</a>
        </div>
      <?php else: ?>
        <a href="/" class="sign-link">Sign in</a>
      <?php endif; ?>
    </nav>
  </header>


<main class="note-form-wrapper">
  <?php if (isset($error)): ?>
    <p class="error-msg"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <form action="/noteUpdate" method="POST"  id="noteForm" class="note-form">
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

  </form>
</main>

</body>
</html>
