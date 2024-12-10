<?php
require_once "../../Controller/ReponseController.php";

if(isset($_GET['id_reponse'])){
    $reponseController = new ReponseController();
    $reponseController->deleteReponse($_GET['id_reponse']);
    header("Location:ListeTest.php");
} else
    header("Location:ListeTest.php");