<?php

class AdminService
{
    private $db;

    public function __construct()
    {
        $this->db = $this->connectToDatabase();
    }

    private function connectToDatabase()
    {
        $host = 'localhost';  // Database host
        $dbname = 'bugzilla'; // Database name
        $username = 'root';   // Database username
        $password = '';       // Database password

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    // Get all users (No changes needed here)
    public function getAllUsers()
    {
        $stmt = $this->db->query('SELECT u_id, username, email FROM users');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all bugs with proper username retrieval using u_id
    public function getAllBugs()
    {
        try {
            // Join the bugs table with the users table to get the username
            $stmt = $this->db->prepare(
                "SELECT b.b_id, u.username, b.title, b.description, b.system_requirements, b.date 
                FROM bugs b
                JOIN users u ON b.u_id = u.u_id"
            );
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error fetching bugs: " . $e->getMessage());
        }
    }

    // Delete a user and handle cascading deletes (with role_user table)
    public function deleteUser($userId)
    {
        try {
            $this->db->beginTransaction();

            // First delete roles associated with the user from the role_user table
            $stmt = $this->db->prepare('DELETE FROM role_user WHERE u_id = ?');
            $stmt->execute([$userId]);

            // Then delete the user from the users table
            $stmt = $this->db->prepare('DELETE FROM users WHERE u_id = ?');
            $stmt->execute([$userId]);

            // Commit the transaction
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            // Rollback in case of any failure
            $this->db->rollBack();
            return false;
        }
    }

    // Delete a bug (No changes needed here)
    public function deleteBug($bugId)
    {
        try {
            $stmt = $this->db->prepare('DELETE FROM bugs WHERE b_id = ?');
            return $stmt->execute([$bugId]);
        } catch (Exception $e) {
            throw new Exception("Error deleting bug: " . $e->getMessage());
        }
    }
}
