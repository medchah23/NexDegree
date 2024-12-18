<?php
include_once(__DIR__ . '/../config.php');
include_once(__DIR__ . '/../Model/comment.php');

class CommentController
{
    public function listComments(): array
    {
        $sql = "SELECT * FROM comments";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function addComment($postId, $content) {
        // Assuming the user_id is static for now
        $user_id = 1; // Or get it from session

        // Create DateTime for created_at field
        $created_at = new DateTime();

        // Create a Comment object
        $comment = new Comment(null, $postId, $user_id, $content, $created_at);

        // Assuming you have a $dbConnection from your DB configuration
        $dbConnection = config::getConnexion();

        // Save the comment to the database
        if ($comment->saveToDatabase($dbConnection)) {
            return true;
        } else {
            throw new Exception("Failed to add comment.");
        }
    }

    public function deleteComment(int $comment_id): void
    {
        $sql = "DELETE FROM comments WHERE comment_id = :comment_id";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);
            $query->execute();
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function showComment(int $comment_id): array
    {
        $sql = "SELECT * FROM comments WHERE comment_id = :comment_id";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function updateComment(Comment $comment, int $comment_id): void
    {
        $sql = "UPDATE comments 
                SET content = :content 
                WHERE comment_id = :comment_id";
        
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->execute([
                'content' => $comment->getContent(),
                'comment_id' => $comment_id
            ]);
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}
?>
