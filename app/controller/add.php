<?php
include_once(__DIR__ . "../../configdb.php");
 class UserController{
     public function add($user): array
     {
         try {
             $sql = Config::getConnexion();
             $response = ["success" => false, "message" => "", "data" => null];

             // Check if email already exists
             $checkQuery = "SELECT * FROM utilisateurs WHERE email = :email";
             $stmt = $sql->prepare($checkQuery);
             $stmt->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);

             if ($stmt->execute() && $stmt->rowCount() > 0) {
                 $response["message"] = "Email already exists in the database.";
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
             } else {
                 $sql->rollBack();
                 $response["message"] = "Failed to add " . $user->getRole() . ": " . implode(", ", $stmt->errorInfo());
             }

             return $response;
         } catch (Exception $e) {
             error_log("Error in add method: " . $e->getMessage());
             if (isset($sql) && $sql->inTransaction()) {
                 $sql->rollBack();
             }
             return ["success" => false, "message" => "Exception: " . $e->getMessage(), "data" => null];
         }
     }

// Show users by role
    public function show($role)
    {
        try {
            $sql = config::getConnexion();
            $query = "SELECT * FROM utilisateur WHERE role = :role";
            $stmt = $sql->prepare($query);
            $stmt->bindParam(':role', $role, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in show method: " . $e->getMessage());
            return [];
        }
    }

    public function showByOrder($role, $order): array
    {
        try {
            $allowedColumns = ['id', 'nom', 'email', 'role', 'cree_a'];
            if (!in_array($order, $allowedColumns)) {
                throw new Exception("Invalid column name for sorting: $order");
            }
            $sql = config::getConnexion();
            if ($role === 'etudiant') {
                $query = "SELECT id_etudiant, id_utilisateur, niveau, image_profil 
                      FROM etudiants 
                      WHERE 1 
                      ORDER BY $order";
            } elseif ($role === 'enseignant') {
                $query = "SELECT id_enseignant, utilisateur_id, qualifications, cv 
                      FROM enseignants 
                      WHERE 1 
                      ORDER BY $order";
            } else {
                $query = "SELECT * FROM utilisateur 
                      WHERE role = :role 
                      ORDER BY $order";
            }

            // Prepare and execute the query
            $stmt = $sql->prepare($query);
            if ($role !== 'etudiant' && $role !== 'enseignant') {
                $stmt->bindParam(':role', $role, PDO::PARAM_STR);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in showByOrder method: " . $e->getMessage());
            return [];
        }
    }

    // Update a user
    public function update($user)
    {
        try {
            $sql = config::getConnexion();

            // Update query
            $updateQuery = "UPDATE utilisateur SET 
                                nom = :nom,
                                mot_de_passe = :mot_de_passe,
                            WHERE id_utilisateur = :id";
            $stmt = $sql->prepare($updateQuery);
            $stmt->bindParam(':nom', $user->getNom(), PDO::PARAM_STR);
            $stmt->bindParam(':mot_de_passe', $user->getMotDePasse(), PDO::PARAM_STR);
            $stmt->bindParam(':role', $user->getRole(), PDO::PARAM_STR);
            $stmt->bindParam(':statut', $user->getStatut(), PDO::PARAM_STR);
            $stmt->bindParam(':id', $user->getIdUtilisateur(), PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Error in update method: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $sql = config::getConnexion();
            $sql->beginTransaction();

            // Delete from etudiant table
            $deleteStudentQuery = "DELETE FROM etudiants WHERE id_utilisateur = :id";
            $stmt = $sql->prepare($deleteStudentQuery);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Delete from enseignant table
            $deleteTeacherQuery = "DELETE FROM enseignants WHERE id_utilisateur = :id";
            $stmt = $sql->prepare($deleteTeacherQuery);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Delete from utilisateur table
            $deleteUserQuery = "DELETE FROM utilisateurs WHERE id_utilisateur = :id";
            $stmt = $sql->prepare($deleteUserQuery);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $sql->commit();
            return true;
        } catch (Exception $e) {
            $sql->rollBack();
            error_log("Error in delete method: " . $e->getMessage());
            return false;
        }
    }
}
?>
