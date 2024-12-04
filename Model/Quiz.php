<?php

class Quiz {
    private ?int $id;
    private ?string $title;
    private ?string $description;
    private ?string $category;
    private ?DateTime $created_at;

    // Constructor
    public function __construct(?int $id, ?string $title, ?string $description, ?string $category, ?DateTime $created_at) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->category = $category;
        $this->created_at = $created_at;
    }

    // Getters and Setters

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getTitle(): ?string {
        return $this->title;
    }

    public function setTitle(?string $title): void {
        $this->title = $title;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(?string $description): void {
        $this->description = $description;
    }

    public function getCategory(): ?string {
        return $this->category;
    }

    public function setCategory(?string $category): void {
        $this->category = $category;
    }

    public function getCreatedAt(): ?DateTime {
        return $this->created_at;
    }

    public function setCreatedAt(?DateTime $created_at): void {
        $this->created_at = $created_at;
    }
}

?>
