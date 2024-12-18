<?php
include '../../controller/PostController.php';

if (isset($_GET['id'])) {
    $postId = $_GET['id'];
    $postC = new PostController();
    $postC->deletePost($postId); 
    
    header("Location: posts.php");
    exit();
}
?>
