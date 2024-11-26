<?php

include(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/chapitre.php');

class chapitre_controller 

{
    public function show_all_chapitre() {
        $sql = "SELECT * FROM chapitre"; 
        $db = config::getConnexion();
        
        try {
            $chapitres = $db->query($sql);
            return $chapitres;
        } catch (Exception $e) {
            die("Error show_all_chapitre: " . $e->getMessage());
        }
    }
    
    

     function delete_chapitre($id_chapitre)
    {
        $sql = 'DELETE FROM chapitre WHERE id_chapitre=:id_chapitre';
        
        $db = config::getConnexion();
        $req= $db->prepare($sql);
        $req->bindValue(':id_chapitre',$id_chapitre);
        try {
            $req->execute();
        }catch (Exception $e) {
            die('Error Delete_chapitre'. $e->getMessage());
        }
        
    }


    
   
    public function add_chapitre($chapitre) {
        $db = config::getConnexion();
        $sql = "INSERT INTO chapitre (id_matiere, titre, contenu, date_debut, duree, objectif, activite, res_supp, evaluation_incluse, type_de_evaluation)
                VALUES (:id_matiere, :titre, :contenu, :date_debut, :duree, :objectif, :activite, :res_supp, :evaluation_incluse, :type_de_evaluation)";
        $stmt = $db->prepare($sql);
        $stmt->execute(params: [
            ':id_matiere' => $chapitre->get_id_matiere(),
            ':titre' => $chapitre->get_titre(),
            ':contenu' => $chapitre->get_contenu(), 
            ':date_debut' => $chapitre->get_date_debut(),
            ':duree' => $chapitre->get_duree(),
            ':objectif' => $chapitre->get_objectif(),
            ':activite' => $chapitre->get_activite(),
            ':res_supp' => $chapitre->get_res_supp(),
            ':evaluation_incluse' => $chapitre->get_evaluation_incluse(),
            ':type_de_evaluation' => $chapitre->get_type_de_evaluation(),
        ]);
    }
    


   public function getChapitreById($id_chapitre) {
    $sql = "SELECT * FROM chapitre WHERE id_chapitre = :id_chapitre";
    $db = config::getConnexion();
    try {
        $query = $db->prepare($sql);
        $query->execute(['id_chapitre' => $id_chapitre]);
        return $query->fetch(); 
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}


public function get_chapitres_by_matiere($id_matiere) {
    $db = config::getConnexion();
    $sql = "SELECT * FROM chapitre WHERE id_matiere = ?";
    $query = $db->prepare($sql);
    $query->execute([$id_matiere]);
    return $query->fetchAll();
}


  


public function update_chapitre($id_chapitre )
{
    try {
        $db = config::getConnexion();
        $pdfFileName = '';

        // Check if a file is uploaded
        if (!empty($_FILES['contenu']['tmp_name'])) {
            // Validate the file type to ensure it's a PDF
            $fileType = mime_content_type($_FILES['contenu']['tmp_name']);
            if ($fileType !== 'application/pdf') {
                throw new Exception('Invalid file type. Only PDF files are allowed.');
            }

            // Generate a unique name for the PDF file
            $originalFileName = pathinfo($_FILES['contenu']['name'], PATHINFO_FILENAME);
            $pdfFileName = uniqid() . preg_replace('/[^a-zA-Z0-9_-]/', '', $originalFileName) . '.pdf';

            // Set the upload directory and move the file
            $uploadDir =  '../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true); // Create the directory if it doesn't exist
            }
            $targetFile = $uploadDir . $pdfFileName;

            if (!move_uploaded_file($_FILES['contenu']['tmp_name'], $targetFile)) {
                throw new Exception('Failed to upload the PDF file.');
            }
        }
        else {
            // No file uploaded, fetch the current 'contenu' (PDF file name) from the database
            $query = $db->prepare('SELECT contenu FROM chapitre WHERE id_chapitre = :id_chapitre');
            $query->execute(['id_chapitre' => $id_chapitre]);
            $currentContent = $query->fetchColumn();

            // If there's no existing content, leave it as an empty string or handle accordingly
            $pdfFileName = $currentContent ;
        }
        // SQL query for updating the chapter
        $query = $db->prepare('UPDATE chapitre SET 
                   titre = :titre,
                   contenu = :contenu,
                   date_debut = :date_debut,
                   duree = :duree,
                   objectif = :objectif,
                   activite = :activite,
                   res_supp = :res_supp,
                   evaluation_incluse = :evaluation_incluse,
                   type_de_evaluation = :type_de_evaluation
               WHERE id_chapitre = :id_chapitre');

        // If a file is uploaded, set the file name; otherwise, keep the existing content
        

        // Bind the parameters and execute the query
        $query->execute([
            'id_chapitre' => $id_chapitre,
            'titre' => $_POST['titre'],
            'contenu' => $pdfFileName,
            'date_debut' => $_POST['date_debut'],
            'duree' => $_POST['duree'],
            'objectif' => $_POST['objectif'],
            'activite' => $_POST['activite'],
            'res_supp' => $_POST['res_supp'],
            'evaluation_incluse' => isset($_POST['evaluation_incluse']) ? 1 : 0,
            'type_de_evaluation' => $_POST['type_de_evaluation']
        ]);

        echo $query->rowCount() . ' record(s) updated successfully.<br>';

        // Redirect to the index page
        echo '<script>
    alert("Chapter updated successful!");
    window.location.href = "index.php";
</script>';     
        exit();
    } catch (PDOException $e) {
        // Display an error message
        echo "Error: " . $e->getMessage();
    }
}


    }

?>