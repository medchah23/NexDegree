<?php

class StudentController
{
    public function search($search)
    {
        try {
            $sql = config::getConnexion();
            $query = "SELECT u.*, e.* 
                      FROM utilisateurs AS u 
                      LEFT JOIN etudiants AS e ON u.id = e.id_utilisateur 
                      WHERE u.id LIKE :search 
                         OR u.email LIKE :search 
                         OR u.nom LIKE :search 
                         OR e.id_etudiant LIKE :search 
                         OR e.niveau LIKE :search";
            $stmt = $sql->prepare($query);
            $searchTerm = '%' . $search . '%';
            $stmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in search method: " . $e->getMessage());
            return [];
        }
    }

    public function getEtudientsByid($userId)
    {
        try {
            $sql = config::getConnexion();
            $query = "SELECT u.*, e.* 
                      FROM utilisateurs u 
                      INNER JOIN etudiants e ON u.id = e.id_utilisateur 
                      WHERE e.id_etudiant = :id";
            $stmt = $sql->prepare($query);
            $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in getEtudientsByid method: " . $e->getMessage());
            return null;
        }
    }

    public function countAllStudents()
    {
        try {
            $conn = config::getConnexion();
            $query = "SELECT COUNT(*) as total FROM etudiants";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result["total"];
        } catch (Exception $e) {
            error_log("Error in countAllStudents method: " . $e->getMessage());
            return 0;
        }
    }

    public function ShowStudentsByOrder($order, $fields, $perPage, $offset)
    {
        try {


            $sql = config::getConnexion();
            $query = "SELECT e.id_etudiant, e.id_utilisateur, e.niveau, e.image_profil, 
                             u.nom, u.email, u.numero_telephone, u.role 
                      FROM etudiants e
                      JOIN utilisateurs u ON e.id_utilisateur = u.id
                      ORDER BY $fields $order
                  LIMIT :perPage OFFSET :offset";
            $stmt = $sql->prepare($query);
            $stmt->bindValue(':perPage', (int)$perPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error in ShowStudentsByOrder method: " . $e->getMessage());
            return [];
        }
    }

}
?>
