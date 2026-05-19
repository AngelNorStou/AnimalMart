<?php
class Database {
    private $host = "localhost";
    private $db_name = "animalmart";
    private $username = "root";
    private $password = "";
    private static ?PDO $conn = null;

    public static function getConnection(): PDO {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO(
                    "mysql:host=localhost;dbname=animalmart",
                    "root",
                    ""
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch(PDOException $e) {
                error_log("Database connection error: " . $e->getMessage());
                die("Database connection error.");
            }
        }
        return self::$conn;
    }
}

