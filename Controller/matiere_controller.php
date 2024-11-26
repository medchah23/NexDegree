<?php

include(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/matiere.php');

class matiere_controller 

{
    public function show_all_matiere() {
        $sql = "SELECT * FROM matiere"; 
        $db = config::getConnexion();
        
        try {
            $matiere = $db->query($sql);
            return $matiere;
        } catch (Exception $e) {
            die("Error show_all_chapitre: " . $e->getMessage());
        }
    }
    
    

     function delete_matiere($id_matiere)
    {
        $sql = 'DELETE FROM matiere WHERE id_matiere=:id_matiere';
        
        $db = config::getConnexion();
        $req= $db->prepare($sql);
        $req->bindValue(':id_matiere',$id_matiere);
        try {
            $req->execute();
        }catch (Exception $e) {
            die('Error Delete_chapitre'. $e->getMessage());
        }
        
    }


    
   
    public function add_matiere($matiere) {
        $db = config::getConnexion();
        $sql = "INSERT INTO matiere ( nom, description, credit, sems, niveau, prerequis, nombre_chapitre)
                VALUES (:nom, :description, :credit, :sems, :niveau, :prerequis, :nombre_chapitre)";
        $stmt = $db->prepare($sql);
        $stmt->execute(params: [
            ':nom' => $matiere->get_nom(),
            ':description' => $matiere->get_description(), 
            ':credit' => $matiere->get_credit(),
            ':sems' => $matiere->get_sems(),
            ':niveau' => $matiere->get_niveau(),
            ':prerequis' => $matiere->get_prerequis(),
            ':nombre_chapitre' => $matiere->get_nombre_chapitre(),
        ]);
        echo '<script>
        alert("Matiere added successfully!");
        window.location.href = "affichematiere.php";
    </script>';     
    exit;
    }
    


   public function getMatiereById($id_matiere) {
    $sql = "SELECT * FROM matiere WHERE id_matiere = :id_matiere";
    $db = config::getConnexion();
    try {
        $query = $db->prepare($sql);
        $query->execute(['id_matiere' => $id_matiere]);
        return $query->fetch(); 
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}




  


function update_matiere($id_matiere )   
{
    try {
        $db = config::getConnexion();

        // SQL query for updating the chapter
        $query = $db->prepare('UPDATE matiere SET 
                   nom = :nom,
                   description = :description,
                   credit = :credit,
                   sems = :sems,
                   niveau = :niveau,
                   prerequis = :prerequis,
                   nombre_chapitre = :nombre_chapitre
               WHERE id_matiere = :id_matiere');

        // If a file is uploaded, set the file name; otherwise, keep the existing content
        

        // Bind the parameters and execute the query
        $query->execute([
            'id_matiere' => $id_matiere,
            'nom' => $_POST['nom'],
            'description' => $_POST['description'],
            'credit' => $_POST['credit'],
            'sems' => $_POST['sems'],
            'niveau' => $_POST['niveau'],
            'prerequis' => $_POST['prerequis'],
            'nombre_chapitre' => $_POST['nombre_chapitre']
            
        ]);

        echo $query->rowCount() . ' record(s) updated successfully.<br>';
        echo '<script>
        alert("Matiere updated successfully!");
        window.location.href = "affichematiere.php";
    </script>';     
    exit;
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


    }

?>