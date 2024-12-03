<?php
require_once "../../Controller/ReponseController.php";

if(
    isset($_POST['question1']) && isset($_POST['question2']) && isset($_POST['question3'])
    && isset($_POST['question4']) && isset($_POST['question5']) && isset($_POST['idEvaluation']) && isset($_POST['idUser'])
) {
    $reponseController = new ReponseController();
    $reponse = new Reponse(
        0,$_POST['question1'],
        $_POST['question2'],
        $_POST['question3'],$_POST['question4'],$_POST['question5'],
        $_POST['idEvaluation'],$_POST['idUser']
    );
    $reponseController->addReponse($reponse);
    header("Location:ListeTest.php");
}