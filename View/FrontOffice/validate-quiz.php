<?php
// Assuming you've already established the database connection in Database.php
include_once(__DIR__ . '/../../config.php');
include '../../Model/Quiz.php';
include '../../Model/Question.php';
include '../../Model/Answer.php';

$quizId = $_GET['id'] ?? 0;

if (!$quizId || !is_numeric($quizId)) {
    echo "ID de quiz invalide.";
    exit;
}

$db = config::getConnexion();

// Fetch the quiz questions and answers
$query = "SELECT 
            q.id AS question_id, 
            q.texte AS question_text, 
            q.points AS question_points, 
            q.type AS question_type, 
            a.id AS answer_id, 
            a.texte AS answer_text, 
            a.correct AS is_correct
          FROM question q
          LEFT JOIN answer a ON q.id = a.question_id
          WHERE q.quiz_id = :quizId";

$stmt = $db->prepare($query);
$stmt->bindParam(':quizId', $quizId, PDO::PARAM_INT);
$stmt->execute();

$questions = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $questions[$row['question_id']]['question_text'] = $row['question_text'];
    $questions[$row['question_id']]['points'] = $row['question_points'];
    $questions[$row['question_id']]['type'] = $row['question_type'];
    $questions[$row['question_id']]['answers'][] = [
        'answer_id' => $row['answer_id'],
        'answer_text' => $row['answer_text'],
        'is_correct' => $row['is_correct']
    ];
}

// Calculate the score based on the user's answers
$totalScore = 0;
foreach ($_POST['answer'] as $questionId => $userAnswer) {
    $question = $questions[$questionId];
    
    // Check if the answer is correct
    foreach ($question['answers'] as $answer) {
        if ((is_array($userAnswer) && in_array($answer['answer_id'], $userAnswer)) || $userAnswer == $answer['answer_id']) {
            if ($answer['is_correct']) {
                $totalScore += $question['points'];
            }
        }
    }
}

// Determine an encouraging message based on the score
$encouragingMessage = '';
if ($totalScore == 0) {
    $encouragingMessage = 'Bonne chance la prochaine fois!';
} elseif ($totalScore <= 50) {
    $encouragingMessage = 'Continuez à vous entraîner, vous allez y arriver!';
} elseif ($totalScore <= 75) {
    $encouragingMessage = 'Bien joué, vous êtes sur la bonne voie!';
} else {
    $encouragingMessage = 'Félicitations, vous avez réussi avec brio!';
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Votre Score</title>
    <link href="img/icon.png" rel="icon">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link href="img/favicon.ico" rel="icon" />
    <link
      href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
      rel="stylesheet"
    />
    <link href="css/style.css" rel="stylesheet" />
  </head>
  <body>
    <div class="container mt-5 text-center">
      <h1>Votre Score</h1>
      <p>Vous avez obtenu un score de : <?= $totalScore ?> points.</p>
      <p><?= $encouragingMessage ?></p>
      <a href="view-quiz.php?id=<?= $quizId ?>" class="btn btn-primary">Reprendre le quiz</a>
    </div>
  </body>
</html>


