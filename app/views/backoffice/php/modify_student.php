<?php
require_once("../../../controller/add.php");
require_once("../../../Model/etudient.php");

if (isset($_GET['id'])) {
    $id_etudiant = $_GET['id'];

    try {
        // Fetch student data
        $sql = config::getConnexion();
        $query = "SELECT * FROM etudiants WHERE id_etudiant = :id_etudiant";
        $stmt = $sql->prepare($query);
        $stmt->bindParam(':id_etudiant', $id_etudiant, PDO::PARAM_INT);
        $stmt->execute();
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($student) {
            $user_id = $student['id_utilisateur']; // Use user ID to fetch user info

            // Fetch user data
            $query_user = "SELECT * FROM utilisateurs WHERE id = :id_utilisateur";
            $stmt_user = $sql->prepare($query_user);
            $stmt_user->bindParam(':id_utilisateur', $user_id, PDO::PARAM_INT);
            $stmt_user->execute();
            $user = $stmt_user->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "Student not found.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $numero_telephone = $_POST['numero_telephone'];
    $role = $_POST['role'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $statut = $_POST['statut'];
    $niveau = $_POST['niveau'];

    try {
        // Hash the password before updating
        $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        // Update the user information
        $update_user = "UPDATE utilisateurs SET nom = :nom, numero_telephone = :numero_telephone, mot_de_passe = :mot_de_passe WHERE id = :id_utilisateur";
        $stmt_user_update = $sql->prepare($update_user);
        $stmt_user_update->bindParam(':id_utilisateur', $user['id'], PDO::PARAM_INT);
        $stmt_user_update->bindParam(':nom', $nom);
        $stmt_user_update->bindParam(':numero_telephone', $numero_telephone);
        $stmt_user_update->bindParam(':mot_de_passe', $hashed_password);
        $stmt_user_update->execute();

        // Update the student information
        $update_student = "UPDATE etudiants SET niveau = :niveau WHERE id_etudiant = :id_etudiant";
        $stmt_student_update = $sql->prepare($update_student);
        $stmt_student_update->bindParam(':id_etudiant', $id_etudiant, PDO::PARAM_INT);
        $stmt_student_update->bindParam(':niveau', $niveau);
        $stmt_student_update->execute();

        header("Location: students.php");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Modify Student Information</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="nom" class="form-label">Name</label>
            <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" disabled value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="numero_telephone" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="numero_telephone" name="numero_telephone" value="<?= htmlspecialchars($user['numero_telephone']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="mot_de_passe" class="form-label">Password</label>
            <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" value="<?= htmlspecialchars($user['mot_de_passe']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="niveau" class="form-label">Level</label>
            <input type="text" class="form-control" id="niveau" name="niveau" value="<?= htmlspecialchars($student['niveau']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Student</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
