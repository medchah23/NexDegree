<?php
require_once "../../Controller/ReponseController.php";
require_once "../../phpqrcode/qrlib.php";

if (isset($_GET['id_evaluation'])) {
    $reponseController = new ReponseController();
    $data = $reponseController->qrCodeData($_GET['id_evaluation']);
    if ($data) {
        $max_note = $data[0]["noteMax"];
        $nbr_rep = $data[0]["nbr"];
        $somme = 0;

        foreach ($data as $d) {
            $somme += $d["note"];
        }

        $moyenne = number_format($somme / $nbr_rep, 2);

        $nbr_sup = 0;
        $nbr_inf = 0;

        foreach ($data as $d) {
            if ($d["note"] >= $moyenne) {
                $nbr_sup++;
            } else {
                $nbr_inf++;
            }
        }

        $content = "Evaluation #" . $_GET['id_evaluation'] . "\n"
            . "Max Note possible : " . $max_note . "\n"
            . "NBR participant : " . $nbr_rep . "\n"
            . "Moyenne : " . $moyenne . "\n"
            . "NBR sup moyenne : " . $nbr_sup . "\n"
            . "NBR inf moyenne : " . $nbr_inf;

        $fileName = "evaluation_#" . $_GET['id_evaluation'] . ".png";

        if (ob_get_length()) {
            ob_end_clean();
        }

        header('Content-Type: image/png');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Expires: 0');

        QRcode::png($content, null, QR_ECLEVEL_L, 4);
    } else {
        header("location:EvaluationList.php");
    }
} else {
    header("location:EvaluationList.php");
}
