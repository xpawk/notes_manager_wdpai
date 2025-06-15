<link rel="stylesheet" href="/public/styles/partials/header.css">

<nav class="top-nav">
    <a href="/notes" class="logo">My Notes</a>

    <?php if (isset($_SESSION['user'])): ?>
        <div class="nav-right">
            <a href="/noteNew" class="btn-primary">+ New Note</a>
            
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

            <a href="/logout" class="logout-btn" title="Log out">Log&nbsp;out</a>
        </div>
    <?php else: ?>
        <a href="/" class="sign-link">Sign&nbsp;in</a>
    <?php endif; ?>
</nav>
