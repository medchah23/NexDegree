<?php
class Database {
    // Variable statique pour stocker la connexion
    private static $connection = null;

    // Méthode pour obtenir une connexion PDO
    public static function getConnection() {
        if (self::$connection === null) {
            $servername = "localhost";
            $dbname = "qyy";
            $username = "root";
            $password = "";

            try {
                self::$connection = new PDO(
                    "mysql:host=$servername;dbname=$dbname",
                    $username,
                    $password
                );
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}
?>







