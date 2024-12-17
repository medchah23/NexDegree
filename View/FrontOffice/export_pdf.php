<?php
require '../../Libraries/fpdf186 (3)\fpdf.php'; // Assurez-vous que FPDF est inclus dans votre projet
include '../../Model/Quiz.php';
include '../../config.php';
include '../../Model/Question.php';
include '../../Model/Answer.php';

// Validation de l'ID du quiz
$quizId = $_GET['id'] ?? 0;
if (!$quizId || !is_numeric($quizId)) {
    die("ID de quiz invalide.");
}

$db = config::getConnexion();

// Requête pour récupérer les questions et réponses
$query = "SELECT 
            q.texte AS question_text, 
            q.points AS question_points, 
            q.type AS question_type, 
            a.texte AS answer_text 
          FROM question q 
          LEFT JOIN answer a ON q.id = a.question_id 
          WHERE q.quiz_id = :quizId";

$stmt = $db->prepare($query);
$stmt->bindParam(':quizId', $quizId, PDO::PARAM_INT);
$stmt->execute();

$questions = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $questions[$row['question_text']]['points'] = $row['question_points'];
    $questions[$row['question_text']]['type'] = $row['question_type'];
    if ($row['answer_text']) {
        $questions[$row['question_text']]['answers'][] = $row['answer_text'];
    } else {
        $questions[$row['question_text']]['answers'] = [];
    }
}

// Génération du PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, "Questions du Quiz ID: $quizId", 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 12);
foreach ($questions as $questionText => $details) {
    $pdf->MultiCell(0, 10, "Question : $questionText (Points : {$details['points']})");
    $pdf->MultiCell(0, 10, "Type : " . ucfirst($details['type']));

    if (!empty($details['answers'])) {
        $pdf->MultiCell(0, 10, "Reponses possibles :");
        foreach ($details['answers'] as $answer) {
            $pdf->Cell(10);
            $pdf->MultiCell(0, 10, "- $answer");
        }
    }
    $pdf->Ln(5);
}

$pdf->Output("D", "Quiz_$quizId.pdf"); // Télécharge le fichier PDF
exit;
?>

