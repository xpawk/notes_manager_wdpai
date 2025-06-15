<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile Settings</title>
  <link rel="stylesheet" href="/public/styles/main.css">
  <link rel="stylesheet" href="/public/styles/profile/profile.css">
  <?php include 'public/Views/partials/header.php'; ?>
</head>
<body>

<main class="profile-wrapper">
  <h1>Profile Settings</h1>

  <?php if (isset($error)): ?>
     <p class="error-msg"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>
 
  <section class="profile-card">
      <form action="/profilePhotoUpload" method="POST" enctype="multipart/form-data">
          <img src="<?= $p['avatar_path'] ?? '/public/assets/img/avatar-placeholder.svg'; ?>"
               alt="avatar" class="avatar">
          <input type="file" name="avatar" accept="image/*">
          <button class="btn-primary" type="submit">Change Photo</button>
      </form>

      <form action="/profileUpdate" method="POST" class="profile-info">
          <label>Full Name
              <input type="text" name="full_name"
                     value="<?= htmlspecialchars($p['full_name'] ?? '') ?>" required>
          </label>
          <label>Email
              <input type="email" name="email"
                     value="<?= htmlspecialchars($p['email']) ?>" required>
          </label>
          <button type="submit" class="btn-primary">Edit Profile</button>
      </form>
  </section>

  <section class="profile-password">
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
  </section>
</main>

</body>
</html>
