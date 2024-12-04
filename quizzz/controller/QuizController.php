<?php
include(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/Quiz.php');

class QuizController
{
    public function listQuizzes()
    {
        $sql = "SELECT * FROM quiz";
        $db = config::getConnexion();
        try {
            $list = $db->query($sql);
            return $list;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }
    public function getAllQuizzes() {
        $db = config::getConnexion();
        $sql = "SELECT * FROM quiz";
        try {
            $list = $db->query($sql);
            return $list->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }
    function deleteQuiz($id)
    {
        $sql = "DELETE FROM quiz WHERE id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    function addQuiz($quiz)
    {
        $sql = "INSERT INTO quiz (title, description, category, created_at) VALUES (:title, :description, :category, :created_at)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'title' => $quiz->getTitle(),
                'description' => $quiz->getDescription(),
                'category' => $quiz->getCategory(),
                'created_at' => $quiz->getCreatedAt()->format('Y-m-d')
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function updateQuiz($quiz, $id)
    {
        try {
            // Débogage : vérifier les informations avant de lancer la requête
            echo "Updating quiz with ID: " . $id . "<br>";
            echo "Title: " . $quiz->getTitle() . "<br>";
            echo "Description: " . $quiz->getDescription() . "<br>";
            echo "Category: " . $quiz->getCategory() . "<br>";
            echo "Created At: " . $quiz->getCreatedAt()->format('Y-m-d') . "<br>";
    
            // Connexion à la base de données
            $db = config::getConnexion();
    
            $query = $db->prepare(
                'UPDATE quiz SET 
                    title = :title,
                    description = :description,
                    category = :category,
                    created_at = :created_at
                WHERE id = :id'
            );
    
            // Exécution de la requête avec les paramètres
            $query->execute([
                'id' => $id,
                'title' => $quiz->getTitle(),
                'description' => $quiz->getDescription(),
                'category' => $quiz->getCategory(),
                'created_at' => $quiz->getCreatedAt()->format('Y-m-d')
            ]);
    
            // Vérifier combien de lignes ont été mises à jour
            $rowsAffected = $query->rowCount();
            echo $rowsAffected . " records UPDATED successfully<br>";
    
            if ($rowsAffected == 0) {
                echo "Aucune ligne n'a été mise à jour. L'ID est-il correct ?<br>";
            }
        } catch (PDOException $e) {
            // Si une exception se produit, afficher l'erreur
            echo "Erreur de requête SQL : " . $e->getMessage() . "<br>";
            echo "Requête SQL : " . $query->queryString . "<br>";
        }
    }
    
    function showQuiz($id)
{
    $sql = "SELECT * FROM quiz WHERE id = :id";
    $db = config::getConnexion();
    try {
        $query = $db->prepare($sql);
        $query->execute(['id' => $id]);

        $quizData = $query->fetch();
        
        // Si le quiz existe, créer un objet Quiz et le retourner
        if ($quizData) {
            return new Quiz(
                $quizData['id'], 
                $quizData['title'], 
                $quizData['description'], 
                $quizData['category'], 
                new DateTime($quizData['created_at'])  // Assurez-vous que 'created_at' est bien au format acceptable pour DateTime
            );
        }
        
        return null; // Si aucun quiz trouvé, retourner null
        
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}


    
}
?>
