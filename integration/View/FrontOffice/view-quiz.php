<?php
include_once(__DIR__ . '/../../config.php');
include '../../Model/Quiz.php';
include '../../Model/Question.php';
include '../../Model/Answer.php';

// Validation de l'ID du quiz
$quizId = $_GET['id'] ?? 0;

if (!$quizId || !is_numeric($quizId)) {
    echo "ID de quiz invalide.";
    exit;
}

$db = config::getConnexion();

// Requête pour récupérer les questions et leurs réponses associées
$query = "SELECT 
            q.id AS question_id, 
            q.texte AS question_text, 
            q.points AS question_points, 
            q.type AS question_type, 
            a.id AS answer_id, 
            a.texte AS answer_text 
          FROM question q 
          LEFT JOIN answer a ON q.id = a.question_id 
          WHERE q.quiz_id = :quizId";

$stmt = $db->prepare($query);
$stmt->bindParam(':quizId', $quizId, PDO::PARAM_INT);
$stmt->execute();

// Construction de la structure des questions
$questions = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $questions[$row['question_id']]['question_text'] = $row['question_text'];
    $questions[$row['question_id']]['points'] = $row['question_points'];
    $questions[$row['question_id']]['type'] = $row['question_type'];
    if ($row['answer_id']) {
        $questions[$row['question_id']]['answers'][] = [
            'answer_id' => $row['answer_id'],
            'answer_text' => $row['answer_text']
        ];
    } else {
        $questions[$row['question_id']]['answers'] = [];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Quiz Details</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link href="img/icon.png" rel="icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito&display=swap"
        rel="stylesheet"
    />
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
        rel="stylesheet"
    />
    <link href="css/style.css" rel="stylesheet" />
    <style>
        h1.text-center { color: #2E86C1; }
        .card-header h3 { color: #D35400; }
        .card-header p { color: black; }
    </style>
    <script>
        // Fonction pour valider les champs input
        function validateInputs(event) {
            const inputs = document.querySelectorAll('input[type="text"][data-validate="number"]');
            for (const input of inputs) {
                const value = input.value.trim();

                // Vérifie que la valeur est un nombre entre 0 et 9
                if (!/^[0-9]$/.test(value)) {
                    alert("Veuillez saisir un nombre valide entre 0 et 9 pour : " + input.name);
                    input.focus();
                    event.preventDefault();
                    return false;
                }
            }
            return true;
        }

        // Ajout d'un écouteur sur le formulaire
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', validateInputs);
            }
        });
    </script>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Let’s dive into your skills!</h1>
    <div class="d-flex justify-content-center">
        <img class="img-fluid mt-5" src="img/a.png" alt="" />
    </div>
    <div class="row">
        <?php if (empty($questions)): ?>
            <div class="col-12">
                <p class="text-center">Aucune question trouvée pour ce quiz.</p>
            </div>
        <?php else: ?>
            <form method="POST" action="validate-ques.php?id=<?= $quizId ?>" class="col-12">
    <?php foreach ($questions as $questionId => $question): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h3>
                    <?= htmlspecialchars($question['question_text']) ?> 
                    (Points: <?= htmlspecialchars($question['points']) ?>)
                </h3>
                <p>
                    <strong>Type de question :</strong> 
                    <?= $question['type'] === 'multiple_choice' 
                        ? 'Choix unique' 
                        : ($question['type'] === 'true_false' 
                            ? 'Vrai ou Faux' 
                            : ($question['type'] === 'input' 
                                ? 'Réponse ouverte' 
                                : 'Choix multiples')) ?>
                </p>
            </div>
            <div class="card-body">
                <?php if ($question['type'] === 'multiple_choice'): ?>
                    <?php foreach ($question['answers'] as $answer): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answer[<?= $questionId ?>]" value="<?= $answer['answer_id'] ?>" id="answer_<?= $answer['answer_id'] ?>">
                            <label class="form-check-label" for="answer_<?= $answer['answer_id'] ?>">
                                <?= htmlspecialchars($answer['answer_text']) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                <?php elseif ($question['type'] === 'multiple'): ?>
                    <?php foreach ($question['answers'] as $answer): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="answer[<?= $questionId ?>][]" value="<?= $answer['answer_id'] ?>" id="answer_<?= $answer['answer_id'] ?>">
                            <label class="form-check-label" for="answer_<?= $answer['answer_id'] ?>">
                                <?= htmlspecialchars($answer['answer_text']) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                <?php elseif ($question['type'] === 'true_false'): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answer[<?= $questionId ?>]" value="true" id="answer_true_<?= $questionId ?>">
                        <label class="form-check-label" for="answer_true_<?= $questionId ?>">Vrai</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answer[<?= $questionId ?>]" value="false" id="answer_false_<?= $questionId ?>">
                        <label class="form-check-label" for="answer_false_<?= $questionId ?>">Faux</label>
                    </div>
                <?php elseif ($question['type'] === 'input'): ?>
                    <div class="form-group">
                        <label for="answer_input_<?= $questionId ?>">Votre réponse  :</label>
                        <input type="text" class="form-control" name="answer[<?= $questionId ?>]" id="answer_input_<?= $questionId ?>" placeholder="Saisissez votre reponse " >
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Champ caché pour transmettre l'ID du quiz -->
    <input type="hidden" name="quizId" value="<?= $quizId ?>">

    <!-- Bouton Soumettre -->
    <button type="submit" class="btn btn-primary">Soumettre</button>
                    
</form>

        <?php endif; ?>
    </div>
</div>
</body>
</html>
