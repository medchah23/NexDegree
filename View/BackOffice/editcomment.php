<?php
include '../../controller/CommentController.php';

// Check if the comment ID is provided in the URL
if (isset($_GET['id'])) {
    // Create an instance of CommentController
    $commentC = new CommentController();

    // Fetch the comment to be edited using its ID
    $comment = $commentC->showComment((int)$_GET['id']);
} else {
    // If no ID is provided, redirect to the comments page
    header("Location: comments.php");
    exit();
}

// Handle form submission to update the comment
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Update the comment using the CommentController
    $commentC->updateComment(
        new Comment(
            (int)$_POST['comment_id'],  // ID of the comment being updated
            $comment['post_id'],        // Associated post ID (unchanged)
            $comment['user_id'],        // User ID (unchanged)
            $_POST['content'],          // Updated content from the form
            new DateTime($comment['created_at']) // Preserve original creation date
        ),
        (int)$_POST['comment_id'] // The comment ID for updating the specific comment
    );

    // Redirect to the comments page after update
    header("Location: comments.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Comment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Edit Comment</h1>
    
    <form method="POST" action="">
        <!-- Hidden field to store the comment ID for the update -->
        <input type="hidden" name="comment_id" value="<?php echo $comment['comment_id']; ?>">
        
        <label for="content">Content:</label>
        <!-- Textarea for editing the comment content -->
        <textarea id="content" name="content" rows="4" required><?php echo htmlspecialchars($comment['content']); ?></textarea><br><br>

        <!-- Submit button for updating the comment -->
        <button type="submit">Update Comment</button>
    </form>

    <script src="backoffice.js"></script>
</body>
</html>
