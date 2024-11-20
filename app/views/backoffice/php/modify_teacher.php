<?php
require_once("../../../controller/add.php");
require_once("../../../Model/Enseignant.php");

if (isset($_GET['id'])) {
    $id_enseignant = $_GET['id'];

    try {
        // Fetch teacher data
        $sql = config::getConnexion();
        $query = "SELECT * FROM enseignants WHERE id_enseignant = :id_enseignant";
        $stmt = $sql->prepare($query);
        $stmt->bindParam(':id_enseignant', $id_enseignant, PDO::PARAM_INT);
        $stmt->execute();
        $teacher = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($teacher) {
            $user_id = $teacher['utilisateur_id']; // Use user ID to fetch user info

            // Fetch user data
            $query_user = "SELECT * FROM utilisateurs WHERE id = :id_utilisateur";
            $stmt_user = $sql->prepare($query_user);
            $stmt_user->bindParam(':id_utilisateur', $user_id, PDO::PARAM_INT);
            $stmt_user->execute();
            $user = $stmt_user->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "Teacher not found.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $numero_telephone = filter_input(INPUT_POST, 'numero_telephone', FILTER_SANITIZE_STRING);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
    $mot_de_passe = filter_input(INPUT_POST, 'mot_de_passe', FILTER_SANITIZE_STRING);
    $statut = filter_input(INPUT_POST, 'statut', FILTER_SANITIZE_STRING);
    $qualifications = filter_input(INPUT_POST, 'qualifications', FILTER_SANITIZE_STRING);

    // Validate input data


    try {
        $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        $update_user = "UPDATE utilisateurs SET nom = :nom,  numero_telephone = :numero_telephone,  mot_de_passe = :mot_de_passe WHERE id = :id_utilisateur";
        $stmt_user_update = $sql->prepare($update_user);
        $stmt_user_update->bindParam(':id_utilisateur', $user['id'], PDO::PARAM_INT);
        $stmt_user_update->bindParam(':nom', $nom);
        $stmt_user_update->bindParam(':numero_telephone', $numero_telephone);
        $stmt_user_update->bindParam(':mot_de_passe', $hashed_password);
        $stmt_user_update->execute();

        // Update the teacher information
        $update_teacher = "UPDATE enseignants SET qualifications = :qualifications WHERE id_enseignant = :id_enseignant";
        $stmt_teacher_update = $sql->prepare($update_teacher);
        $stmt_teacher_update->bindParam(':id_enseignant', $id_enseignant, PDO::PARAM_INT);
        $stmt_teacher_update->bindParam(':qualifications', $qualifications);
        $stmt_teacher_update->execute();

        header("Location: teachers.php");
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
    <title>Modify Teacher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Modify Teacher</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="nom" class="form-label">Name</label>
            <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($user['nom'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" disabled name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="numero_telephone" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="numero_telephone" name="numero_telephone" value="<?= htmlspecialchars($user['numero_telephone'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label for="mot_de_passe" class="form-label">Password</label>
            <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" >
        </div>

        <div class="mb-3">
            <label for="qualifications" class="form-label">Qualifications</label>
            <textarea class="form-control" id="qualifications" name="qualifications" ><?= htmlspecialchars($teacher['qualifications'] ?? '') ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Teacher</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
