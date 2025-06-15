<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/public/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="public/styles/main.css">
    <link rel="stylesheet" href="public/styles/auth/auth.css">

    <title>Sign In – My Notes</title>
</head>
<body id="auth-page">

    <div class="auth-wrapper">

        <div class="auth-visual">
            <img src="public/assets/img/notebook-illustration.png" alt="Notebook illustration"">
        </div>

        <div class="auth-panel">
            <h1>Welcome Back</h1>

            <form action="/login" method="POST">

                <div class="result-output">
                    <?php if (isset($error)): ?>
                        <span><?= htmlspecialchars($error) ?></span>
                    <?php elseif (isset($success)): ?>
                        <span><?= htmlspecialchars($success) ?></span>
                    <?php endif; ?>
                </div>

                <div class="auth-input">
                    <label for="email">Email</label>
                    <input id="email"
                           type="email"
                           name="email"
                           required
                           placeholder="you@example.com">
                </div>

                <div class="auth-input">
                    <label for="password">Password</label>
                    <input id="password"
                           type="password"
                           name="password"
                           required
                           placeholder="••••••••">
                </div>

                <button type="submit" class="btn-primary">Login</button>
            </form>

            <p class="auth-subtext">
                Don't have an account?
                <a href="/register">Sign&nbsp;up</a>
            </p>
        </div>
    </div>

</body>
</html>
