<?php
require_once('../Model/utilisateur.php');           // Path to Model/utilisateur.php
require_once('../Model/etudient.php');              // Path to Model/etudient.php
require_once('../Model/Enseignant.php');            // Path to Model/Enseignant.php
require_once('../configdb.php');                    // Path to configdb.php
class usercontroller{
    function add($user){
        $req = "SELECT * FROM user WHERE email = :email";
        $sql = config::getConnexion();
        $stmt = $sql->prepare($req);
        $stmt->bindParam(':email', $user->getEmail(), PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return false;
        }
        else{
            $req = "INSERT INTO `utilisateur`( `nom`, `email`, `mot_de_passe`, `role`, `statut`) VALUES :nom, :email, :mot_de_passe, :role, :statut)";
            $stmt = $sql->prepare($req);
            $stmt->bindParam(':nom', $user->getNom(), PDO::PARAM_STR);
            $stmt->bindParam(':email', $user->getEmail(), PDO::PARAM_STR);
            $stmt->bindParam(':mot_de_passe', $user->getMotDePasse(), PDO::PARAM_STR);
            $stmt->bindParam(':role', $user->getRole(), PDO::PARAM_STR);
            $stmt->bindParam(':statut', $user->getStatut(), PDO::PARAM_STR);
            $stmt->execute();
            $id=$sql->lastInsertId();
            if($user->getRole() == "etudient"){
                $req ="INSERT INTO `etudiant`(`id_etudiant`, `id_utilisateur`, `niveau`, `image_profil`) VALUES (:id_etudiant, :id_utilisateur, :niveau, :image_profil) ";
                $stmt = $sql->prepare($req);
                $stmt->bindParam(':id_etudiant', $id, PDO::PARAM_INT);
                $stmt->bindParam(':id_utilisateur', $id, PDO::PARAM_INT);
                $stmt->bindParam(':niveau', $niveau, PDO::PARAM_INT);
                $stmt->bindParam(':image_profil', $image_profil, PDO::PARAM_STR);
                $stmt->execute();
            }   if(($stmt->affected_rows != 0)){return true;}
            elseif (
                $user->getRole() == "enseignant"
            ){
                $req = "INSERT INTO `enseignant`(`id_enseignant`, `id_utilisateur`, `qualifications`, `cv`, `id_classe`) VALUES(:id_enseignant, :id_utilisateur, :qualifications, :cv, :id_classe)";
                $stmt = $sql->prepare($req);
                $stmt->bindParam(':id_enseignant', $id, PDO::PARAM_INT);
                $stmt->bindParam(':id_utilisateur', $id, PDO::PARAM_INT);
                $stmt->bindParam(':qualifications', $qualifications, PDO::PARAM_INT);
                $stmt->bindParam(':cv', $cv, PDO::PARAM_STR);
                $stmt->bindParam(':id_classe', $id_classe, PDO::PARAM_INT);
                $stmt->execute();
                if($stmt->affected_rows != 0){
                    return true;
                }
            }
        }

    }
    public function show($role) {
        $req = "SELECT * FROM user where role = :role";
        $sql = config::getConnexion();
        $stmt = $sql->prepare($req);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function showbyorder($role,$order) {
        $req = "SELECT * FROM user where role = :role ORDER BY $order ";
        $sql = config::getConnexion();
        $stmt = $sql->prepare($req);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;


    }
    public function update($user){
        $req = "SELECT * FROM user WHERE email = :email";
        $sql = config::getConnexion();
        $stmt = $sql->prepare($req);
        $stmt->bindParam(':email', $user->getEmail(), PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {

            $updateQuery = "UPDATE user SET 
                        nom = :nom,
                        mot_de_passe = :mot_de_passe,
                        role = :role,
                        statut = :statut
                    WHERE id_utilisateur = :id";
            $stmtUpdate = $sql->prepare($updateQuery);
            $stmtUpdate->bindParam(':nom', $user->getNom(), PDO::PARAM_STR);
            $stmtUpdate->bindParam(':mot_de_passe', $user->getMotDePasse(), PDO::PARAM_STR);
            $stmtUpdate->bindParam(':role', $user->getRole(), PDO::PARAM_STR);
            $stmtUpdate->bindParam(':statut', $user->getStatut(), PDO::PARAM_STR);
            $stmtUpdate->bindParam(':id', $user->getIdUtilisateur(), PDO::PARAM_INT); // Use ID for update
            $stmtUpdate->execute();
            if ($stmtUpdate->rowCount() > 0) {
                return true;  } else {
                return false; }
        } else {            return false;        }
    }
    function delete($id)
        {
            $sql = config::getConnexion();
            try {
                $sql->beginTransaction();
                $checkEtudiant = "SELECT * FROM etudiant WHERE id_utilisateur = :id";
                $stmtCheckEtudiant = $sql->prepare($checkEtudiant);
                $stmtCheckEtudiant->bindParam(':id', $id, PDO::PARAM_INT);
                $stmtCheckEtudiant->execute();
                if ($stmtCheckEtudiant->rowCount() > 0) {
                    $deleteEtudiant = "DELETE FROM etudiant WHERE id_utilisateur = :id";
                    $stmtEtudiant = $sql->prepare($deleteEtudiant);
                    $stmtEtudiant->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmtEtudiant->execute();
                }
                $checkEnseignant = "SELECT * FROM enseignant WHERE id_utilisateur = :id";
                $stmtCheckEnseignant = $sql->prepare($checkEnseignant);
                $stmtCheckEnseignant->bindParam(':id', $id, PDO::PARAM_INT);
                $stmtCheckEnseignant->execute();
                if ($stmtCheckEnseignant->rowCount() > 0) {
                    $deleteEnseignant = "DELETE FROM enseignant WHERE id_utilisateur = :id";
                    $stmtEnseignant = $sql->prepare($deleteEnseignant);
                    $stmtEnseignant->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmtEnseignant->execute();
                }
                $checkUser = "SELECT * FROM user WHERE id_utilisateur = :id";
                $stmtCheckUser = $sql->prepare($checkUser);
                $stmtCheckUser->bindParam(':id', $id, PDO::PARAM_INT);
                $stmtCheckUser->execute();
                if ($stmtCheckUser->rowCount() > 0) {
                    $deleteUser = "DELETE FROM user WHERE id_utilisateur = :id";
                    $stmtDeleteUser = $sql->prepare($deleteUser);
                    $stmtDeleteUser->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmtDeleteUser->execute();
                }
                return true;
            } catch (Exception $e) {
                $sql->rollBack();
                return false;
            }
        }



    }