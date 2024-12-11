<?php
include_once(__DIR__ . "../../configdb.php");
include_once("debug.php");
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
    public function getUserStatusById($userId){
        $sql = Config::getConnexion();
        $quary = "SELECT statut FROM utilisateurs WHERE id = :id";
        $stmt = $sql->prepare($quary);
        $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch();
        return $user["statut"];
    }
    public function getUserById2($userId)
    {
        $sql = Config::getConnexion();
        $quary = "SELECT u.nom, u.email, u.numero_telephone,u.cree_a,u.statut,u.role, e.image_profil FROM utilisateurs u INNER JOIN etudiants e ON u.id = e.id_utilisateur WHERE u.id = :id";
        $stmt = $sql->prepare($quary);
        $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch();
        return $user;


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
    public function connexion($mail, $mdp)
    {
        try {
            $sql = config::getConnexion();
            $query = "SELECT * FROM utilisateurs WHERE email = :mail";
            $stmt = $sql->prepare($query);
            $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
            $stmt->execute();

            $results = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$results) {
                return "Adresse e-mail non trouvée.";

            }

            $status = $results['statut'];
            $role = $results['role'];
            if ($mdp==$results['mot_de_passe']) {
                return $role;
            } else {
                return "Mot de passe incorrect.";
            }
            $validRoles = ['admin', 'enseignant', 'etudiant'];
            if (!in_array($role, $validRoles)) {
                return "Role non reconnu.";
            }

            if ($status !== 'active') {
                if ($status === 'locked') {
                    return "Votre compte est verrouillé. Veuillez contacter l'administrateur.";
                } elseif ($status === 'banned') {
                    return "Votre compte est banni. Veuillez contacter l'administrateur.";
                } elseif ($status === 'inactive') {
                    return "Votre compte est inactif. Veuillez vérifier votre email pour l'activer.";
                } else {
                    return "Le statut de votre compte est inconnu.";
                }
            }

        } catch (PDOException $e) {
            error_log("Login Error: " . $e->getMessage());
            return "Erreur lors de la connexion.";
        }
    }

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


    public function search($search) {
        try {
            $sql = config::getConnexion();
            $query = " SELECT u.*, e.* FROM utilisateurs AS uLEFT JOIN etudiants AS e ON u.id = e.id_utilisateur WHERE u.id LIKE :search OR u.email LIKE :search OR u.nom LIKE :search OR e.id_etudiant LIKE :search OR e.niveau LIKE :search";
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
    public function searche($search)
    {
        try {
            $sql = config::getConnexion();
            $query = "SELECT u.nom, u.email, u.numero_telephone, e.id_enseignant, e.qualifications, e.image, e.cv FROM utilisateurs AS u LEFT JOIN enseignants AS e ON u.id = e.utilisateur_id WHERE u.nom LIKE :search OR u.email LIKE :search OR u.numero_telephone LIKE :search OR e.id_enseignant LIKE :search OR e.qualifications LIKE :search";
            $stmt = $sql->prepare($query);
            $searchTerm = '%' . $search . '%';
            $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in searche method: " . $e->getMessage());
            return [];
        }
    }


    public function getUserIdByEmail($email)
    {
        $sql = config::getConnexion();
        $query = "SELECT id FROM utilisateurs WHERE email = :email";
        $stmt = $sql->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        if($results){
        return $results['id'];}
        else{
            return -1;
        }


    }

}
?>

