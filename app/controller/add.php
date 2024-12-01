<?php
include_once(__DIR__ . "../../configdb.php");
include_once(__DIR__ . "/debug.php");


class UserController {

    public function add($user): array
    {
        try {
            Debuggerr::log("Adding user:", $user);

            $sql = Config::getConnexion();
            $response = ["success" => false, "message" => "", "data" => null];

            // Check if email already exists
            $checkQuery = "SELECT * FROM utilisateurs WHERE email = :email";
            $stmt = $sql->prepare($checkQuery);
            $stmt->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);

            if ($stmt->execute() && $stmt->rowCount() > 0) {
                $response["message"] = "L'adresse e-mail existe déjà dans la base de données.";
                Debuggerr::log("Email already exists", $response);
                return $response;
            }

            // Begin transaction
            $sql->beginTransaction();

            // Insert into `utilisateurs`
            $insertUserQuery = "INSERT INTO `utilisateurs`(`nom`, `email`, `numero_telephone`, `role`, `mot_de_passe`, `statut`)
                                VALUES (:nom, :email, :tel, :role, :mot_de_passe, :statut)";
            $stmt = $sql->prepare($insertUserQuery);

            $stmt->execute([
                ':nom' => $user->getNom(),
                ':email' => $user->getEmail(),
                ':tel' => $user->getTel(),
                ':role' => $user->getRole(),
                ':mot_de_passe' => $user->getMotDePasse(),
                ':statut' => $user->getStatut(),
            ]);

            $userId = $sql->lastInsertId();

            // Role-specific insertions
            if ($user->getRole() === "etudiant") {
                $insertStudentQuery = "INSERT INTO etudiants (id_utilisateur, niveau, image_profil) 
                                       VALUES (:id_utilisateur, :niveau, :image_profil)";
                $stmt = $sql->prepare($insertStudentQuery);
                $stmt->execute([
                    ':id_utilisateur' => $userId,
                    ':niveau' => $user->getNiveau(),
                    ':image_profil' => $user->getImageProfil(),
                ]);
            } elseif ($user->getRole() === "enseignant") {
                $insertTeacherQuery = "INSERT INTO enseignants (utilisateur_id, qualifications, cv, image) 
                                       VALUES (:utilisateur_id, :qualifications, :cv, :image)";
                $stmt = $sql->prepare($insertTeacherQuery);
                $stmt->execute([
                    ':utilisateur_id' => $userId,
                    ':qualifications' => $user->getQualifications(),
                    ':cv' => $user->getCv(),
                    ':image' => $user->getImage(),
                ]);
            } else {
                $sql->rollBack();
                $response["message"] = "Rôle invalide fourni.";
                Debuggerr::log("Invalid role provided", $response);
                return $response;
            }
            $sql->commit();
            $response["success"] = true;
            $response["message"] = $user->getRole() === "etudiant"
                ? "Étudiant ajouté avec succès !"
                : "Enseignant ajouté avec succès !";
            $response["data"] = ["id_utilisateur" => $userId];
            Debuggerr::log("User added successfully", $response);

            return $response;
        } catch (Exception $e) {
            if (isset($sql) && $sql->inTransaction()) {
                $sql->rollBack();
            }
            Debuggerr::log("Exception in add method", $e->getMessage());
            return ["success" => false, "message" => "Exception: " . $e->getMessage(), "data" => null];
        }
    }
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
                $query = "SELECT t.id_enseignant, t.utilisateur_id, t.qualifications, t.cv, t.image,
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

    public function countAllStudents()
    {
        $conn = config::getConnexion();
        $req = "select count(*) as total from etudiants";
        $stmt = $conn->prepare($req);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result["total"];


    }
    public function countAllTeachers()
    {
        $conn = config::getConnexion();
        $req = "select count(*) as total from enseignants";
        $stmt = $conn->prepare($req);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result["total"];


    }
    // Update a user
    public function showByOrder($role, $field,$order) {
        try {
            Debuggerr::log("Executing showByOrder for role: $role, field: $field");
            $conn = config::getConnexion();
            $normalizedRole = rtrim(strtolower($role), 's');
            if ($normalizedRole === 'etudiant') {
                $query = "SELECT e.id_etudiant, e.id_utilisateur, e.niveau, e.image_profil, 
                             u.nom, u.email, u.numero_telephone, u.role 
                      FROM etudiants e
                      JOIN utilisateurs u ON e.id_utilisateur = u.id
                      ORDER BY $field $order";
            } elseif ($normalizedRole === 'enseignant') {
                $query = "SELECT t.id_enseignant, t.utilisateur_id, t.qualifications, t.cv, t.image,
                             u.nom, u.email, u.numero_telephone
                      FROM enseignants t
                      JOIN utilisateurs u ON t.utilisateur_id = u.id
                      ORDER BY $field $order";
            } else {
                throw new Exception("Invalid role provided: $role. Allowed roles are 'etudiant' or 'enseignant'.");
            }

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
    public function search($search) {
        try {
            $sql = config::getConnexion();
            $query = "
            SELECT 
                u.*, e.* 
            FROM 
                utilisateurs AS u
            LEFT JOIN 
                etudiants AS e 
            ON 
                u.id = e.id_utilisateur
            WHERE 
                u.id LIKE :search 
                OR u.email LIKE :search 
                OR u.nom LIKE :search 
                OR e.id_etudiant LIKE :search 
                OR e.niveau LIKE :search
        ";
            $stmt = $sql->prepare($query);
            $searchTerm = '%' . $search . '%';
            $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            error_log("Error in search method: " . $e->getMessage());
            return [];
        }
    }
    public function searche ($search)
    {
        try {
            $sql = config::getConnexion();
            $query = "SELECT u.*, e.* FROM utilisateurs AS uLEFT JOIN enseignants AS e 
            ON 
                u.id = e.utilisateur_id
            WHERE 
                u.id LIKE :search 
                OR u.email LIKE :search 
                OR u.nom LIKE :search 
                OR e.utilisateur_id LIKE :search 
                OR e.qualifications LIKE :search
        ";
            $stmt = $sql->prepare($query);
            $searchTerm = '%' . $search . '%';
            $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (Exception $e) {
            error_log("Error in search method: " . $e->getMessage());
            return [];
        }
    }
    public function connexion($mail, $mdp)
    {
        try {
            // Step 1: Establish a connection
            $sql = config::getConnexion();

            // Step 2: Prepare the query
            $query = "SELECT * FROM utilisateurs WHERE email = :mail";
            $stmt = $sql->prepare($query);
            $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);

            // Step 3: Execute the query
            $stmt->execute();


            $results = $stmt->fetch(PDO::FETCH_ASSOC);


            if ($results) {

                if (password_verify($mdp, $results['password'])) {


                    $role = $results['role'];
                    if ($role == 'admin') {
                        return "admin";
                    } elseif ($role == 'enseignant') {
                        return "enseignant";
                    } elseif ($role == 'etudiant') {
                        return "etudiant";
                    } else {
                        return "Role inconnu.";
                    }

                } else {
                    return "Mot de passe incorrect.";
                }
            } else {
                // Email not found
                return "Adresse e-mail introuvable.";
            }
        } catch (PDOException $e) {
            // Handle database-related errors
            return "Erreur: " . $e->getMessage();
        }
    }

}

?>

