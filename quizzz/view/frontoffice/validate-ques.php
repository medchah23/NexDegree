<?php
include '../../Model/Database.php';
include '../../Model/Answer.php';

$db = Database::getConnection();
$quizId = $_POST['quizId'] ?? 0;
$userAnswers = $_POST['answer'] ?? [];

// Récupération des réponses correctes et des points par question
$query = "SELECT q.id AS question_id, q.points, a.id AS answer_id, a.is_correct 
          FROM question q
          JOIN answer a ON q.id = a.question_id
          WHERE q.quiz_id = :quizId";
$stmt = $db->prepare($query);
$stmt->bindParam(':quizId', $quizId, PDO::PARAM_INT);
$stmt->execute();

$correctAnswers = [];
$questionPoints = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $questionId = $row['question_id'];
    $answerId = $row['answer_id'];

    // Stocker les réponses correctes
    if ($row['is_correct']) {
        $correctAnswers[$questionId][] = $answerId;
    }

    // Stocker les points par question
    $questionPoints[$questionId] = $row['points'];
}

// Calcul du score
$score = 0;
$totalPoints = array_sum($questionPoints); // Somme des points possibles

// Comparaison des réponses de l'utilisateur avec les réponses correctes
foreach ($userAnswers as $questionId => $answers) {
    if (!is_array($answers)) {
        $answers = [$answers]; // Convertir en tableau pour les questions à choix unique
    }

    // Vérifier si les réponses utilisateur correspondent exactement aux réponses correctes
    if (isset($correctAnswers[$questionId]) && !array_diff($answers, $correctAnswers[$questionId])) {
        $score += $questionPoints[$questionId];
    }
}

// Rediriger vers la page de résultats avec le score, les points totaux et l'ID du quiz
header("Location: result.php?score=$score&totalPoints=$totalPoints&quizId=$quizId");
exit;



