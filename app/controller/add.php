<?php
include_once(__DIR__ . "../../configdb.php");
include_once(__DIR__ . "/debug.php");


class UserController {

    public function add($user): array {
        try {
            Debuggerr::log("Adding user:", $user);

            $sql = Config::getConnexion();
            $response = ["success" => false, "message" => "", "data" => null];

            // Check if email already exists
            $checkQuery = "SELECT * FROM utilisateurs WHERE email = :email";
            $stmt = $sql->prepare($checkQuery);
            $stmt->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);

            if ($stmt->execute() && $stmt->rowCount() > 0) {
                $response["message"] = "Email already exists in the database.";
                Debuggerr::log("Email already exists", $response);
                return $response;
            }

            // Begin transaction
            $sql->beginTransaction();

            // Insert into `utilisateurs`
            $insertUserQuery = "INSERT INTO `utilisateurs`(`nom`, `email`, `numero_telephone`, `role`, `mot_de_passe`, `statut`)
                            VALUES (:nom, :email, :tel, :role, :mot_de_passe, :statut)";
            $stmt = $sql->prepare($insertUserQuery);

            if (!$stmt->execute([
                ':nom' => $user->getNom(),
                ':email' => $user->getEmail(),
                ':tel' => $user->getTel(),
                ':role' => $user->getRole(),
                ':mot_de_passe' => $user->getMotDePasse(),
                ':statut' => $user->getStatut()
            ])) {
                $errorInfo = $stmt->errorInfo();
                $sql->rollBack();
                $response["message"] = "Failed to add user to 'utilisateurs': " . implode(", ", $errorInfo);
                Debuggerr::log("Error adding user to 'utilisateurs'", $response);
                return $response;
            }

            $userId = $sql->lastInsertId();

            // Role-specific insertions
            if ($user->getRole() === "etudiant") {
                $insertStudentQuery = "INSERT INTO etudiants (id_utilisateur, niveau, image_profil) 
                                   VALUES (:id_utilisateur, :niveau, :image_profil)";
                $stmt = $sql->prepare($insertStudentQuery);
                $stmt->bindParam(':id_utilisateur', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':niveau', $user->getNiveau(), PDO::PARAM_STR);
                $stmt->bindParam(':image_profil', $user->getImageProfil(), PDO::PARAM_LOB);
            } elseif ($user->getRole() === "enseignant") {
                $insertTeacherQuery = "INSERT INTO enseignants (utilisateur_id, qualifications, cv) 
                                   VALUES (:utilisateur_id, :qualifications, :cv)";
                $stmt = $sql->prepare($insertTeacherQuery);
                $stmt->bindParam(':utilisateur_id', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':qualifications', $user->getQualifications(), PDO::PARAM_STR);
                $stmt->bindParam(':cv', $user->getCv(), PDO::PARAM_LOB);
            } else {
                $sql->rollBack();
                $response["message"] = "Invalid role provided.";
                Debuggerr::log("Invalid role provided", $response);
                return $response;
            }

            // Execute role-specific query
            if ($stmt->execute()) {
                $sql->commit();
                $response["success"] = true;
                $response["message"] = $user->getRole() === "etudiant"
                    ? "Student added successfully!"
                    : "Teacher added successfully!";
                $response["data"] = ["id_utilisateur" => $userId];
                Debuggerr::log("User added successfully", $response);
            } else {
                $sql->rollBack();
                $response["message"] = "Failed to add " . $user->getRole() . ": " . implode(", ", $stmt->errorInfo());
                Debuggerr::log("Error in adding user role", $response);
            }

            return $response;
        } catch (Exception $e) {
            error_log("Error in add method: " . $e->getMessage());
            Debuggerr::log("Exception in add method", $e->getMessage());
            if (isset($sql) && $sql->inTransaction()) {
                $sql->rollBack();
            }
            return ["success" => false, "message" => "Exception: " . $e->getMessage(), "data" => null];
        }
    }

    // Show users by role
    public function show($role): array {
        try {
            Debuggerr::log("Fetching users with role:", $role);

            $sql = Config::getConnexion();
            $response = [];

            if ($role === 'etudiant') {
                $query = "SELECT e.id_etudiant, e.id_utilisateur, e.niveau, e.image_profil, 
                             u.nom, u.email, u.numero_telephone, u.role 
                      FROM etudiants e
                      JOIN utilisateurs u ON e.id_utilisateur = u.id_utilisateur
                      WHERE u.role = :role";
            } elseif ($role === 'enseignant') {
                $query = "SELECT t.id_enseignant, t.utilisateur_id, t.qualifications, t.cv, 
                             u.nom, u.email, u.numero_telephone, u.role 
                      FROM enseignants t
                      JOIN utilisateurs u ON t.utilisateur_id = u.id_utilisateur
                      WHERE u.role = :role";
            } else {
                $query = "SELECT * FROM utilisateurs WHERE role = :role";
            }

            $stmt = $sql->prepare($query);
            $stmt->bindParam(':role', $role, PDO::PARAM_STR);
            $stmt->execute();
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);

            Debuggerr::log("Fetched users:", $response);

            return $response;
        } catch (Exception $e) {
            error_log("Error in show method: " . $e->getMessage());
            Debuggerr::log("Error in show method", $e->getMessage());
            return [];
        }
    }

    // Show users by order
    public function showByOrder($table, $field) {
        try {
            Debuggerr::log("Executing query in showByOrder:", "SELECT * FROM $table ORDER BY $field");

            $conn = config::getConnexion();
            $query = "SELECT * FROM $table ORDER BY $field";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            Debuggerr::log("showByOrder result:", $result);

            return $result;
        } catch (PDOException $e) {
            Debuggerr::log("Error in showByOrder:", $e->getMessage());
            throw $e;
        }
    }

    // Update a user
    public function update($user) {
        try {
            Debuggerr::log("Updating user:", $user);
            $sql = config::getConnexion();
            // Update query
            $updateQuery = "UPDATE utilisateur SET 
                                nom = :nom,
                                mot_de_passe = :mot_de_passe
                            WHERE id_utilisateur = :id";
            $stmt = $sql->prepare($updateQuery);
            $stmt->bindParam(':nom', $user->getNom(), PDO::PARAM_STR);
            $stmt->bindParam(':mot_de_passe', $user->getMotDePasse(), PDO::PARAM_STR);
            $stmt->bindParam(':role', $user->getRole(), PDO::PARAM_STR);
            $stmt->bindParam(':statut', $user->getStatut(), PDO::PARAM_STR);
            $stmt->bindParam(':id', $user->getIdUtilisateur(), PDO::PARAM_INT);
            $stmt->execute();
            Debuggerr::log("Update result:", ["rowCount" => $stmt->rowCount()]);

            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Error in update method: " . $e->getMessage());
            Debuggerr::log("Error in update method", $e->getMessage());
            return false;
        }
    }

    // Delete a user
    public function delete($id) {
        try {
            Debuggerr::log("Deleting user with id:", $id);

            $sql = config::getConnexion();
            $sql->beginTransaction();

            $deleteStudentQuery = "DELETE FROM etudiants WHERE id_utilisateur = :id";
            $stmt = $sql->prepare($deleteStudentQuery);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Delete from enseignant table
            $deleteTeacherQuery = "DELETE FROM enseignants WHERE utilisateur_id = :id";
            $stmt = $sql->prepare($deleteTeacherQuery);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            // Delete from enseignant table


            // Delete from utilisateur table
            $deleteUserQuery = "DELETE FROM utilisateurs WHERE id = :id";
            $stmt = $sql->prepare($deleteUserQuery);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $sql->commit();
            Debuggerr::log("User with id $id deleted successfully.");

            return true;
        } catch (Exception $e) {
            $sql->rollBack();
            error_log("Error in delete method: " . $e->getMessage());
            Debuggerr::log("Error in delete method", $e->getMessage());
            return false;
        }
    }
}

?>

