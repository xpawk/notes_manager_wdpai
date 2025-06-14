<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Notes</title>
    <link href="/public/styles/main.css" rel="stylesheet">
    <?php include 'public/Views/partials/header.php'; ?>
</head>
<body>


    <main class="notes-wrapper">
        <aside class="tag-filter">
            <h3>Tags</h3>
            <ul>
                <li><button data-tag="all" class="tag active">All</button></li>
                <?php foreach ($tags as $tag): ?>
                    <li><button data-tag="<?= $tag ?>" class="tag"><?= htmlspecialchars($tag) ?></button></li>
                <?php endforeach; ?>
            </ul>
        </aside>

        <section id="note-list">
            <?php if (!$notes): ?>
                <p>No notes yet – click “New Note” to create one.</p>
            <?php endif; ?>

            <?php foreach ($notes as $note): ?>
                <article class="note-card" data-note-id="<?= $note->getId(); ?>">
                    <header>
                        <h2><?= htmlspecialchars($note->getTitle()); ?></h2>
                        <a href="/notes/<?= $note->getId(); ?>/delete" class="delete-link">Delete</a>
                    </header>

                    <p><?= nl2br(htmlspecialchars($note->getContent())); ?></p>

                    <footer>
                        <time datetime="<?= $note->getCreatedAt(); ?>">
                            <?= date('Y-m-d', strtotime($note->getCreatedAt())); ?>
                        </time>

                        <ul class="tag-list">
                            <?php foreach ($note->getTags() as $t): ?>
                                <li><?= htmlspecialchars($t); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </footer>
                </article>
            <?php endforeach; ?>
        </section>
    </main>

    <script src="/public/assets/js/notes.js"></script>
</body>
</html>
