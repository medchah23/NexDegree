<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container">
    <div class="table-container" id="teachersTable">
        <h2>Enseignants</h2>

        <div class="search-bar">
            <form method="GET" action="">
                <input type="text" name="search" id="searchInput" class="form-control"
                       placeholder="Rechercher par Nom, Niveau ou ID Utilisateur"
                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button type="submit" class="btn btn-primary ms-2">Rechercher</button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover" id="teacherTable">
                <thead>
                <tr>
                    <th>Photo</th>
                    <th>
                        <a href="?sort=nom&order=<?= (isset($_GET['sort']) && $_GET['sort'] === 'nom' && isset($_GET['order']) && $_GET['order'] === 'asc') ? 'desc' : 'asc' ?>">Nom</a>
                    </th>
                    <th>
                        <a href="?sort=email&order=<?= (isset($_GET['sort']) && $_GET['sort'] === 'email' && isset($_GET['order']) && $_GET['order'] === 'asc') ? 'desc' : 'asc' ?>">Email</a>
                    </th>
                    <th>
                        <a href="?sort=numero_telephone&order=<?= (isset($_GET['sort']) && $_GET['sort'] === 'numero_telephone' && isset($_GET['order']) && $_GET['order'] === 'asc') ? 'desc' : 'asc' ?>">Téléphone</a>
                    </th>
                    <th>
                        <a href="?sort=qualifications&order=<?= (isset($_GET['sort']) && $_GET['sort'] === 'qualifications' && isset($_GET['order']) && $_GET['order'] === 'asc') ? 'desc' : 'asc' ?>">Qualifications</a>
                    </th>
                    <th>CV</th>
                    <th>Modifier</th>
                    <th>Approuver</th>
                    <th>Rejeter</th>
                    <th>Supprimer</th>
                </tr>
                </thead>

                <tbody id="teachersBody">
                <?php
                require_once("../../../controller/add.php");
                require_once("../../../Model/Enseignant.php");
                require_once 'debug.php';

                $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $perPage = 10;
                $offset = ($currentPage - 1) * $perPage;

                $searchQuery = $_GET['search'] ?? '';
                $sortColumn = $_GET['sort'] ?? 'id_enseignant';
                $sortOrder = $_GET['order'] ?? 'asc';

                $allowedColumns = ['nom', 'email', 'numero_telephone', 'qualifications', 'id_enseignant'];
                if (!in_array($sortColumn, $allowedColumns)) {
                    $sortColumn = 'id_enseignant';
                }

                if ($sortOrder !== 'asc' && $sortOrder !== 'desc') {
                    $sortOrder = 'asc';
                }

                try {
                    $userController = new UserController();

                    if (!empty($searchQuery)) {
                        $teachers = $userController->searche($searchQuery);
                    } else {
                        $teachers = $userController->showByOrder('enseignants', $sortColumn, $sortOrder);
                    }
                    if (empty($teachers)) {
                        echo "<tr><td colspan='11' class='text-center'>Aucun enseignant trouvé</td></tr>";
                    } else {
                        foreach ($teachers as $teacher) {
                            $image_src = ($teacher['image'] && file_exists("../../../uploads/images/" . basename($teacher['image'])))
                                ? "../../../uploads/images/" . basename($teacher['image'])
                                : "https://via.placeholder.com/50";
                            $cv_link = (isset($teacher['cv']) && file_exists("../../../uploads/cvs/" . basename($teacher['cv'])))
                                ? "../../../uploads/cvs/" . basename($teacher['cv'])
                                : null;
                            echo "<tr>
                                    <td class='text-center'>
                                    <img src='{$image_src}' alt='Photo' width='50' height='50' class='rounded'>
                                    </td>
                                    <td>{$teacher['nom']}</td>
                                    <td>{$teacher['email']}</td>
                                    <td>{$teacher['numero_telephone']}</td>
                                    <td>{$teacher['qualifications']}</td>
                                    <td class='text-center'>";
                            if ($cv_link) {
                                echo "<a href='{$cv_link}' download='cv_{$teacher['id_enseignant']}.pdf' class='btn btn-sm btn-primary'>Télécharger CV</a>";
                            } else {
                                echo "Aucun CV disponible";
                            }
                            echo "</td>
                                    <td>
                                        <a href='modify_teacher.php?id={$teacher['id_enseignant']}' class='btn btn-warning btn-sm me-1'>Modifier</a>
                                    </td>
                                    <td>
                                        <a href='approve-teacher.php?id={$teacher['id_enseignant']}' class='btn btn-success btn-sm me-1'>Approuver</a>
                                    </td>
                                    <td>
                                        <a href='reject-teacher.php?id={$teacher['id_enseignant']}' class='btn btn-secondary btn-sm'>Rejeter</a>
                                    </td>
                                    <td>
                                        <a href='delete-teacher.php?id={$teacher['id_enseignant']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Êtes-vous sûr ?\")'>Supprimer</a>
                                    </td>
                                </tr>";
                        }
                    }
                } catch (PDOException $e) {
                    echo "<tr><td colspan='11' class='text-center'>Erreur lors du chargement des enseignants: {$e->getMessage()}</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($teachers) && empty($searchQuery)): ?>
            <nav>
                <ul class="pagination">
                    <?php
                    $totalTeachers = $userController->countAllTeachers();
                    $totalPages = ceil($totalTeachers / $perPage);
                    for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($i === $currentPage) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body
