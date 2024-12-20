<?php

require_once '../config/database.php';
require_once '../models/User.php';
require_once '../models/Role.php';

class UserService
{
    private $db;

    public function __construct()
    {
        try {
            $this->db = Database::getInstance()->getConnection();
        } catch (Exception $e) {
            throw new Exception("Database connection error.");
        }
    }

    public function registerUser($username, $email, $password, $roles)
    {
        if (empty($username) || empty($email) || empty($password)) {
            throw new Exception("All fields are required.");
        }

        // Check if email already exists
        $stmt = $this->db->prepare("SELECT u_id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            throw new Exception("Email is already registered.");
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert user into database
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword]);

        // Get the inserted user ID
        $userId = $this->db->lastInsertId();

        // Assign roles
        $this->assignRolesToUser($userId, $roles);

        return true;
    }

    public function loginUser($username, $password)
    {
        try {
            // Check if user exists by username
            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                throw new Exception("User not found.");
            }

            // Verify password
            if (!password_verify($password, $user['password'])) {
                throw new Exception("Invalid credentials.");
            }

            // Return user data (excluding password for security)
            return [
                'u_id' => $user['u_id'],
                'username' => $user['username'],
                'email' => $user['email']
            ];
        } catch (Exception $e) {
            throw new Exception("Login failed: " . $e->getMessage());
        }
    }

    private function assignRolesToUser($userId, $roles)
    {
        $stmt = $this->db->prepare("INSERT INTO role_user (u_id, r_id) VALUES (?, ?)");

        foreach ($roles as $role) {
            if ($role instanceof Role) {
                $stmt->execute([$userId, $role->getId()]);
            } else {
                throw new Exception("Invalid role provided.");
            }
        }
    }

    public function getAllRoles()
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM roles");
            $stmt->execute();
            $roleData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $roles = [];
            foreach ($roleData as $row) {
                $roles[] = new Role($row['r_id'], $row['role']);
            }

            return $roles;
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch roles: " . $e->getMessage());
        }
    }

    public function getRolesByUserId($userId)
    {
        try {
            // Fetch roles associated with the user from the role_user table
            $stmt = $this->db->prepare("
            SELECT r.role 
            FROM roles r
            JOIN role_user ru ON r.r_id = ru.r_id
            WHERE ru.u_id = ?
        ");
            $stmt->execute([$userId]);

            // Fetch all roles associated with the user
            $rolesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Extract the role names into an array
            $roles = [];
            foreach ($rolesData as $row) {
                $roles[] = $row['role'];  // Only extract the 'role' field from the result
            }

            return $roles;
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch roles: " . $e->getMessage());
        }
    }

    public function getUserByUsername($username)
    {
        try {
            $stmt = $this->db->prepare("SELECT username, email FROM users WHERE username = :username");
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error fetching user details: " . $e->getMessage());
        }
    }

    public function getBugsByUsername($username)
    {
        try {
            $stmt = $this->db->prepare("
            SELECT bugs.* 
            FROM bugs 
            INNER JOIN users ON bugs.u_id = users.u_id 
            WHERE users.username = :username 
            ORDER BY bugs.date DESC
        ");
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error fetching user's bug reports: " . $e->getMessage());
        }
    }

    public function countPatchesByUser($username)
    {
        $query = "
        SELECT COUNT(*) AS patch_count 
        FROM patches p
        INNER JOIN users u ON p.u_id = u.u_id
        WHERE u.username = :username
    ";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? (int) $result['patch_count'] : 0; // Return 0 if no result is found
        } catch (PDOException $e) {
            throw new Exception("Database query error: " . $e->getMessage());
        }
    }

    public function countAcceptedPatchesByUser($userId)
    {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) AS accepted_patch_count FROM accepted_patches WHERE u_id = :u_id");
            $stmt->bindValue(':u_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['accepted_patch_count'];
        } catch (Exception $e) {
            throw new Exception("Error counting accepted patches: " . $e->getMessage());
        }
    }
}
