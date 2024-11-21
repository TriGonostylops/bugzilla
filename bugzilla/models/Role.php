<?php

class Role
{
    private $r_id;
    private $role;

    public function __construct($r_id, $role)
    {
        $this->r_id = $r_id;
        $this->role = $role;
    }

    public function getId()
    {
        return $this->r_id;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setId($r_id)
    {
        $this->r_id = $r_id;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }
}
