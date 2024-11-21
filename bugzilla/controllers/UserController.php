<?php

require_once '../models/User.php';
require_once '../services/UserService.php';

class UserController
{
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
            $userService = new UserService();

            try {
                $userService->registerUser($username, $email, $password, $roles);
                header("Location: index.php?action=success"); // Redirect on successful registration
            } catch (Exception $e) {
                echo 'Error: ' . $e->getMessage();
            }
        } else {
            include '../views/register.php';  // Show form if not POST request
        }
    }
}
