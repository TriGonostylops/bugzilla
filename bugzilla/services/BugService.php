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

    public function saveBug(Bug $bug)
    {
        try {
            // Fetch u_id based on the provided username
            $stmt = $this->db->prepare("SELECT u_id FROM users WHERE username = :username");
            $stmt->bindValue(':username', $bug->getUsername());
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                throw new Exception("User not found.");
            }
            $u_id = $user['u_id'];

            // Insert bug into the database with the u_id
            $stmt = $this->db->prepare("INSERT INTO bugs (u_id, title, description, system_requirements, date) 
                                        VALUES (:u_id, :title, :description, :system_requirements, :date)");
            $stmt->bindValue(':u_id', $u_id, PDO::PARAM_INT);
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
            // Join bugs table with users to fetch username based on u_id
            $stmt = $this->db->prepare(
                "SELECT b.b_id, u.username, b.title, b.date 
                FROM bugs b 
                JOIN users u ON b.u_id = u.u_id 
                ORDER BY b.date DESC"
            );
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error fetching bugs: " . $e->getMessage());
        }
    }

    public function getBugById($bugId)
    {
        try {
            // Join bugs table with users to fetch username based on u_id
            $stmt = $this->db->prepare(
                "SELECT b.*, u.username 
                FROM bugs b
                JOIN users u ON b.u_id = u.u_id
                WHERE b.b_id = :b_id"
            );
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
            // Join bugs table with users to fetch username based on u_id
            $stmt = $this->db->prepare(
                "SELECT b.*, u.username 
                FROM bugs b
                JOIN users u ON b.u_id = u.u_id
                WHERE LOWER(u.username) LIKE LOWER(:query) 
                OR LOWER(b.title) LIKE LOWER(:query) 
                ORDER BY b.title ASC, b.date DESC"
            );
            $stmt->bindValue(':query', '%' . strtolower($query) . '%', PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error searching bugs: " . $e->getMessage());
        }
    }

    public function getBugCountForDate($date)
    {
        try {
            $query = "SELECT COUNT(*) AS total FROM bugs WHERE DATE(date) = :date";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':date', $date);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            throw new Exception("Error counting bugs for date: " . $e->getMessage());
        }
    }

    public function getBugCountForRange($startDate, $endDate)
    {
        try {
            $query = "SELECT COUNT(*) AS total FROM bugs WHERE DATE(date) BETWEEN :startDate AND :endDate";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':startDate', $startDate);
            $stmt->bindValue(':endDate', $endDate);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            throw new Exception("Error counting bugs for date range: " . $e->getMessage());
        }
    }

    public function getBugStatsByUser()
    {
        try {
            // Join bugs table with users to get bug count by username
            $query = "SELECT u.username, COUNT(*) AS bug_count
                      FROM bugs b
                      JOIN users u ON b.u_id = u.u_id
                      GROUP BY u.username";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error fetching bug stats by user: " . $e->getMessage());
        }
    }
}

