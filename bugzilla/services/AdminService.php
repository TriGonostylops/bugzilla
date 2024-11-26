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

    // Methods remain unchanged...

    public function getAllUsers()
    {
        $stmt = $this->db->query('SELECT u_id, username, email FROM users');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllBugs()
    {
        $stmt = $this->db->query('SELECT b_id, username, title, description, system_requirements, date FROM bugs');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteUser($userId)
    {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare('DELETE FROM role_user WHERE u_id = ?');
            $stmt->execute([$userId]);

            $stmt = $this->db->prepare('DELETE FROM users WHERE u_id = ?');
            $stmt->execute([$userId]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function deleteBug($bugId)
    {
        $stmt = $this->db->prepare('DELETE FROM bugs WHERE b_id = ?');
        return $stmt->execute([$bugId]);
    }
}
