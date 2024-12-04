<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Étudiants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<div class="container">
    <div class="table-container" id="studentsTable">
        <h2>Étudiants</h2>
        <div class="search-bar">
            <form method="GET" action="">
                <input type="text" name="search" id="searchInput" class="form-control"
                       placeholder="Rechercher par Nom, Niveau, ou ID Utilisateur"
                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button type="submit" class="btn btn-primary ms-2">Rechercher</button>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="studentTable">
                <thead>
                <tr>
                    <th>ID <a href="?field=id_etudiant&order=<?= ($_GET['order'] ?? 'asc') === 'asc' ? 'desc' : 'asc' ?>" class="btn btn-link btn-sm">Trier</a></th>
                    <th>Nom <a href="?field=nom&order=<?= ($_GET['order'] ?? 'asc') === 'asc' ? 'desc' : 'asc' ?>" class="btn btn-link btn-sm">Trier</a></th>
                    <th>Numéro Téléphone</th>
                    <th>Email</th>
                    <th>Niveau <a href="?field=niveau&order=<?= ($_GET['order'] ?? 'asc') === 'asc' ? 'desc' : 'asc' ?>" class="btn btn-link btn-sm">Trier</a></th>
                    <th>Image de Profil</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                require_once("../../../controller/add.php");
                require_once("../../../Model/etudient.php");
                require_once 'debug.php';
                $field = $_GET['field'] ?? 'id_etudiant';
                $order = $_GET['order'] ?? 'asc';
                $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $perPage = 10;
                $offset = ($currentPage - 1) * $perPage;
                $searchQuery = $_GET['search'] ?? '';
                try {
                    $userController = new UserController();
                    $students = !empty($searchQuery)
                        ? $userController->search($searchQuery)
                        : $userController->showByOrder('etudiant', $field, $order, $offset, $perPage);
                    if (empty($students)) {
                        echo "<tr><td colspan='7' class='text-center'>Aucun étudiant trouvé</td></tr>";
                    } else {
                        foreach ($students as $student) {
                            $image_path = $student['image_profil'] ?? null;
                            $image_src = ($image_path && file_exists("../../../uploads/images/" . basename($image_path)))
                                ? "../../../uploads/images/" . basename($image_path)
                                : "https://via.placeholder.com/50";
                            echo "<tr>
                                  <td>{$student['id_etudiant']}</td>
                                  <td>{$student['nom']}</td>
                                  <td>{$student['numero_telephone']}</td>
                                  <td>{$student['email']}</td>
                                  <td>{$student['niveau']}</td>
                                  <td class='text-center'>";
                            echo $image_path && file_exists($image_src)
                                ? "<img src='{$image_src}' alt='Profile Image' class='rounded-circle' width='50' height='50'>"
                                : "<span class='no-image'>Pas d'image</span>";
                            echo "</td>
                                  <td>
                                    <a href='modify_student.php?id={$student['id_etudiant']}' class='btn btn-warning btn-sm me-1'>Modifier</a>
                                    <a href='delete-student.php?id={$student['id_utilisateur']}' 
                                       class='btn btn-danger btn-sm' 
                                       onclick='return confirm(\"Êtes-vous sûr ?\")'>Supprimer</a>
                                  </td>
                              </tr>";
                        }
                    }
                } catch (Exception $e) {
                    echo "<tr><td colspan='7' class='text-center'>Erreur : " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav>
            <ul class="pagination">
                <?php
                $totalStudents = $userController->countAllStudents();
                $totalPages = ceil($totalStudents / $perPage);

                for ($page = 1; $page <= $totalPages; $page++) {
                    $active = ($page === $currentPage) ? 'active' : '';
                    echo "<li class='page-item $active'>
                            <a class='page-link' href='?page=$page&field=$field&order=$order&search=$searchQuery'>$page</a>
                          </li>";
                }
                ?>
            </ul>
        </nav>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
