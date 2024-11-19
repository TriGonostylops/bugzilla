<?php

/**
 * Entry Point for MVC Application
 *
 * This file serves as the entry point for the MVC application. It routes requests
 * to the appropriate controllers based on the 'action' parameter in the URL.
 *
 * PHP version 8.2.12
 */

// Include necessary files and services
require_once '../controllers/IndexController.php';
require_once '../controllers/UserController.php';
require_once '../controllers/AdvertisementController.php';
require_once '../services/UserService.php';
require_once '../services/AdvertisementService.php';

/**
 * Instantiate service classes
 */
$userService = new UserService();
$advertisementService = new AdvertisementService();

/**
 * Instantiate controller classes with injected dependencies
 */
$indexController = new IndexController();
$userController = new UserController($userService);
$advertisementController = new AdvertisementController($advertisementService);

/**
 * Handle actions based on request parameters
 *
 * @var string $action The action parameter from the URL. If the parameter is faulty it redirects the user to the entry point.
 */
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

try {
    switch ($action) {
        case 'index':
            // Handle the index action
            $indexController->index();
            break;
        case 'userList':
            // Handle the user list action
            $userController->listUsers();
            break;
        case 'advertisementList':
            // Handle the advertisement list action
            $advertisementController->listAdvertisements();
            break;
    }
} catch (Exception $e) {
    // Handle any exceptions
    echo 'Exception caught: ' . $e->getMessage();
}