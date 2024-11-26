<?php
require_once '../services/AdminService.php';
class AdminController
{
    private $adminService;

    public function __construct()
    {
        $this->adminService = new AdminService();
    }

    public function adminDashboard()
    {
        if (!isset($_SESSION['roles']) || !in_array('admin', $_SESSION['roles'])) {
            header('Location: index.php');
            exit;
        }

        $users = $this->adminService->getAllUsers();
        $bugs = $this->adminService->getAllBugs();

        require '../views/admin_view.php';
    }

    public function deleteUser()
    {
        if (!isset($_SESSION['roles']) || !in_array('admin', $_SESSION['roles'])) {
            header('Location: index.php');
            exit;
        }

        $userId = $_POST['user_id'] ?? null;

        if ($userId && $this->adminService->deleteUser($userId)) {
            $_SESSION['flash_message'] = "User deleted successfully.";
        } else {
            $_SESSION['flash_message'] = "Failed to delete user.";
        }

        header('Location: index.php?action=admin');
        exit;
    }

    public function deleteBug()
    {
        if (!isset($_SESSION['roles']) || !in_array('admin', $_SESSION['roles'])) {
            header('Location: index.php');
            exit;
        }

        $bugId = $_POST['bug_id'] ?? null;

        if ($bugId && $this->adminService->deleteBug($bugId)) {
            $_SESSION['flash_message'] = "Bug report deleted successfully.";
        } else {
            $_SESSION['flash_message'] = "Failed to delete bug report.";
        }

        header('Location: index.php?action=admin');
        exit;
    }
}
