<?php

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        // Replace with your actual database connection details
        $host = 'localhost';
        $db = 'bugzilla';
        $user = 'root';
        $pass = '';

        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Database connection error: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}