<?php

class Patch
{
    private $p_id;
    private $code;
    private $is_approved;
    private $date;
    private $message;
    private $username;
    private $bug_id;

    public function __construct($code, $message, $username, $bug_id, $is_approved = 0, $date = null)
    {
        $this->code = $code;
        $this->message = $message;
        $this->username = $username;
        $this->bug_id = $bug_id;
        $this->is_approved = $is_approved;
        $this->date = $date ?: date('Y-m-d H:i:s');
    }

    public function getId()
    {
        return $this->p_id;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getBugId()
    {
        return $this->bug_id;
    }

    public function getIsApproved()
    {
        return $this->is_approved;
    }

    public function getDate()
    {
        return $this->date;
    }
}