<?php
require_once '../config/database.php';
require_once '../models/Bug.php';

class BugService
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
// Insert a bug into the database
    public function saveBug(Bug $bug)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO bugs (username, title, description, system_requirements, date) 
                                    VALUES (:username, :title, :description, :system_requirements, :date)");

            // Use bindValue() instead of bindParam() to bind values directly
            $stmt->bindValue(':username', $bug->getUsername());
            $stmt->bindValue(':title', $bug->getTitle());
            $stmt->bindValue(':description', $bug->getDescription());
            $stmt->bindValue(':system_requirements', $bug->getSystemRequirements());
            $stmt->bindValue(':date', $bug->getDate());

            return $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Error saving bug report: " . $e->getMessage());
        }
    }

}
?>
