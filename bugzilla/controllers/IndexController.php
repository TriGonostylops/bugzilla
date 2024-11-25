<?php

class IndexController
{
    private $bugService;
    private $patchService;
    public function __construct(){
        $this->bugService = new BugService();
        $this->patchService = new PatchService();
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
    public function statistics()
    {
        try {
            // Fetching existing bug and patch statistics
            $bugStats = [
                'daily' => $this->bugService->getBugStatistics('daily'),
                'weekly' => $this->bugService->getBugStatistics('weekly'),
                'monthly' => $this->bugService->getBugStatistics('monthly'),
            ];

            $patchStats = [
                'daily' => $this->patchService->getPatchStatistics('daily'),
                'weekly' => $this->patchService->getPatchStatistics('weekly'),
                'monthly' => $this->patchService->getPatchStatistics('monthly'),
            ];

            // Fetching new approval statistics by username
            $approvalStats = $this->patchService->getApprovalStatsByUsername();

            // Fetching bug reporting statistics by username
            $userBugStats = $this->bugService->getBugStatsByUser();

            // Fetching unapproved patches from the last 7 days
            $unapprovedPatches = $this->patchService->getUnapprovedRecentPatches();

            // Including all data for rendering in the statistics view
            include '../views/statistics.php';
        } catch (Exception $e) {
            $_SESSION['flash_message'] = "Error fetching statistics: " . $e->getMessage();
            header("Location: index.php");
            exit();
        }
    }

}
