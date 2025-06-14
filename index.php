<?php
session_start();

require 'Routing.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$path = trim($path, '/');

if ($path === '') {
    $path = 'index';
}

/* Pages */
Routing::get('index',      'DefaultController');
Routing::get('register',   'DefaultController');

/* API */
Routing::post('login',     'AuthController');
Routing::post('register',  'AuthController');
Routing::get('logout',    'AuthController');


Routing::run($path);
