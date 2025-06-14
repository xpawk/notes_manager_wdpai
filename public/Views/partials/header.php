<link href="public/styles/partials/header.css" rel="stylesheet">

<nav class="top-nav">
    <a href="/" class="logo">Payroll App</a>

    <?php if (isset($_SESSION['user'])): ?>
        <span class="username">
            <?= htmlspecialchars($_SESSION['user']['email']) ?>
        </span>
        <a href="/logout" class="logout-btn">Log out</a>
    <?php else: ?>
        <a href="/index">Sign in</a>
    <?php endif; ?>
</nav>
