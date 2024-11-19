<?php

require_once '../config/database.php';
require_once '../models/Advertisement.php';

/**
 * AdvertisementService Class
 *
 * This class interacts with the database to perform operations related to advertisements.
 */
class AdvertisementService
{
    /**
     * @var PDO $db The PDO database connection instance.
     */
    private $db;

    /**
     * Constructor to initialize AdvertisementService and establish a database connection.
     */
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Fetches all advertisements from the database.
     *
     * @return array An array of Advertisement objects representing fetched advertisements.
     * @throws PDOException If there is a PDO-related database error.
     */
    public function getAllAdvertisements()
    {
        try {
            $stmt = $this->db->prepare("
                SELECT advertisements.id, advertisements.userid, advertisements.title, users.name AS userName
                FROM advertisements
                JOIN users ON advertisements.userid = users.id
            ");
            $stmt->execute();

            $advertisements = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $advertisement = new Advertisement($row['id'], $row['userid'], $row['title'], $row['userName']);
                $advertisements[] = $advertisement;
            }

            return $advertisements;

        } catch (PDOException $e) {
            // Re-throw the exception to handle it at a higher level
            throw new PDOException('Error fetching advertisements: ' . $e->getMessage());
        }
    }
}