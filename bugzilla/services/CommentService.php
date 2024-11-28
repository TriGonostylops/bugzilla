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

    // Save a new comment with u_id instead of username
    public function saveComment(Comment $comment)
    {
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO comments (message, date, u_id, bug_id) 
                VALUES (:message, :date, :u_id, :bug_id)"
            );

            $stmt->bindValue(':message', $comment->getMessage());
            $stmt->bindValue(':date', $comment->getDate());
            $stmt->bindValue(':u_id', $comment->getUserId()); // Use u_id instead of username
            $stmt->bindValue(':bug_id', $comment->getBugId()); // Ensure bug_id is linked

            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Error saving comment: " . $e->getMessage());
        }
    }

    // Retrieve comments for a bug with associated username via join
    public function getCommentsByBugId($bugId)
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT c.c_id, c.message, c.date, u.username 
                 FROM comments c
                 JOIN users u ON c.u_id = u.u_id
                 WHERE c.bug_id = :bug_id
                 ORDER BY c.date DESC"
            );

            $stmt->bindValue(':bug_id', $bugId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Error fetching comments: " . $e->getMessage());
        }
    }
}
