<?php
require_once '../../controller/EvaluationController.php';

if (isset($_GET['evaluationID']) && !empty($_GET['evaluationID'])) {
    $evaluationID = $_GET['evaluationID'];
    $evaluationController = new EvaluationController();
    $evaluation = $evaluationController->getEvaluationById($evaluationID);

    if (!$evaluation) {
        die('Évaluation non trouvée.');
    }
} else {
    die('ID d\'évaluation non fourni.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'évaluation</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Détails de l'évaluation</h1>
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h4>Évaluation ID: <?= htmlspecialchars($evaluation['evaluationID']); ?></h4>
            </div>
            <div class="card-body">
                <p><strong>Matière : </strong><?= htmlspecialchars($evaluation['matiere']); ?></p>
                <p><strong>Durée : </strong><?= htmlspecialchars($evaluation['durée']); ?> minutes</p>
                <p><strong>Note Maximale : </strong><?= htmlspecialchars($evaluation['noteMax']); ?></p>
                <p><strong>Date : </strong><?= htmlspecialchars($evaluation['date']); ?></p>
                <p><strong>Description : </strong><?= nl2br(htmlspecialchars($evaluation['description'])); ?></p>
            </div>
            <div class="card-footer text-center">
                <a href="evaluationList.php" class="btn btn-secondary">Retour à la liste</a>
                <a href="updateEvaluation.php?evaluationID=<?= htmlspecialchars($evaluation['evaluationID']); ?>" class="btn btn-warning">Modifier</a>
                <a href="deleteEvaluation.php?evaluationID=<?= htmlspecialchars($evaluation['evaluationID']); ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette évaluation ?');">Supprimer</a>
            </div>
        </div>
    </div>

    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
