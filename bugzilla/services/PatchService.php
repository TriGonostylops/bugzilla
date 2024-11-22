<?php

require_once '../config/database.php';
require_once '../models/Patch.php';

class PatchService
{
    private $db;

    public function __construct()
    {
        try {
            $this->db = Database::getInstance()->getConnection();
        } catch (Exception $e) {
            throw new Exception("Database connection error: " . $e->getMessage());
        }
    }

    public function savePatch(Patch $patch)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO patches (code, is_approved, date, message, username, bug_id) 
                                    VALUES (:code, :is_approved, :date, :message, :username, :bug_id)");
            $stmt->bindValue(':code', $patch->getCode());
            $stmt->bindValue(':is_approved', $patch->getIsApproved(), PDO::PARAM_INT);
            $stmt->bindValue(':date', $patch->getDate());
            $stmt->bindValue(':message', $patch->getMessage());
            $stmt->bindValue(':username', $patch->getUsername());
            $stmt->bindValue(':bug_id', $patch->getBugId(), PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Error saving patch: " . $e->getMessage());
        }
    }

    public function getPatchesByBugId($bugId)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM patches WHERE bug_id = :bug_id ORDER BY date DESC");
            $stmt->bindValue(':bug_id', $bugId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error fetching patches: " . $e->getMessage());
        }
    }
}
