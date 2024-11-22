<?php

session_start();
include '../views/navbar.php';
require_once '../controllers/IndexController.php';
require_once '../controllers/UserController.php';
require_once '../controllers/BugController.php';

abstract class BaseController
{
    protected $userController;
    protected $indexController;
    protected $bugController;

    public function __construct()
    {
        $this->userController = new UserController();
        $this->indexController = new IndexController();
        $this->bugController = new BugController();
    }
}

// FrontController for routing
class FrontController extends BaseController
{
    public function route($action)
    {
        $this->isSessionActive();
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
            case 'reportBug':
                $this->bugController->submitBugReport();
                break;
            case 'viewBug':
                $this->bugController->viewBug();
                break;
            case 'add_comment':
                $this->bugController->addComment();
                break;
            case 'add_patch':
                $controller = new BugController();
                $controller->addPatch();
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
        echo $_REQUEST['action'] . "404 - Action not found.";
    }
}

// Fetch the requested action or default to 'index'
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'index';

// Instantiate the front controller and route the request
$frontController = new FrontController();
$frontController->route($action);

