
<?php
include(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/evaluation.php');

class EvaluationController {
public function listEvaluation(){
    $sql="SELECT * FROM evaluation";
    $db = config::getConnexion();

    try{
        $list = $db->query($sql);
        return $list;

    } 
    catch(Exception $e){

        die('Erro:'.$e->getMessage());
    }
}

public function addEvaluation($eval){
    $sql="INSERT INTO evaluation VALUES(NULL, :matiere, :duree, :noteMax, :date2, :description2)";
    $db = config::getConnexion();
    try{
        $query=$db->prepare($sql);
        $query->execute([
            'matiere'=>$eval->getMatiere(),
            'duree'=>$eval->getDuree(),
            'noteMax'=>$eval->getNoteMax(),
            'date2'=>$eval->getDate()->format('Y-m-d'),
            'description2'=>$eval->getDescription()

        ]);
    }
    catch(Exception $e){

        die('Erreur1:'.$e->getMessage());
    }
}

public function deleteEvaluation($id){
    $sql = "DELETE  FROM evaluation WHERE id=:id";
    $db = config::getConnexion();
    $query=$db->prepare($sql);
    $query->bindValue(':id',$id);
    try{
        $query->execute();

    }catch(Exception $e){
        echo 'Erreur2:'.$e->getMessage();
    }

}
public function getEvaluation($id){
    $sql ="SELECT * FROM evaluation where id= $id";
    $db=config::getConnexion();
    try{
        $query=$db->prepare($sql);
        $query->execute();
        $eval=$query->fetch();
        return $eval;
    }catch(Exception $e){
        echo 'Erreur3:'.$e->getMessage();
    }


}

public function updateEvaluation($id,$eval){
    $sql ="UPDATE evaluation where id= $id";
    try {
        $db = config::getConnexion();

        $query = $db->prepare(
            'UPDATE evaluation SET 
                matiere = :matiere,
                duree = :duree,
                noteMax = :noteMax,
                date2 = :date2,
                description2 = :description2
                
            WHERE id = :id'
        );

        $query->execute([
            'id' => $id,
            'matiere'=>$eval->getMatiere(),
            'duree'=>$eval->getDuree(),
            'noteMax'=>$eval->getNoteMax(),
            'date2'=>$eval->getDate()->format('Y-m-d'),
            'description2'=>$eval->getDescription()
           
        ]);

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); 
    }

}

}


?>
