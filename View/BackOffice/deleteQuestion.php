<?php 
// Inclure la classe config pour obtenir la connexion à la base de données
include(__DIR__ . '/../../config.php');// Assurez-vous que ce fichier contient les informations de connexion à votre base de données

// Vérifier si l'id de la question est passé via GET
if (isset($_GET['id'])) {
    $questionId = $_GET['id'];
    
    // Requête SQL pour supprimer la question
    $sql = "DELETE FROM question WHERE id = :id";
    
    // Préparer la requête avec la connexion PDO obtenue via la méthode statique
    $stmt = config::getConnexion()->prepare($sql);
    
    // Lier l'id à la requête
    $stmt->bindParam(':id', $questionId, PDO::PARAM_INT);
    
    // Exécuter la requête
    if ($stmt->execute()) {
        echo "La question a été supprimée avec succès.";
        header('Location:quizList.php');
        
    } else {
        echo "Une erreur est survenue lors de la suppression de la question.";
    }
} else {
    echo "Aucun ID de question fourni.";
}
?>



