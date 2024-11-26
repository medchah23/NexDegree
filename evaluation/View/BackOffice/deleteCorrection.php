<?php
include '../../controller/CorrectionController.php';  // Assurez-vous que CorrectionController est le bon fichier
$correctionController = new CorrectionController();  // Remplace EvaluationController par CorrectionController
$correctionController->deleteCorrection($_GET["correctionID"]);  // Remplace 'evaluationID' par 'correctionID'
header('Location:CorrectionList.php');  // Redirige vers la liste des corrections
?>
