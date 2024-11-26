<?php
require_once(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/Correction.php');

class CorrectionController
{
    // Ajouter ou mettre à jour une correction pour une évaluation
    public function saveCorrection(Correction $correction): void
    {
        $db = config::getConnexion();

        // Vérifier si une correction existe déjà pour l'évaluation
        $checkSql = "SELECT correctionID FROM correction WHERE evaluationID = :evaluationID";
        $checkQuery = $db->prepare($checkSql);
        $checkQuery->execute(['evaluationID' => $correction->getEvaluationID()]);

        if ($checkQuery->rowCount() > 0) {
            // Si une correction existe, on met à jour
            $sql = "UPDATE correction SET 
                        disponible = :disponible, 
                        score = :score, 
                        filePath = :filePath 
                    WHERE evaluationID = :evaluationID";
        } else {
            // Sinon, on insère une nouvelle correction
            $sql = "INSERT INTO correction (evaluationID, disponible, score, filePath) 
                    VALUES (:evaluationID, :disponible, :score, :filePath)";
        }

        try {
            $query = $db->prepare($sql);
            $query->execute([
                'evaluationID' => $correction->getEvaluationID(),
                'disponible' => $correction->isDisponible() ? 1 : 0,
                'score' => $correction->getScore(),
                'filePath' => $correction->getFilePath()
            ]);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Récupérer une correction par l'ID de l'évaluation
    public function getCorrectionByEvaluationId(int $evaluationID): ?Correction
    {
        $pdo = config::getConnexion();
        try {
            $query = $pdo->prepare("SELECT * FROM correction WHERE evaluationID = :evaluationID");
            $query->execute(['evaluationID' => $evaluationID]);
            $result = $query->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return new Correction(
                    $result['correctionID'],
                    $result['evaluationID'],
                    $result['disponible'],
                    $result['score'],
                    $result['filePath']
                );
            } else {
                return null; // Aucune correction trouvée
            }
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    // Supprimer une correction
    public function deleteCorrection(int $evaluationID): void
    {
        $sql = "DELETE FROM correction WHERE evaluationID = :evaluationID";
        $db = config::getConnexion();

        try {
            $query = $db->prepare($sql);
            $query->execute(['evaluationID' => $evaluationID]);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Afficher une correction par son ID
    public function showCorrection(int $id): ?Correction
    {
        $sql = "SELECT * FROM correction WHERE correctionID = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();

            $correction = $query->fetch(PDO::FETCH_ASSOC);

            if ($correction) {
                return new Correction(
                    $correction['correctionID'],
                    $correction['evaluationID'],
                    $correction['disponible'],
                    $correction['score'],
                    $correction['filePath']
                );
            } else {
                return null; // Aucune correction trouvée
            }
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}
?>
