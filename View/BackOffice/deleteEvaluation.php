<?php
include '../../Controller/EvaluationController.php';

    $evalc=new EvaluationController();
    $evalc->deleteEvaluation($_GET['id']);
    header('Location:EvaluationList.php');
?>