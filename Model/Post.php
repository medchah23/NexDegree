<?php

class Post {
    private ?int $post_id;
    private ?string $title;
    private ?string $content;
    private ?DateTime $created_at;
    private ?int $user_id;

    public function __construct(?int $post_id, ?string $title, ?string $content, ?DateTime $created_at, ?int $user_id) {
        $this->post_id = $post_id;
        $this->title = $title;
        $this->content = $content;
        $this->created_at = $created_at;
        $this->user_id = $user_id;
    }

    public function getPostId(): ?int {
        return $this->post_id;
    }

    public function setPostId(?int $post_id): void {
        $this->post_id = $post_id;
    }

    public function getTitle(): ?string {
        return $this->title;
    }

    public function setTitle(?string $title): void {
        $this->title = $title;
    }

    public function getContent(): ?string {
        return $this->content;
    }

    public function setContent(?string $content): void {
        $this->content = $content;
    }

    public function getCreatedAt(): ?DateTime {
        return $this->created_at;
    }

    public function setCreatedAt(?DateTime $created_at): void {
        $this->created_at = $created_at;
    }

    public function getUserId(): ?int {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): void {
        $this->user_id = $user_id;
    }
}

?>