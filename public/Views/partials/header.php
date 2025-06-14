<link href="/public/styles/partials/header.css" rel="stylesheet">

<nav class="top-nav">
    <a href="/notes" class="logo">My Notes</a>

    <?php if (isset($_SESSION['user'])): ?>
        <div class="nav-right">
            <a href="/noteNew" class="btn-primary">+ New Note</a>
            
            <span class="avatar-pill">
                <?php
                    $initials = strtoupper(substr($_SESSION['user']['email'], 0, 2));
                    echo htmlspecialchars($initials);
                ?>
            </span>

            <a href="/logout" class="logout-btn" title="Log out">Log&nbsp;out</a>
        </div>
    <?php else: ?>
        <a href="/" class="sign-link">Sign&nbsp;in</a>
    <?php endif; ?>
</nav>
