<?php

/**
 * Class Advertisement
 *
 * Represents an advertisement with its properties.
 */
class Advertisement
{
    /**
     * @var int $id The unique identifier of the advertisement.
     */
    private $id;

    /**
     * @var int $userId The ID of the user who posted the advertisement.
     */
    private $userId;

    /**
     * @var string $title The title of the advertisement.
     */
    private $title;

    /**
     * @var string $userName The name of the user who posted the advertisement.
     */
    private $userName;

    /**
     * Advertisement constructor.
     *
     * @param int $id The unique identifier of the advertisement.
     * @param int $userId The ID of the user who posted the advertisement.
     * @param string $title The title of the advertisement.
     * @param string $userName The name of the user who posted the advertisement.
     */
    public function __construct($id, $userId, $title, $userName)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->userName = $userName;
    }

    /**
     * Get the ID of the advertisement.
     *
     * @return int The ID of the advertisement.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the ID of the user who posted the advertisement.
     *
     * @return int The ID of the user.
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Get the title of the advertisement.
     *
     * @return string The title of the advertisement.
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the name of the user who posted the advertisement.
     *
     * @return string The name of the user.
     */
    public function getUserName()
    {
        return $this->userName;
    }
}