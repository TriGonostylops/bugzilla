<?php

class Comment
{
    private $c_id;
    private $message;
    private $date;
    private $userId;
    private $bug_id;

    public function __construct($message, $userId, $bug_id, $date = null)
    {
        $this->message = $message;
        $this->userId = $userId;
        $this->bug_id = $bug_id; // Set bug_id
        $this->date = $date ?: date('Y-m-d H:i:s');
    }

    public function getId()
    {
        return $this->c_id;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getuserId()
    {
        return $this->userId;
    }

    public function getBugId()
    {
        return $this->bug_id; // Getter for bug_id
    }

    public function setBugId($bug_id)
    {
        $this->bug_id = $bug_id; // Setter for bug_id
    }
}
