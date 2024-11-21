<?php

session_start();
include '../views/navbar.php';
require_once '../controllers/IndexController.php';
require_once '../controllers/UserController.php';

// BaseController class to manage common initialization
abstract class BaseController
{
    protected $userController;
    protected $indexController;

    public function __construct()
    {
        $this->userController = new UserController();
        $this->indexController = new IndexController();
    }
}

// FrontController for routing
class FrontController extends BaseController
{
    public function route($action)
    {
        switch ($action) {
            case 'index':
                $this->indexController->index();
                break;

            case 'register':
                $this->userController->register();
                break;

            case 'login':
                $this->userController->login();
                break;
            case 'logout':
                $this->userController->logout();
                break;
            default:
                $this->show404();
                break;
        }
    }

    private function isSessionActive()
    {
        var_dump($_SESSION);
        return isset($_SESSION['user']);
    }

    private function show404()
    {
        echo "404 - Action not found.";
    }
}

// Fetch the requested action or default to 'index'
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'index';

// Instantiate the front controller and route the request
$frontController = new FrontController();
$frontController->route($action);

