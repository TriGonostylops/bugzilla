<?php

/**
 * UserController Class
 *
 * This class handles user-related operations.
 */
class UserController
{
    /**
     * @var UserService $userService The instance of UserService used for user-related operations.
     */
    private $userService;

    /**
     * Constructor for UserController.
     *
     * @param UserService $userService The UserService dependency injected into the controller.
     */
    public function __construct($userService)
    {
        $this->userService = $userService;
    }

    /**
     * List all users and render the userList view.
     *
     * @throws Exception If there is an error fetching users.
     */
    public function listUsers()
    {
        try {
            $users = $this->userService->getAllUsers(); // Fetch users from UserService
            require '../views/userList.php'; // Include the view file
        } catch (Exception $e) {
            throw new Exception('Error fetching users: ' . $e->getMessage());
        }
    }
}