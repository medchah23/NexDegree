<?php
require_once "../../Controller/ReponseController.php";

if(isset($_GET['id_reponse'])){
    $reponseController = new ReponseController();
    $reponseController->deleteReponse($_GET['id_reponse']);
    header("Location:index.php");
} else
    header("Location:index.php");