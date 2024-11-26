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
        $filterDate = "";
        // 1. Get the selected date from GET request, default to today
        if(isset($_GET['filter_date'])){
            $filterDate = $_GET['filter_date'];
        } else {
            $filterDate = date("Y-m-d");
        }
        // 2. Calculate the date ranges for weekly and monthly intervals
        $startOfWeek = date('Y-m-d', strtotime("$filterDate -6 days")); // Last 7 days
        $startOfMonth = date('Y-m-d', strtotime("$filterDate -29 days")); // Last 30 days


        // 4. Fetch data for statistics
        $bugStats = [
            'daily' => $this->bugService->getBugCountForDate($filterDate),
            'weekly' => $this->bugService->getBugCountForRange($startOfWeek, $filterDate),
            'monthly' => $this->bugService->getBugCountForRange($startOfMonth, $filterDate),
        ];

        $patchStats = [
            'daily' => $this->patchService->getPatchCountForDate($filterDate),
            'weekly' => $this->patchService->getPatchCountForRange($startOfWeek, $filterDate),
            'monthly' => $this->patchService->getPatchCountForRange($startOfMonth, $filterDate),
        ];

        $approvalStats = $this->patchService->getApprovalStatsByUser();
        $userBugStats = $this->bugService->getBugStatsByUser();
        $unapprovedPatches = $this->patchService->getUnapprovedPatchesLast7Days();

        // 5. Pass the variables to the view
        include '../views/statistics.php';
    }

}
