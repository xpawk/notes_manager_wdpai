<?php
require_once 'AppController.php';
require_once __DIR__.'/../Repositories/NoteRepository.php';

class NoteController extends AppController
{
    private NoteRepository $repo;

    public function __construct()
    {
        parent::__construct();
        $this->repo = new NoteRepository();
    }

 
    public function notes()
    {
        if (!$this->isLoggedIn()) {
            header("Location: /");
            exit;
        }
        $userId = $_SESSION['user']['id'];

        $notes = $this->repo->allByUser($userId);

        $tagSet = [];
        foreach ($notes as $n) { $tagSet = array_merge($tagSet, $n->getTags()); }
        $tags = array_unique($tagSet);

        $this->render("Notes/index", [
            'notes' => $notes,
            'tags'  => $tags
        ]);
    }

    public function noteNew()
    {
        if (!$this->isLoggedIn()) { header("Location: /"); exit; }
        $this->render("Notes/new");
    }

    public function noteCreate()
    {
        if (!$this->isLoggedIn()) { header("Location: /"); exit; }

        $title   = trim($_POST['title']   ?? '');
        $content = trim($_POST['content'] ?? '');
        $tagsRaw = trim($_POST['tags']    ?? '');   // comma-separated
        $tags    = $tagsRaw ? array_map('trim', explode(',', $tagsRaw)) : [];

        if ($title === '') {
            $this->render("Notes/new", ['error' => 'Title required']);
            return;
        }

        $note = new Note(
            null,
            $_SESSION['user']['id'],
            $title,
            $content,
            $tags
        );
        $this->repo->save($note);

        header("Location: /notes");
        exit;
    }

    public function noteDelete(): void
    {
        if (!$this->isLoggedIn()) {
            header('Location: /');
            exit;
        }

        $noteId = (int)($_GET['id'] ?? 0);

        if ($noteId > 0) {
            $this->repo->deleteById($noteId, $_SESSION['user']['id']);
        }
        header('Location: /notes');
        exit;
    }

    public function noteEdit(): void
    {
        if (!$this->isLoggedIn()) { header('Location: /'); exit; }

        $id     = (int)($_GET['id'] ?? 0);
        $notes  = $this->repo->allByUser($_SESSION['user']['id']);
        $note   = array_filter($notes, fn($n) => $n->getId() === $id);
        $note   = $note ? array_values($note)[0] : null;

        if (!$note) { header('Location: /notes'); exit; }

        $this->render('Notes/edit', ['note' => $note]);
    }

    public function noteUpdate(): void
    {
        if (!$this->isLoggedIn()) { header('Location: /'); exit; }

        $id      = (int)($_POST['id'] ?? 0);
        $title   = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $tagsStr = trim($_POST['tags'] ?? '');
        $tags    = $tagsStr ? array_map('trim', explode(',', $tagsStr)) : [];

        if ($id <= 0 || $title === '') {
            $this->render('Notes/edit', ['error' => 'Title required', 'note'=>null]);
            return;
        }

        $note = new Note(
            $id,
            $_SESSION['user']['id'],
            $title,
            $content,
            $tags
        );
        $this->repo->update($note);

        header('Location: /notes');
        exit;
    }
    public function noteToggleFavorite(): void
    {
        if (!$this->isLoggedIn()) { header('Location: /'); exit; }

        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $this->repo->toggleFavorite($id, $_SESSION['user']['id']);
        }
        header('Location: /notes');
        exit;
    }

}
