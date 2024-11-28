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
            // Get the user ID from the username
            $userId = $this->getUserIdByUsername($comment->getUserName());

            // Prepare the SQL to save the comment
            $stmt = $this->db->prepare(
                "INSERT INTO comments (message, date, u_id, bug_id) 
            VALUES (:message, :date, :u_id, :bug_id)"
            );

            $stmt->bindValue(':message', $comment->getMessage());
            $stmt->bindValue(':date', $comment->getDate());
            $stmt->bindValue(':u_id', $userId, PDO::PARAM_INT); // Use the retrieved user ID
            $stmt->bindValue(':bug_id', $comment->getBugId(), PDO::PARAM_INT);

            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Error saving comment: " . $e->getMessage() . $comment->getMessage() . $comment->getUserId());
        }
    }


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
    public function getUserIdByUsername($username)
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT u_id 
             FROM users 
             WHERE username = :username"
            );

            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result['u_id'];
            } else {
                throw new Exception("No user found with username: " . $username);
            }
        } catch (Exception $e) {
            throw new Exception("Error fetching user ID: " . $e->getMessage());
        }
    }

}
