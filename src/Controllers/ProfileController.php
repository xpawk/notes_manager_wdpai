<?php
require_once 'AppController.php';
require_once __DIR__.'/../Repositories/UserRepository.php';

class ProfileController extends AppController
{
    private UserRepository $repo;

    public function __construct()
    {
        parent::__construct();
        $this->repo = new UserRepository();
    }

    private function renderSettings(array $extra = []): void
    {
        $profile = $this->repo->getProfile($_SESSION['user']['id']);
        $this->render('Profile/settings', array_merge(['p' => $profile], $extra));
    }

    public function profileSettings(): void
    {
        if (!$this->isLoggedIn()) { header('Location: /'); exit; }
        $this->renderSettings();
    }

    public function profileUpdate(): void
    {
        if (!$this->isLoggedIn()) { header('Location: /'); exit; }

        $id    = $_SESSION['user']['id'];
        $name  = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email']     ?? '');

        if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->renderSettings(['error' => 'Bad data']);
            return;
        }

        $this->repo->updateProfile($id, $name, $email);
        $_SESSION['user']['email'] = $email;   // odśwież header
        $this->renderSettings(['success' => 'Profile updated']);
    }

    public function profilePasswordUpdate(): void
    {
        if (!$this->isLoggedIn()) { header('Location: /'); exit; }

        $id      = $_SESSION['user']['id'];
        $old     = $_POST['password_old']     ?? '';
        $new     = $_POST['password_new']     ?? '';
        $confirm = $_POST['password_confirm'] ?? '';

        if ($new !== $confirm || strlen($new) < 6) {
            $this->renderSettings(['error' => 'Passwords do not match']);
            return;
        }

        $hash = $this->repo->getPasswordHash($id);
        if (!$hash || !password_verify($old, $hash)) {
            $this->renderSettings(['error' => 'Current password incorrect']);
            return;
        }

        $this->repo->updatePassword($id, $new);
        $this->renderSettings(['success' => 'Password updated']);
    }

   
    public function profilePhotoUpload(): void
    {
        if (!$this->isLoggedIn()) { header('Location: /'); exit; }

        if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
            $this->renderSettings(['error' => 'Upload failed']);
            return;
        }

        $id  = $_SESSION['user']['id'];
        $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION) ?: 'png';
        $file = "$id." . strtolower($ext);
        $rel  = "/public/uploads/avatars/$file";
        $abs  = dirname(__DIR__, 2) . $rel;

        if (!is_dir(dirname($abs))) {
            mkdir(dirname($abs), 0775, true);
        }

        if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $abs)) {
            $this->renderSettings(['error' => 'Upload failed']);
            return;
        }

        $this->repo->updateAvatar($id, $rel);
        $_SESSION['user']['avatar_path'] = $rel;  
        $this->renderSettings(['success' => 'Photo updated']);
    }
}
