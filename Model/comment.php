<?php
include_once(__DIR__ . '/../Model/comment.php');
class comment {
    private ?int $comment_id;
    private ?int $post_id;
    private ?int $user_id;
    private ?string $content;
    private ?DateTime $created_at;

    // Constructor to initialize the properties
    public function __construct(?int $comment_id, ?int $post_id, ?int $user_id, ?string $content, ?DateTime $created_at) {
        if (!empty($comment_id)) {
            $this->comment_id = $comment_id;
        }
        $this->post_id = $post_id;
        $this->user_id = $user_id;
        $this->content = $content;
        $this->created_at = $created_at;
    }
    public function saveToDatabase($dbConnection) {
        echo($this->created_at->format('Y-m-d H:i:s'));

        $query = "INSERT INTO comments (post_id, user_id, content, created_at) VALUES (:post_id, :user_id, :content, :created_at)";
        $stmt = $dbConnection->prepare($query);

        // Bind the parameters
        $stmt->bindParam(':post_id', $this->post_id);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':created_at', $this->created_at->format('Y-m-d H:i:s'));

        return $stmt->execute(); // Execute and return the success or failure of the query
    }
    // Getter and Setter for comment_id
    public function getcommentId(): ?int {
        return $this->comment_id;
    }

    public function setcommentId(?int $comment_id): void {
        $this->comment_id = $comment_id;
    }

    // Getter and Setter for post_id
    public function getPostId(): ?int {
        return $this->post_id;
    }

    public function setPostId(?int $post_id): void {
        $this->post_id = $post_id;
    }

    // Getter and Setter for user_id
    public function getUserId(): ?int {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): void {
        $this->user_id = $user_id;
    }

    // Getter and Setter for content
    public function getContent(): ?string {
        return $this->content;
    }

    public function setContent(?string $content): void {
        $this->content = $content;
    }

    // Getter and Setter for created_at
    public function getCreatedAt(): ?DateTime {
        return $this->created_at;
    }

    public function setCreatedAt(?DateTime $created_at): void {
        $this->created_at = $created_at;
    }
}

?>
