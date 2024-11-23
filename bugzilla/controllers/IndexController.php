<?php

class IndexController
{
    private $bugService;
    public function __construct(){
        $this->bugService = new BugService();
    }
    public function index()
    {
        $query = isset($_GET['search']) ? trim($_GET['search']) : '';
        try {
            if (!empty($query)) {
                $bugs = $this->bugService->searchBugs($query);
                if (empty($bugs)) {
                    $_SESSION['flash_message'] = "No bugs found matching your search.";
                }
            } else {
                $bugs = $this->bugService->getAllBugs();
            }
        } catch (Exception $e) {
            $_SESSION['flash_message'] = "Error retrieving bugs: " . $e->getMessage();
            $bugs = [];
        }
        $bugs = $this->bugService->getAllBugs();
        include '../views/index.php';
    }
    public function search()
    {
        if (isset($_GET['query'])) {
            $query = trim($_GET['query']);
            unset($_GET['query']);
            $bugs = $this->bugService->searchBugs($query);
            include '../views/index.php';
        } else {
            header("Location: index.php?action=index");
        }
    }
}
