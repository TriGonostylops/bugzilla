<?php

session_start();
include '../views/navbar.php';
require_once '../controllers/IndexController.php';
require_once '../controllers/UserController.php';
require_once '../controllers/BugController.php';
require_once '../controllers/AdminController.php';

abstract class BaseController
{
    protected $adminController;
    protected $userController;
    protected $indexController;
    protected $bugController;

    public function __construct()
    {
        $this->adminController = new AdminController();
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
        if (isset($_GET['filter_date']) && !isset($_GET['action'])) {
            header('Location: index.php?action=statistics&filter_date=' . urlencode($_GET['filter_date']));
            exit;
        }

        switch ($action) {
            case 'index':
                $this->indexController->index();
                break;
            case 'search':
                $this->indexController->search();
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
            case 'profile':
                $this->userController->profile();
                break;
            case 'statistics':
                $this->indexController->statistics();
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
                $this->bugController->addPatch();
                break;
            case 'approve_patch':
                $this->bugController->approvePatch();
                break;
            default:
                $this->show404();
                break;
            case 'admin':
                $this->adminController->adminDashboard();
                break;
            case 'delete_user':
                $this->adminController->deleteUser();
                break;
            case 'delete_bug':
                $this->adminController->deleteBug();
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

