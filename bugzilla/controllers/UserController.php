<?php

require_once '../models/User.php';
require_once '../services/UserService.php';
require_once '../services/BugService.php';

class UserController
{
    private $userService;
    private $bugService;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->bugService = new BugService();
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Receive POST data
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $roles = [];

            //TODO: Validation checks here-->

            foreach ($_POST['roles'] as $roleId) {
                $roles[] = new Role($roleId, null);
            }

            try {
                $this->userService->registerUser($username, $email, $password, $roles);
                header("Location: index.php?action=login"); // Redirect on successful registration
            } catch (Exception $e) {
                echo 'Error: ' . $e->getMessage();
            }
        } else {
            include '../views/register.php';  // Show form if not POST request
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $username = $_POST['username'];
                $password = $_POST['password'];

                // Authenticate user
                $user = $this->userService->loginUser($username, $password);
                $roles = $this->userService->getRolesByUserId($user['u_id']);
                // Start a session and store user data
                session_start();
                $_SESSION['user'] = $user;
                $_SESSION['roles'] = $roles;

                $_SESSION['flash_message'] = "Login successful! Hi, " . htmlspecialchars($user['username']) . "!";

                // Redirect to the index page
                header("Location: index.php?action=index");
                exit;
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            include '../views/login.php';
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: index.php?action=index');
        exit();
    }
    public function profile()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit();
        }

        $username = $_SESSION['user']['username'];
        $userId = $_SESSION['user']['u_id'];

        try {
            // Fetch user details
            $user = $this->userService->getUserByUsername($username);

            // Fetch roles for the user
            $roles = $this->userService->getRolesByUserId($userId);

            // Initialize statistics
            $patchesCount = 0;
            $acceptedPatchesCount = 0;

            // Check if user has 'developer' role and count patches
            if (in_array('developer', $roles)) {
                $patchesCount = $this->userService->countPatchesByUser($username);
            }

            // Check if user has 'tester' role and count accepted patches
            if (in_array('tester', $roles)) {
                $acceptedPatchesCount = $this->userService->countAcceptedPatchesByUser($userId);
            }

            // Fetch bug reports submitted by the user
            $bugs = $this->userService->getBugsByUsername($username);

            // Include the profile view
            include '../views/profile.php';
        } catch (Exception $e) {
            $_SESSION['flash_message'] = "Error loading profile: " . $e->getMessage();
            header("Location: index.php");
            exit();
        }
    }

}
