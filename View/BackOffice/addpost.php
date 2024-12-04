<?php
include '../../controller/PostController.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $postC = new PostController();

    if (!empty($_POST['title']) && !empty($_POST['content'])) {
        $post = new Post(
            null, 
            $_POST['title'],
            $_POST['content'],
            new DateTime(), 
            1 
        );
        $postC->addPost($post);
        header("Location: ../backoffice/backoffice.php?message=Post%20added%20successfully.&messageType=success");
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Post</title>
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
        function validatePostForm(event) {
            const postTitle = document.getElementById('postTitle');
            const postContent = document.getElementById('postContent');
            
            let title = postTitle.value.trim();
            let content = postContent.value.trim();

            
            if (title === "") {
                alert("Title is required.");
                event.preventDefault(); // Prevent form submission
                postTitle.focus();
                return false;
            }
            if (title.length < 5) {
                alert("Title must be at least 5 characters long.");
                event.preventDefault();
                postTitle.focus();
                return false;
            }

            // Validation for Content: It should not be empty
            if (content === "") {
                alert("Content is required.");
                event.preventDefault(); // Prevent form submission
                postContent.focus();
                return false;
            }
            if (content.length < 10) {
                alert("Content must be at least 10 characters long.");
                event.preventDefault();
                postContent.focus();
                return false;
            }

            // If all validations pass, submit the form
            return true;
        }

        window.addEventListener('DOMContentLoaded', function () {
            const postForm = document.querySelector('#postForm form');
            if (postForm) {
                postForm.addEventListener('submit', validatePostForm);
            }
        });
    </script>
</head>
<body>
    <h1>Add a New Post</h1>
    
    <!-- Display success or error messages -->
    <?php if (isset($_GET['message'])): ?>
        <div class="message <?= htmlspecialchars($_GET['messageType'] ?? 'error') ?>">
            <?= htmlspecialchars($_GET['message']) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" ><br><br>
        
        <label for="content">Content:</label>
        <textarea id="content" name="content" rows="4" ></textarea><br><br>

        <button type="submit">Submit</button>
    </form>

    <script src="backoffice.js"></script>
</body>
</html>
