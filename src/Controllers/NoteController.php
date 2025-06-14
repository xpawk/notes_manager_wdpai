<?php
require_once 'AppController.php';

class NoteController extends AppController
{
    public function notes() {   
        if (!$this->isLoggedIn()) {
            header("Location: /");
            exit;
        }
        
        $notes = [];   
        $tags  = [];  

        $this->render("Notes/index", [
            'notes' => $notes,
            'tags'  => $tags
        ]);
    }
}

