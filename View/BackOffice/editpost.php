<?php
include '../../controller/PostController.php';

if (isset($_GET['id'])) {
    $postC = new PostController();
    $post = $postC->showPost($_GET['id']); 
} else {
    header("Location: backoffice.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $postC->updatePost(new Post(
        $_POST['post_id'],
        $_POST['title'],
        $_POST['content'],
        new DateTime(), 
        1
    ), $_POST['post_id']);

    header("Location: backoffice.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
</head>
<body>
    <h1>Edit Post</h1>
    
    <form method="POST" action="">
        <input type="hidden" name="post_id" value="<?php echo $post['post']['post_id']; ?>">
        
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo $post['post']['title']; ?>" required><br><br>
        
        <label for="content">Content:</label>
        <textarea id="content" name="content" rows="4" required><?php echo $post['post']['content']; ?></textarea><br><br>

        <button type="submit">Update Post</button>
    </form>

    <script src="backoffice.js"></script>
</body>
</html>
