<?php
include(__DIR__ . '/../../Controller/chapitre_controller.php');

if (isset($_GET['id_chapitre'])) {

    $id_chapitre = $_GET['id_chapitre'];

    $controller = new chapitre_controller();

    $controller->delete_chapitre($id_chapitre);
    echo '<script>
    alert("Chapter Deleted successful!");
    window.location.href = "index.php";
</script>';     
    exit(); 
} else {
    echo "Invalid chapter ID!";
}
?>
