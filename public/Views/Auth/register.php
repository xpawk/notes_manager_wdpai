<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="public/styles/main.css" rel="stylesheet">
    <link href="public/styles/auth/auth.css" rel="stylesheet">
    <link href="public/styles/utility/fonts.css" rel="stylesheet">
    <link href="public/styles/utility/UI.css" rel="stylesheet">

    <title>Sign Up</title>
</head>

<body id="auth-page" class="flex-row-center-center">
    <div class="flex-column-center-center auth-panel">
        <h1 class="flex-row-center-center">SIGN UP</h1>
        <form class="flex-column-center-center" action="register" method="POST">
            <div class="result-output">
                <?php if (isset($error)) : ?>
                    <span><?php echo htmlspecialchars($error); ?></span>
                <?php endif; ?>
                <?php if (isset($success)) : ?>
                    <span><?php echo htmlspecialchars($success); ?></span>
                <?php endif; ?>
            </div>
            <div class="auth-input">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" class="input" required placeholder="Insert your email address">
            </div>
            <div class="auth-input">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" class="input" required placeholder="Insert your password">
            </div>
            <button type="submit" class="flex-row-center-center">Sign Up</button>
        </form>
        <p class="auth-subtext">Already have an account? <a href="/">Sign In</a></p>
    </div>

</body>

</html>