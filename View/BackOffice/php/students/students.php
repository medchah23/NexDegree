<?php
require_once("../../../../controller/StudentController.php");
require_once("../../../../config.php");
require_once("../debug.php"); // Include the Debugger class

$field = $_GET['field'] ?? 'id_etudiant';
$order = $_GET['order'] ?? 'ASC';

$searchQuery = $_GET['search'] ?? '';
$currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 10;
$offset = ($currentPage - 1) * $perPage;

try {
    $userController = new StudentController();
    Debugger::log("Fetching students with searchQuery: {$searchQuery}, field: {$field}, order: {$order}, currentPage: {$currentPage}");
    if(empty($searchQuery)) {
        $students=$userController->ShowStudentsByOrder($order, $field, $perPage, $offset);
    }
    else{
        $students=$userController->search($searchQuery);
    }
    $totalStudents = $userController->countAllStudents();
    $totalPages = max(1, ceil($totalStudents / $perPage));
    $currentPage = max(1, min($currentPage, $totalPages));
    Debugger::log("Total Students: {$totalStudents}, Total Pages: {$totalPages}");
} catch (Exception $e) {
    $students = [];
    $totalPages = 1;
    $error = $e->getMessage();

    Debugger::log("Error: {$error}");
    Debugger::dump($e, "Exception Details");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Étudiants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-responsive { margin-top: 20px; }
        .search-bar { display: flex; gap: 10px; margin-bottom: 20px; }
        .table-container h2 { margin-bottom: 20px; }
        .pagination { justify-content: center; margin-top: 20px; }
    </style>
</head>
<body>
<div class="container">
    <div class="table-container" id="studentsTable">
        <h2>Étudiants</h2>
        <div class="search-bar mb-3">
            <form method="GET" action="">
                <div class="input-group">
                    <input type="text" name="search" id="searchInput" class="form-control"
                           placeholder="Rechercher par Nom, Email, ou Qualifications"
                           value="<?= htmlspecialchars($_GET['$searchQuery'] ?? '') ?>">
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="studentTable">
                <thead>
                <tr>
                    <th> <a href="?field=id_etudiant&order=<?= $order === 'ASC' ? 'DESC' : 'ASC' ?>&page=<?= $currentPage ?>">ID</a></th>
                    <th> <a href="?field=nom&order=<?= $order === 'ASC' ? 'DESC' : 'ASC' ?>&page=<?= $currentPage ?>">Nom</a></th>
                    <th>Numéro Téléphone</th>
                    <th>Email</th>
                    <th> <a href="?field=niveau&order=<?= $order === 'ASC' ? 'DESC' : 'ASC' ?>&page=<?= $currentPage ?>">Niveau</a></th>
                    <th>Image de Profil</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($students)): ?>
                    <tr><td colspan="7" class="text-center">Aucun étudiant trouvé</td></tr>
                <?php else: ?>
                    <?php foreach ($students as $student): ?>

                        <?php
                        echo var_dump($student);
                        $image_path = $student['image_profil'] ?? null;
                        $image_src = ($image_path && file_exists("../../../../uploads/images/" . basename($image_path)))
                            ? "../../../../uploads/images/" . basename($image_path)
                            : "https://via.placeholder.com/50";

                        Debugger::log("Rendering student ID: {$student['id_etudiant']}, Name: {$student['nom']}, Image: {$image_src}");
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($student['id_etudiant']) ?></td>
                            <td><?= htmlspecialchars($student['nom']) ?></td>
                            <td><?= htmlspecialchars($student['numero_telephone']) ?></td>
                            <td><?= htmlspecialchars($student['email']) ?></td>
                            <td><?= htmlspecialchars($student['niveau']) ?></td>
                            <td><img src="<?= $image_src ?>" alt="Profile Image" class="rounded-circle" width="50" height="50"></td>
                            <td>
                                <a href="modify_student.php?id=<?= urlencode($student['id_etudiant']) ?>" class="btn btn-warning btn-sm">Modifier</a>
                                <a href="delete-student.php?id=<?= urlencode($student['id_etudiant']) ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Êtes-vous sûr ?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <nav>
            <ul class="pagination">
                <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                    <li class="page-item <?= $page === $currentPage ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $page ?>&field=<?= $field ?>&order=<?= $order ?>&search=<?= htmlspecialchars($searchQuery) ?>"><?= $page ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
