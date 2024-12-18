<?php
include '../../controller/CommentController.php';

if (isset($_GET['id'])) {
    $commentId = $_GET['id'];

    // Instantiate the CommentController
    $commentC = new CommentController();

    // Delete the comment
    $commentC->deleteComment($commentId);

    // Redirect to comments management page
    header("Location: comments.php");
    exit();
}
?>
