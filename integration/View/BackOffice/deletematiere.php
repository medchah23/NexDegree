<?php
include(__DIR__ . '/../../Controller/matiere_controller.php');

if (isset($_GET['id_matiere'])) {

    $id_matiere= $_GET['id_matiere'];

    $controller = new matiere_controller();

    $controller->delete_matiere($id_matiere);
    echo '<script>
    alert("Deleted successful!");
    window.location.href = "affichematiere.php";
</script>';     

    exit(); 
} else {
    echo "Invalid mateire ID!";
}
?>
