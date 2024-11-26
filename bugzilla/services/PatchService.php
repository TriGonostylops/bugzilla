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
    public function approvePatch($patchId, $userId)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO accepted_patches (p_id, u_id) VALUES (:patchId, :userId)");
            $stmt->bindValue(':patchId', $patchId, PDO::PARAM_INT);
            $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Error approving patch: " . $e->getMessage());
        }
    }
    public function checkIfUserApprovedPatch($patchId, $userId)
    {
        $stmt = $this->db->prepare("SELECT 1 FROM accepted_patches WHERE p_id = :patchId AND u_id = :userId");
        $stmt->bindValue(':patchId', $patchId, PDO::PARAM_INT);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
    public function getPatchApprovalCount($patchId)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM accepted_patches WHERE p_id = :patchId");
        $stmt->bindValue(':patchId', $patchId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    public function getPatchById($patchId)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM patches WHERE p_id = :patch_id");
            $stmt->bindValue(':patch_id', $patchId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); // Return patch as an associative array
        } catch (Exception $e) {
            throw new Exception("Error fetching patch: " . $e->getMessage());
        }
    }
    public function setPatchApproved($patchId)
    {
        try {
            // Update the patch's 'is_approved' field to 1 (approved)
            $stmt = $this->db->prepare("UPDATE patches SET is_approved = 1 WHERE p_id = :patch_id");
            $stmt->bindValue(':patch_id', $patchId, PDO::PARAM_INT);
            $stmt->execute();

            // Optionally, you could check if any rows were updated
            if ($stmt->rowCount() > 0) {
                return true; // Successfully approved the patch
            } else {
                return false; // Patch ID not found or no update performed
            }
        } catch (Exception $e) {
            throw new Exception("Error updating patch approval: " . $e->getMessage());
        }
    }
    // Get patch count for a specific date
    public function getPatchCountForDate($date)
    {
        $query = "SELECT COUNT(*) AS total FROM patches WHERE DATE(date) = :date";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':date', $date);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Get patch count for a date range
    public function getPatchCountForRange($startDate, $endDate)
    {
        $query = "SELECT COUNT(*) AS total FROM patches WHERE DATE(date) BETWEEN :startDate AND :endDate";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':startDate', $startDate);
        $stmt->bindValue(':endDate', $endDate);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // Get approvals by user
    public function getApprovalStatsByUser()
    {
        $query = "SELECT username, COUNT(*) AS approval_count FROM patches WHERE is_approved = 1 GROUP BY username";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get unapproved patches from the last 7 days
    public function getUnapprovedPatchesLast7Days()
    {
        $query = "SELECT * FROM patches WHERE is_approved = 0 AND DATE(date) >= DATE(NOW()) - INTERVAL 7 DAY";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
