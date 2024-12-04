

<?php

class Answer {
    public static function getAnswersByQuestionId($questionId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM answer WHERE question_id = :question_id");
        $stmt->bindParam(':question_id', $questionId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}



