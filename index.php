<?php
session_start();

require 'Routing.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$path = trim($path, '/');

if ($path === '') {
    $path = 'index';
}

/* Pages */
Routing::get('notes',      'NoteController');   
Routing::get('noteNew',   'NoteController');   
Routing::get('notes',   'NoteController');
Routing::get('index',      'DefaultController');
Routing::get('register',   'DefaultController');
Routing::get ('noteEdit',   'NoteController');
Routing::get ('profileSettings', 'ProfileController');

/* API */
Routing::post('profileUpdate',  'ProfileController'); 
Routing::post('profilePasswordUpdate',  'ProfileController');  
Routing::post('profilePhotoUpload',  'ProfileController');  
Routing::post('noteUpdate', 'NoteController');
Routing::get('noteDelete', 'NoteController');
Routing::post('noteCreate','NoteController');
Routing::post('login',     'AuthController');
Routing::post('register',  'AuthController');
Routing::get('logout',    'AuthController');


Routing::run($path);
