<?php
require_once '../services/BugService.php';
require_once '../models/Bug.php';

class BugController
{
    private $bugService;

    public function __construct()
    {
        $this->bugService = new BugService();
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
}
?>
