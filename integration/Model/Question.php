<?php

class Question {
    private ?int $id;
    private ?int $quiz_id;
    private ?string $texte;
    private ?string $type;
    private ?int $points;
    private ?DateTime $temps_limite;

    public function __construct(?int $id, ?int $quiz_id, ?string $texte, ?string $type, ?int $points, ?DateTime $temps_limite) {
        $this->id = $id;
        $this->quiz_id = $quiz_id;
        $this->texte = $texte;
        $this->type = $type;
        $this->points = $points;
        $this->temps_limite = $temps_limite;
    }

    // Getters and Setters
    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getQuizId(): ?int {
        return $this->quiz_id;
    }

    public function setQuizId(?int $quiz_id): void {
        $this->quiz_id = $quiz_id;
    }

    public function getTexte(): ?string {
        return $this->texte;
    }

    public function setTexte(?string $texte): void {
        $this->texte = $texte;
    }

    public function getType(): ?string {
        return $this->type;
    }

    public function setType(?string $type): void {
        $this->type = $type;
    }

    public function getPoints(): ?int {
        return $this->points;
    }

    public function setPoints(?int $points): void {
        $this->points = $points;
    }

    public function getTempsLimite(): ?DateTime {
        return $this->temps_limite;
    }

    public function setTempsLimite(?DateTime $temps_limite): void {
        $this->temps_limite = $temps_limite;
    }

    // Méthode statique pour obtenir les questions par quiz_id
    public static function getQuestionsByQuizId($quizId): array {
        $db = Database::getConnection(); // Utilisation de la méthode de connexion de la classe Database
        $stmt = $db->prepare("SELECT * FROM question WHERE quiz_id = :quiz_id");
        $stmt->bindParam(':quiz_id', $quizId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne toutes les questions sous forme de tableau associatif
    }

    // Méthode pour obtenir une question par son ID
    public static function getQuestionById($id): ?Question {
        $db = Database::getConnection(); // Connexion à la base de données
        $stmt = $db->prepare("SELECT * FROM question WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC); // Récupère la question sous forme de tableau associatif
        if ($data) {
            return new self(
                $data['id'],
                $data['quiz_id'],
                $data['texte'],
                $data['type'],
                (int) $data['points'],
                new DateTime($data['temps_limite']) // Convertir le temps limite en objet DateTime
            );
        }
        return null; // Retourne null si aucune question n'a été trouvée
    }
}

?>


