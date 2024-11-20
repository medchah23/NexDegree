<?php

require_once("../../../controller/add.php");
require_once("../../../Model/etudient.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sql = config::getConnexion();
        $query = "DELETE FROM `utilisateurs` WHERE id = :id";
        $stmt = $sql->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: students.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid or missing ID.";
}
