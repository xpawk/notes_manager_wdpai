<?php

require_once 'AppController.php';

class DefaultController extends AppController
{

    public function index()
    {
        if ($this->isLoggedIn()) {
            header("Location: /notes");
            exit;
        }
        $this->render("Auth/login");
    }
    public function register()
    {
        if ($this->isLoggedIn()) {
            header("Location: /notes");
            exit;
        }

        $this->render("Auth/register");
    }
}
