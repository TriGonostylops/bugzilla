<?php

require_once '../models/User.php';
require_once '../services/UserService.php';

class UserController
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
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
                header("Location: index.php?action=success"); // Redirect on successful registration
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
}
