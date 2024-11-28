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

    // Save a patch with u_id instead of username
    public function savePatch(Patch $patch)
    {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO patches (code, is_approved, date, message, u_id, bug_id) 
                VALUES (:code, :is_approved, :date, :message, :u_id, :bug_id)"
            );

            $stmt->bindValue(':code', $patch->getCode());
            $stmt->bindValue(':is_approved', $patch->getIsApproved(), PDO::PARAM_INT);
            $stmt->bindValue(':date', $patch->getDate());
            $stmt->bindValue(':message', $patch->getMessage());
            $stmt->bindValue(':u_id', $patch->getUserId()); // Save u_id instead of username
            $stmt->bindValue(':bug_id', $patch->getBugId(), PDO::PARAM_INT);

            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Error saving patch: " . $e->getMessage());
        }
    }

    // Approve a patch by saving the relationship between patch and user
    public function approvePatch($patchId, $userId)
    {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO accepted_patches (p_id, u_id) 
                VALUES (:patchId, :userId)"
            );

            $stmt->bindValue(':patchId', $patchId, PDO::PARAM_INT);
            $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Error approving patch: " . $e->getMessage());
        }
    }

    // Check if a user has already approved a patch
    public function checkIfUserApprovedPatch($patchId, $userId)
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT 1 FROM accepted_patches 
                 WHERE p_id = :patchId AND u_id = :userId"
            );

            $stmt->bindValue(':patchId', $patchId, PDO::PARAM_INT);
            $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchColumn() > 0; // Returns true if user approved
        } catch (Exception $e) {
            throw new Exception("Error checking patch approval: " . $e->getMessage());
        }
    }

    // Get the number of approvals for a patch
    public function getPatchApprovalCount($patchId)
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT COUNT(*) 
                 FROM accepted_patches 
                 WHERE p_id = :patchId"
            );

            $stmt->bindValue(':patchId', $patchId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (Exception $e) {
            throw new Exception("Error fetching patch approval count: " . $e->getMessage());
        }
    }

    // Get patch details by patch ID with associated username
    public function getPatchById($patchId)
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT p.p_id, p.code, p.is_approved, p.date, p.message, u.username 
                 FROM patches p
                 JOIN users u ON p.u_id = u.u_id
                 WHERE p.p_id = :patch_id"
            );

            $stmt->bindValue(':patch_id', $patchId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error fetching patch details: " . $e->getMessage());
        }
    }
    // Get patch count for a specific date
    public function getPatchCountForDate($date)
    {
        try {
            $query = "SELECT COUNT(*) AS total FROM patches WHERE DATE(date) = :date";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':date', $date, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            throw new Exception("Error fetching patch count for date: " . $e->getMessage());
        }
    }

// Get patch count for a date range
    public function getPatchCountForRange($startDate, $endDate)
    {
        try {
            $query = "SELECT COUNT(*) AS total FROM patches WHERE DATE(date) BETWEEN :startDate AND :endDate";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':startDate', $startDate, PDO::PARAM_STR);
            $stmt->bindValue(':endDate', $endDate, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            throw new Exception("Error fetching patch count for range: " . $e->getMessage());
        }
    }

// Get approvals by user
    public function getApprovalStatsByUser()
    {
        try {
            $query = "SELECT u.username, COUNT(ap.p_id) AS approval_count 
                  FROM accepted_patches ap
                  JOIN users u ON ap.u_id = u.u_id
                  GROUP BY u.username";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error fetching approval stats by user: " . $e->getMessage());
        }
    }

// Get unapproved patches from the last 7 days
    public function getUnapprovedPatchesLast7Days()
    {
        try {
            $query = "SELECT p.*, u.username 
                  FROM patches p
                  JOIN users u ON p.u_id = u.u_id
                  WHERE p.is_approved = 0 AND DATE(p.date) >= DATE(NOW()) - INTERVAL 7 DAY";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error fetching unapproved patches from the last 7 days: " . $e->getMessage());
        }
    }

}
