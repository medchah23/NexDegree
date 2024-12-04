<?php
include_once(__DIR__ . '/../model/Database.php');
include(__DIR__ . '/../Model/Question.php');

class QuestionController
{
    // Liste des questions
    public function listQuestions()
    {
        $sql = "SELECT * FROM question"; // Utiliser le nom correct de la table
        $db = Database::getConnection(); // Utiliser Database::getConnection() pour obtenir la connexion
        try {
            $list = $db->query($sql);
            return $list->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Suppression d'une question par ID
    public function deleteQuestion($id)
    {
        $sql = "DELETE FROM question WHERE id = :id"; // Assurez-vous que la table est "question"
        $db = Database::getConnection();  // Utilisez Database::getConnection()
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Ajout d'une nouvelle question
    public function addQuestion($question)
    {
        $db = Database::getConnection();  // Utilisez Database::getConnection()
        $sql = "INSERT INTO question (quiz_id, texte, type, points, temps_limite) VALUES (:quiz_id, :texte, :type, :points, :temps_limite)";
        $query = $db->prepare($sql);
        $query->bindValue(':quiz_id', $question->getQuizId());
        $query->bindValue(':texte', $question->getTexte());
        $query->bindValue(':type', $question->getType());
        $query->bindValue(':points', $question->getPoints());
        $query->bindValue(':temps_limite', $question->getTempsLimite()->format('Y-m-d H:i:s'));  // Formatage du temps limite
        $query->execute();
    }

    // Constructeur pour la connexion à la base de données (optionnel si getConnection() dans Database)
    // Vous n'avez pas besoin de ce constructeur si vous utilisez Database::getConnection() dans toutes les méthodes
    /*public function __construct() {
        try {
            $this->db = new PDO("mysql:host=localhost;dbname=qyy", "root", "");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }*/

    // Méthode pour récupérer une question par son ID
    public function getQuestionById($id)
    {
        $sql = "SELECT * FROM question WHERE id = :id"; // Assurez-vous que la table est "question"
        $db = Database::getConnection();  // Utilisez Database::getConnection()
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Méthode pour mettre à jour une question
    public function updateQuestion($question, $id)
    {
        $sql = "UPDATE question SET texte = :texte, type = :type, points = :points, temps_limite = :temps_limite, quiz_id = :quiz_id WHERE id = :id";
        $db = Database::getConnection();  
        try {
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':texte', $question->getTexte()); // Remplace getText() par getTexte()
            $stmt->bindParam(':type', $question->getType());
            $stmt->bindParam(':points', $question->getPoints());
            $stmt->bindParam(':temps_limite', $question->getTempsLimite()->format('Y-m-d H:i:s')); // Assurez-vous que temps_limite est un objet DateTime
            $stmt->bindParam(':quiz_id', $question->getQuizId());
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    

    // Afficher une question par ID
    public function showQuestion($id)
    {
        $sql = "SELECT * FROM question WHERE id = :id"; // Utilisez "question" ici aussi
        $db = Database::getConnection();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}
?>



