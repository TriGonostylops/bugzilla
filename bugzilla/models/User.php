<?php

/**
 * Class User
 *
 * Represents a user with their properties.
 */
class User
{
    /**
     * @var int $id The unique identifier of the user.
     */
    public $id;

    /**
     * @var string $name The name of the user.
     */
    public $name;

    /**
     * User constructor.
     *
     * @param int $id The unique identifier of the user.
     * @param string $name The name of the user.
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * Get the ID of the user.
     *
     * @return int The ID of the user.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the name of the user.
     *
     * @return string The name of the user.
     */
    public function getName()
    {
        return $this->name;
    }
}