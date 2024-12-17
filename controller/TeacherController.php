<?php
include_once "debug.php";
class TeacherController {
    public function updateTeacherStatus($id, $status) {
        try {
            $sql = config::getConnexion();
            $query = "UPDATE utilisateurs u INNER JOIN enseignants e ON u.id = e.utilisateur_id SET u.statut = :status WHERE e.id_enseignant = :id";
            $stmt = $sql->prepare($query);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return ["success" => true, "message" => "Teacher status updated to $status."];
            } else {
                return ["success" => false, "message" => "Failed to update teacher status."];
            }
        } catch (PDOException $e) {
            error_log("Error in updateTeacherStatus method: " . $e->getMessage());
            return ["success" => false, "message" => "Error: " . $e->getMessage()];
        }}
    public function searchTeacher($search) {
        try {
            $sql = config::getConnexion();
            $query = "SELECT u.nom, u.email, u.numero_telephone, e.id_enseignant, e.qualifications, e.image, e.cv 
                      FROM utilisateurs AS u 
                      LEFT JOIN enseignants AS e ON u.id = e.utilisateur_id 
                      WHERE u.nom LIKE :search 
                         OR u.email LIKE :search 
                         OR u.numero_telephone LIKE :search 
                         OR e.id_enseignant LIKE :search 
                         OR e.qualifications LIKE :search";

            $stmt = $sql->prepare($query);
            $searchTerm = '%' . $search . '%';
            $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in searchTeacher method: " . $e->getMessage());
            return [];
        }
    }
    public function updateTeacher($id, $nom, $numero_telephone, $mot_de_passe, $qualifications, $profilePicPath) {
        try {
            $sql = config::getConnexion();

            // Start constructing the SQL query
            $query = "UPDATE utilisateurs AS u
                  INNER JOIN enseignants AS e ON e.utilisateur_id = u.id
                  SET u.nom = :nom, 
                      u.numero_telephone = :numero_telephone,
                      e.qualifications = :qualifications";

            // Add the profile picture update if it exists
            if ($profilePicPath) {
                $query .= ", e.profile_pic = :profile_pic";
            }

            // Add password update if provided
            if ($mot_de_passe) {
                $query .= ", u.mot_de_passe = :mot_de_passe";
            }

            $query .= " WHERE e.id_enseignant = :id";

            // Prepare the SQL statement
            $stmt = $sql->prepare($query);

            // Bind the necessary parameters
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":nom", $nom, PDO::PARAM_STR);
            $stmt->bindParam(":numero_telephone", $numero_telephone, PDO::PARAM_STR);
            $stmt->bindParam(":qualifications", $qualifications, PDO::PARAM_STR);

            // Bind the profile picture path if it exists
            if ($profilePicPath) {
                $stmt->bindParam(":profile_pic", $profilePicPath, PDO::PARAM_STR);
            }

            // Bind the password if provided
            if ($mot_de_passe) {
                $stmt->bindParam(":mot_de_passe", $mot_de_passe, PDO::PARAM_STR);
            }

            // Execute the statement
            $stmt->execute();

            // Check if there was an error during the execution
            if ($stmt->errorCode() !== "00000") {
                $errorInfo = $stmt->errorInfo();
                error_log("Query Error: " . json_encode($errorInfo));
                return ["success" => false, "message" => "SQL Error: " . $errorInfo[2]];
            }

            // Return success message if the update was successful
            return ["success" => true, "message" => "Teacher details updated successfully."];

        } catch (Exception $e) {
            // Log the exception error
            error_log("Error in updateTeacher method: " . $e->getMessage());
            return ["success" => false, "message" => "Error: " . $e->getMessage()];
        }
    }
    public function getTeacherById($userId) {
        try {
            $sql = config::getConnexion();
            $query = "SELECT u.nom, u.email, u.numero_telephone, e.image FROM utilisateurs u INNER JOIN enseignants e ON u.id = e.utilisateur_id WHERE e.id_enseignant = :id";

            $stmt = $sql->prepare($query);
            $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in getTeacherById method: " . $e->getMessage());
            return null;
        }
    }
    public function countAllTeachers() {
        try {
            $sql = config::getConnexion();
            $query = "SELECT COUNT(*) AS total FROM enseignants";

            $stmt = $sql->prepare($query);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result["total"];
        } catch (Exception $e) {
            error_log("Error in countAllTeachers method: " . $e->getMessage());
            return 0;
        }
    }
    public function ShowTeachersByOrder($order, $fields) {

        try {
            $sql = config::getConnexion();
            $query = "SELECT t.*, u.* 
                      FROM enseignants t 
                      JOIN utilisateurs u ON t.utilisateur_id = u.id 
                      ORDER BY $fields $order";

            $stmt = $sql->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in ShowTeachersByOrder method: " . $e->getMessage());
            return [];
        }
    }
    public function deleteTeacher($id) {
        try {
            Debuggerr::log("Deleting teacher with ID:", $id);

            $sql = config::getConnexion();
            $sql->beginTransaction();

            $query = "DELETE t, u 
                      FROM enseignants t 
                      JOIN utilisateurs u ON t.utilisateur_id = u.id 
                      WHERE t.id_enseignant = :id";

            $stmt = $sql->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $sql->commit();
            Debuggerr::log("Teacher with ID $id deleted successfully.");
            return ["success" => true, "message" => "Teacher deleted successfully."];
        } catch (Exception $e) {
            $sql->rollBack();
            error_log("Error in deleteTeacher method: " . $e->getMessage());
            Debuggerr::log("Error in deleteTeacher method", $e->getMessage());
            return ["success" => false, "message" => "Error: " . $e->getMessage()];
        }
    }
}
?>
