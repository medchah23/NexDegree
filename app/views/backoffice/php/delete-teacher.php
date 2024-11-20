<?php

require_once("../../../controller/add.php");
require_once("../../../Model/etudient.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sql = config::getConnexion();


        $query_teacher = "DELETE FROM enseignants WHERE enseignants.utilisateur_id  = :id";
        $stmt_teacher = $sql->prepare($query_teacher);
        $stmt_teacher->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt_teacher->execute();

        $query_user = "DELETE FROM utilisateurs WHERE `utilisateurs`.`id`=:id";
        $stmt_user = $sql->prepare($query_user);
        $stmt_user->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt_user->execute();

        $sql->commit();

        // Redirect to the students page
        header("Location: teachers.php");
        exit(); // Stop further script execution after the redirect
    } catch (PDOException $e) {
        // Rollback the transaction if an error occurs
        $sql->rollBack();
        // Log the error or handle it accordingly
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid or missing ID.";
}
?>