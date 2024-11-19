<?php

/**
 * Database Configuration
 *
 * This file contains configuration settings for connecting to the MySQL database.
 *
 * @package Config
 */
class Database
{
    private static $instance = null;
    private $connection;

    /**
     * Constructor for establishing a PDO database connection.
     *
     * Initializes a PDO connection using provided database credentials and sets
     * necessary attributes for error handling.
     *
     * @throws PDOException If connection to the database fails.
     */
    private function __construct()
    {
        $host = 'localhost';   // Database server host
        $dbname = 'mvc  ';       // Database name
        $username = 'root';    // Database username
        $password = '';        // Database password

        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

        try {
            $this->connection = new PDO($dsn, $username, $password);
            // Set PDO attributes if needed (e.g., error mode)
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    /**
     * Get the singleton instance of the Database connection.
     *
     * Ensures only one instance of Database is created and returned.
     *
     * @return Database The singleton instance of the Database connection.
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Get the PDO database connection object.
     *
     * Returns the PDO database connection object established in the constructor.
     *
     * @return PDO|null The PDO database connection object, or null if not connected.
     */
    public function getConnection()
    {
        return $this->connection;
    }
}