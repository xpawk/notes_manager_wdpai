<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="public/styles/main.css">
    <link rel="stylesheet" href="public/styles/auth/auth.css">
    <title>Sign Up – My Notes</title>
</head>
<body id="auth-page">

<div class="auth-wrapper">
    <div class="auth-visual">
        <img src="public/assets/img/notebook-illustration.png" alt="Notebook illustration">
    </div>

    <div class="auth-panel">
        <h1>Create Account</h1>

        <form action="/register" method="POST">

            <div class="result-output">
                <?php if (isset($error)): ?>
                    <span><?= htmlspecialchars($error) ?></span>
                <?php elseif (isset($success)): ?>
                    <span><?= htmlspecialchars($success) ?></span>
                <?php endif; ?>
            </div>

            <div class="auth-input">
                <label for="full_name">Full Name</label>
                <input id="full_name"
                       type="text"
                       name="full_name"
                       required
                       placeholder="Jane Doe">
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

            <div class="auth-input">
                <label for="password_confirm">Confirm Password</label>
                <input id="password_confirm"
                       type="password"
                       name="password_confirm"
                       required
                       placeholder="repeat password">
            </div>

            <button type="submit" class="btn-primary">Sign Up</button>
        </form>

        <p class="auth-subtext">
            Already have an account?
            <a href="/">Login</a>
        </p>
    </div>
</div>

</body>
</html>
