<?php
require_once '../services/BugService.php';
require_once '../services/CommentService.php';

require_once '../models/Bug.php';

class BugController
{
    private $bugService;
    private $commentService;
    public function __construct()
    {
        $this->bugService = new BugService();
        $this->commentService = new CommentService();
    }


    // Handle the form submission
    public function submitBugReport()
    {
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize and get form data
            $title = trim($_POST['title']);
            $description = trim($_POST['description']);
            $systemRequirements = trim($_POST['system_requirements']);
            $username = $_SESSION['user']['username'];  // Username from session

            if (empty($title) || empty($description)) {
                echo "Title and Description are required!";
                exit();
            }

            try {
                // Create a Bug model instance
                $bug = new Bug($username, $title, $description, $systemRequirements);

                // Save the bug report using the BugService
                if ($this->bugService->saveBug($bug)) {
                    // Redirect with success message
                    $_SESSION['flash_message'] = "Bug report submitted successfully!";
                    header("Location: index.php?action=index");
                    exit();
                } else {
                    echo "Failed to submit the bug report.";
                }
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
                exit();
            }
        } else {
            include '../views/bug_report.php';
        }
    }
    public function viewBug()
    {
        if (isset($_GET['b_id'])) {
            $bugId = $_GET['b_id'];
            try {
                $bug = $this->bugService->getBugById($bugId);
                $comments = $this->commentService->getCommentsByBugId($bugId);
                include '../views/view_bug.php';
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Bug ID not provided.";
        }
    }
    public function addComment()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'], $_GET['bug_id']) && is_numeric($_GET['bug_id'])) {
            $bugId = intval($_GET['bug_id']);
            $message = trim($_POST['message']);
            $username = $_SESSION['user']['username'];
            $date = date('Y-m-d H:i:s');

            if (empty($message)) {
                $_SESSION['flash_message'] = "Comment cannot be empty.";
                header("Location: index.php?action=view_bug&bug_id=" . $bugId);
                exit();
            }

            try {
                $comment = new Comment($message, $username, $bugId, $date); // Pass bug_id to Comment
                $this->commentService->saveComment($comment);

                $_SESSION['flash_message'] = "Comment added successfully.";
            } catch (Exception $e) {
                $_SESSION['flash_message'] = "Error adding comment: " . $e->getMessage();
            }

            header("Location: index.php?action=viewBug&b_id=" . $bugId);
            exit();
        }

        header("Location: index.php");
        exit();
    }

}

