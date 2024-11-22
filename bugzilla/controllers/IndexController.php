<?php

class IndexController
{
    private $bugService;
    public function __construct(){
        $this->bugService = new BugService();
    }
    public function index()
    {
        $bugs = $this->bugService->getAllBugs();
        include '../views/index.php';
    }

}
