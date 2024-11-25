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
    public function getPatchStatistics($interval)
    {
        try {
            $query = "SELECT COUNT(*) AS total FROM patches WHERE DATE(date) >= CURDATE() - INTERVAL :interval DAY";
            $stmt = $this->db->prepare($query);

            switch ($interval) {
                case 'daily':
                    $stmt->bindValue(':interval', 1, PDO::PARAM_INT);
                    break;
                case 'weekly':
                    $stmt->bindValue(':interval', 7, PDO::PARAM_INT);
                    break;
                case 'monthly':
                    $stmt->bindValue(':interval', 30, PDO::PARAM_INT);
                    break;
                default:
                    throw new Exception("Invalid interval specified.");
            }

            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (Exception $e) {
            throw new Exception("Error fetching patch statistics: " . $e->getMessage());
        }
    }
    public function getApprovalStatsByUsername()
    {
        try {
            $stmt = $this->db->prepare("
            SELECT p.username, COUNT(ap.p_id) AS approval_count
            FROM patches p
            JOIN accepted_patches ap ON p.p_id = ap.p_id
            GROUP BY p.username
        ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error fetching approval stats: " . $e->getMessage());
        }
    }
    public function getUnapprovedRecentPatches()
    {
        try {
            $stmt = $this->db->prepare("
            SELECT p.*
            FROM patches p
            JOIN bugs b ON p.bug_id = b.b_id
            WHERE p.is_approved = 0
            AND b.date >= (SELECT DATE_SUB(CURDATE(), INTERVAL 7 DAY))
        ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error fetching unapproved recent patches: " . $e->getMessage());
        }
    }
}
