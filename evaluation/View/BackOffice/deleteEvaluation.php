<?php
include '../../controller/EvaluationController.php';
$evaluationController = new EvaluationController();
$evaluationController->deleteEvaluation($_GET["evaluationID"]);
header('Location:EvaluationList.php');


?>
