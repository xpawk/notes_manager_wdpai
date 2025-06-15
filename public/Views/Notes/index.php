<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/public/favicon.ico" type="image/x-icon">
    <title>My Notes</title>
    <link rel="stylesheet" href="/public/styles/main.css">
    <link rel="stylesheet" href="/public/styles/notes/notes.css">
    
    <?php include 'public/Views/partials/header.php'; ?>
</head>
<body>

<main class="notes-wrapper">

    <aside class="tag-filter">
        <h3>Tags</h3>
        <ul>
            <li><button class="tag active" data-tag="all">All</button></li>

            <?php foreach ($tags as $tag): ?>
                <li>
                    <button class="tag" data-tag="<?= htmlspecialchars($tag); ?>">
                        <?= htmlspecialchars($tag); ?>
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>
    </aside>

    <section id="note-list">
        <?php if (!$notes): ?>
            <p>No notes yet – click “New Note” to create one.</p>
        <?php endif; ?>

        <?php foreach ($notes as $note): ?>
            <article
                class="note-card"
                data-note-id="<?= $note->getId(); ?>"
                data-tags="<?= implode(' ', array_map('htmlspecialchars', $note->getTags())); ?>"
                data-fav="<?= $note->isFavorite() ? '1' : '0'; ?>">

                <header>
                    <h2><?= htmlspecialchars($note->getTitle()); ?></h2>

                   <div class="note-modify-buttons">
                        <a href="/noteToggleFavorite?id=<?= $note->getId(); ?>"
                        class="fav-link <?= $note->isFavorite() ? 'fav' : 'unfav'; ?>"
                        title="<?= $note->isFavorite() ? 'Unfavorite' : 'Favorite'; ?>">
                            <?= $note->isFavorite() ? '★' : '☆'; ?>
                        </a>
                        <a href="/noteEdit?id=<?= $note->getId(); ?>"   class="edit-link">Edit</a>
                        <a href="/noteDelete?id=<?= $note->getId(); ?>" class="delete-link">Delete</a>
                    </div>
                </header>

                <p><?= nl2br(htmlspecialchars($note->getContent())); ?></p>

                <footer>
                    <ul class="tag-list">
                        <?php foreach ($note->getTags() as $t): ?>
                            <li><?= htmlspecialchars($t); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <time datetime="<?= $note->getCreatedAt(); ?>">
                        <?= date('Y-m-d', strtotime($note->getCreatedAt())); ?>
                    </time>
                </footer>
            </article>
        <?php endforeach; ?>
    </section>
</main>

<script src="/public/assets/js/notes.js"></script>
</body>
</html>
