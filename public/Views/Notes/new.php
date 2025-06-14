<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Note</title>
    <link rel="stylesheet" href="/public/styles/main.css">
    <link rel="stylesheet" href="/public/styles/notes/form.css">
    <?php include 'public/Views/partials/header.php'; ?>
</head>
<body>

<main class="note-form-wrapper">

    <?php if (isset($error)): ?>
        <p class="error-msg"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="/noteCreate" method="POST" class="note-form">
        <label>
            Title
            <input type="text" name="title" required>
        </label>

        <label>
            Content
            <textarea name="content" rows="8"></textarea>
        </label>

        <label>
            Tags <span class="hint">(comma-separated)</span>
            <input type="text" name="tags" placeholder="work, personal">
        </label>

        <button type="submit" class="btn-primary">Save Note</button>
    </form>
</main>

</body>
</html>
