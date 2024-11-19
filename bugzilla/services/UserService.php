<?php

require_once '../config/database.php';
require_once '../models/User.php';

/**
 * UserService Class
 *
 * This class interacts with the database to perform operations related to users.
 */
class UserService
{
    /**
     * @var PDO $db The PDO database connection instance.
     */
    private $db;

    /**
     * Constructor to initialize UserService and establish a database connection.
     */
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Fetches all users from the database.
     *
     * @return array An array of User objects representing fetched users.
     * @throws PDOException If there is a PDO-related database error.
     */
    public function getAllUsers()
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users");
            $stmt->execute();

            $users = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $user = new User($row['id'], $row['name']);
                $users[] = $user;
            }

            return $users;

        } catch (PDOException $e) {
            // Re-throw the exception to handle it at a higher level
            throw new PDOException('Error fetching users: ' . $e->getMessage());
        }
    }
}