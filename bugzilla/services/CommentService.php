<?php

require_once '../config/database.php';
require_once '../models/Comment.php';

class CommentService
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

    public function saveComment(Comment $comment)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO comments (message, date, username, bug_id) 
                                    VALUES (:message, :date, :username, :bug_id)");
            $stmt->bindValue(':message', $comment->getMessage());
            $stmt->bindValue(':date', $comment->getDate());
            $stmt->bindValue(':username', $comment->getUsername());
            $stmt->bindValue(':bug_id', $comment->getBugId()); // Get bug_id from Comment model
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Error saving comment: " . $e->getMessage());
        }
    }

    public function getCommentsByBugId($bugId)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM comments WHERE bug_id = :bug_id ORDER BY date DESC");
            $stmt->bindValue(':bug_id', $bugId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error fetching comments: " . $e->getMessage());
        }
    }

}
