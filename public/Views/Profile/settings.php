<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="/public/favicon.ico" type="image/x-icon">
  <title>Profile Settings</title>
  <link rel="stylesheet" href="/public/styles/main.css">
  <link rel="stylesheet" href="/public/styles/profile/profile.css">
  <link rel="stylesheet" href="/public/styles/partials/header.css">
</head>
<body>

  <header>
    <nav class="top-nav">
      <a href="/notes" class="logo">Profile Settings</a>

      <?php if (isset($_SESSION['user'])): ?>
        <div class="nav-right">
         <a href="/notes" class="btn-primary">Notes</a>

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

 <main class="profile-wrapper">


    <?php if (isset($error)): ?>
      <p class="error-msg"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <section class="profile-card">

      <div class="profile-top">
        <form action="/profilePhotoUpload" method="POST" enctype="multipart/form-data" class="upload-form">
            <?php if (!empty($_SESSION['user']['avatar_path'])): ?>
                <img src="<?= htmlspecialchars($_SESSION['user']['avatar_path']) ?>"
                        alt="avatar"
                        class="avatar">
            <?php else: ?>
                <span class="avatar-pill">
                    <?= htmlspecialchars(strtoupper(substr($_SESSION['user']['email'], 0, 2))) ?>
                </span>
            <?php endif; ?>
           <label for="avatar-input" class="btn-primary">Change Photo</label>
           <input id="avatar-input"
                    type="file"
                    name="avatar"
                    accept="image/*"
                    hidden
                    onchange="this.form.submit()">
        </form>

        <form action="/profileUpdate" method="POST" class="profile-info">
          <label>Full Name
            <input type="text"
                   name="full_name"
                   value="<?= htmlspecialchars($p['full_name'] ?? '') ?>"
                   required>
          </label>

          <label>Email
            <input type="email"
                   name="email"
                   value="<?= htmlspecialchars($p['email']) ?>"
                   required>
          </label>

          <button type="submit" class="btn-primary">Edit Profile</button>
        </form>
      </div>

      <div class="profile-divider"></div>

      <div class="profile-password">
        <h3>Change Password</h3>
        <form action="/profilePasswordUpdate" method="POST">
          <label>Current Password
            <input type="password" name="password_old" required>
          </label>
          <label>New Password
            <input type="password" name="password_new" required>
          </label>
          <label>Confirm Password
            <input type="password" name="password_confirm" required>
          </label>
          <button class="btn-primary" type="submit">Update Password</button>
        </form>
      </div>

    </section>
  </main>

</body>
</html>
