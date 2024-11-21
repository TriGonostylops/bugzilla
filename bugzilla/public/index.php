<?php

// Autoloading controllers (make sure to include all necessary files)
require_once '../controllers/IndexController.php';
require_once '../controllers/UserController.php';

// Get the action from the query string (or default to 'index')
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'index';

// Instantiate the appropriate controller based on the action
switch ($action) {
    case 'index':
        // Instantiate the Index controller and call the index method
        $controller = new IndexController();
        $controller->index();
        break;

    case 'register':
        // Instantiate the User controller and call the register method
        $controller = new UserController();
        $controller->register();
        break;

    case 'login':
        // Instantiate the User controller and call the login method
        $controller = new UserController();
        $controller->login();
        break;

    default:
        echo "404 - Action not found.";
        break;
}