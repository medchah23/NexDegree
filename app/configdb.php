<?php
class Config
{
    private static ?PDO $pdo = null; // Singleton instance

    public static function getConnexion(): PDO
    {
        if (self::$pdo === null) { // Check if connection already exists
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "nexdegree";

            try {
                self::$pdo = new PDO(
                    "mysql:host=$servername;dbname=$dbname",
                    $username,
                    $password
                );
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                // Log the error and provide a generic message
                error_log("[DB Connection Error]: " . $e->getMessage());
                die('Error connecting to the database. Please try again later.');
            }
        }
        return self::$pdo;
    }
}
?>
