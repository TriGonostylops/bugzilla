<?php
class Bug
{
    private $b_id;
    private $username;
    private $title;
    private $description;
    private $systemRequirements;
    private $date;

    public function __construct($username, $title, $description, $systemRequirements, $date = null)
    {
        $this->username = $username;
        $this->title = $title;
        $this->description = $description;
        $this->systemRequirements = $systemRequirements;
        $this->date = $date ?: date('Y-m-d H:i:s');
    }

    // Getters
    public function getBId()
    {
        return $this->b_id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getSystemRequirements()
    {
        return $this->systemRequirements;
    }

    public function getDate()
    {
        return $this->date;
    }
}
?>
