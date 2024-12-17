<?php
include_once(__DIR__ . "../config.php");
require_once("debug.php");

class Face
{
    // Insert face ID and image into the database
    public function insertFaceId( $image)
    {
        try {

            $sql = config::getConnexion();
            $id = $sql->lastInsertId();

            $query = "INSERT INTO face_id (user_id, face_image) VALUES (:user_id, :image)";
            $stmt = $sql->prepare($query);

            $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':image', $image, PDO::PARAM_STR);

            // Execute the query
            $stmt->execute();

            Debuggerr::log("Face ID inserted successfully for User ID: " . $id);

        } catch (PDOException $e) {
            Debuggerr::log("Error: " . $e->getMessage());
        }

    }
}
