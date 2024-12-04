<?php
include "../../Model/session.php";
session_start();
if (isset($_SESSION['user_token'])) {
    $session = new Session();
    $session->destroySession($_SESSION['user_token']);
    session_unset();
    session_destroy();header("Location: html/sign_in.html");
    exit();
} else {header("Location: html/sign_in.html");
    exit();
}
?>
