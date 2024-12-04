<?php
include '../../controller/CommentController.php';
include_once(__DIR__ . '/../../Model/comment.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $commentC = new CommentController();

    // Validate input (Handled by JS, but we'll still check for basic structure)
    if (!empty($_POST['content']) && isset($_POST['post_id']) && is_numeric($_POST['post_id'])) {
        try {
            $content = $_POST['content'];
            $postId = (int)$_POST['post_id']; // Get the post_id from the form

            // Add the comment
            $commentC->addComment($postId, $content);  // Pass both postId and content

            // Redirect to comments page with success message
            header("Location: comments.php?message=Comment%20added%20successfully.&messageType=success");
        } catch (Exception $e) {
            // Redirect with error message
            header("Location: addComment.php?post_id={$_POST['post_id']}&message=" . urlencode($e->getMessage()) . "&messageType=error");
        }
    } else {
        // Redirect back to form with error message
        header("Location: addComment.php?post_id={$_POST['post_id']}&message=Invalid%20input.&messageType=error");
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Comment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .message {
            max-width: 600px;
            margin: 10px auto;
            padding: 10px;
            border-radius: 5px;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
    <script>
        // JavaScript validation for the comment form
        function validateCommentForm(event) {
            const commentContent = document.getElementById('content');
            const content = commentContent.value.trim();

            // Validation for Content: It should not be empty and must be at least 10 characters long
            if (content === "") {
                alert("Content is required.");
                event.preventDefault(); // Prevent form submission
                commentContent.focus();
                return false;
            }
            if (content.length < 10) {
                alert("Content must be at least 10 characters long.");
                event.preventDefault();
                commentContent.focus();
                return false;
            }

            // If all validations pass, submit the form
            return true;
        }

        window.addEventListener('DOMContentLoaded', function () {
            const commentForm = document.querySelector('form');
            if (commentForm) {
                commentForm.addEventListener('submit', validateCommentForm);
            }
        });
    </script>
</head>
<body>
    <h1>Add a New Comment</h1>
    
    <!-- Display success or error messages -->
    <?php if (isset($_GET['message'])): ?>
        <div class="message <?= htmlspecialchars($_GET['messageType'] ?? 'error') ?>">
            <?= htmlspecialchars($_GET['message']) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="addcomment.php">
        <input type="hidden" name="post_id" value="<?= htmlspecialchars($_GET['post_id'] ?? '') ?>">

        <label for="content">Content:</label>
        <textarea id="content" name="content" rows="4"></textarea><br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
