<?php

include_once('../models/Database.php');
include_once('../models/Quiz.php');

// Récupérer tous les quiz
$db = Database::getConnection();
$stmt = $db->prepare("SELECT * FROM quiz");
$stmt->execute();
$quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <title>Liste des Quiz</title>
    <link href="img/icon.png" rel="icon">
</head>
<body>
    <h1>Liste des Quiz</h1>
    <ul>
        <?php foreach ($quizzes as $quiz): ?>
            <li>
                <h2><?= htmlspecialchars($quiz['title']) ?></h2>
                <p><?= htmlspecialchars($quiz['description']) ?></p>
                <a href="view-quiz.php?id=<?= $quiz['id'] ?>" class="btn btn-primary">Join Quiz</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>




