<?php
include_once(__DIR__ . '/../../config.php');

$db = config::getConnexion();
$quiz_id = $_POST['quiz_id'];
$userAnswers = $_POST['answer'];

$totalPoints = 0;
$score = 0;

// Parcourir chaque question et vérifier les réponses
foreach ($userAnswers as $question_id => $answer) {
    // Récupérer les détails de la question
    $questionQuery = $db->prepare("SELECT * FROM question WHERE id = :id");
    $questionQuery->execute(['id' => $question_id]);
    $question = $questionQuery->fetch(PDO::FETCH_ASSOC);

    if ($question['type'] === 'multiple_choice') {
        // Vérifier si la réponse est correcte
        $answerQuery = $db->prepare("SELECT * FROM answer WHERE id = :id AND is_correct = 1");
        $answerQuery->execute(['id' => $answer]);
        $correctAnswer = $answerQuery->fetch(PDO::FETCH_ASSOC);

        if ($correctAnswer) {
            $score += $question['points'];
        }
    } elseif ($question['type'] === 'text' || $question['type'] === 'numeric') {
        // Vérifier la réponse textuelle ou numérique
        $correctAnswerQuery = $db->prepare("SELECT * FROM answer WHERE question_id = :question_id AND is_correct = 1");
        $correctAnswerQuery->execute(['question_id' => $question_id]);
        $correctAnswer = $correctAnswerQuery->fetch(PDO::FETCH_ASSOC);

        if (strcasecmp($correctAnswer['texte'], $answer) == 0) {
            $score += $question['points'];
        }
    }
    $totalPoints += $question['points'];
}

// Calcul du pourcentage
$percentage = ($totalPoints > 0) ? ($score / $totalPoints) * 100 : 0;

// Afficher les résultats
echo "<h1>Résultats pour le Quiz ID: " . htmlspecialchars($quiz_id) . "</h1>";
echo "<p>Score: $score / $totalPoints</p>";
echo "<p>Pourcentage: $percentage%</p>";
?>
