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
    public function getAllBugs()
    {
        try {
            $stmt = $this->db->prepare("SELECT b_id, username, title, date FROM bugs ORDER BY date DESC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error fetching bugs: " . $e->getMessage());
        }
    }
    public function getBugById($bugId)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM bugs WHERE b_id = :b_id");
            $stmt->bindValue(':b_id', $bugId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error fetching bug details: " . $e->getMessage());
        }
    }
    public function searchBugs($query)
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT * FROM bugs 
             WHERE LOWER(username) LIKE LOWER(:query) 
             OR LOWER(title) LIKE LOWER(:query) 
             ORDER BY title ASC, date DESC"
            );
            $stmt->bindValue(':query', '%' . strtolower($query) . '%', PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error searching bugs: " . $e->getMessage());
        }
    }

}