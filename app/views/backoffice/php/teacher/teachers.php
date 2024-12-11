<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-4">
    <h2>Gestion des Enseignants</h2>

    <!-- Search Bar -->
    <div class="search-bar mb-3">
        <form method="GET" action="">
            <div class="input-group">
                <input type="text" name="search" id="searchInput" class="form-control"
                       placeholder="Rechercher par Nom, Email, ou Qualifications"
                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Photo</th>
                <th>
                    <a href="?sort=nom&order=<?= (isset($_GET['sort']) && $_GET['sort'] === 'nom' && isset($_GET['order']) && $_GET['order'] === 'asc') ? 'desc' : 'asc' ?>">
                        Nom
                    </a>
                </th>
                <th>
                    <a href="?sort=email&order=<?= (isset($_GET['sort']) && $_GET['sort'] === 'email' && isset($_GET['order']) && $_GET['order'] === 'asc') ? 'desc' : 'asc' ?>">
                        Email
                    </a>
                </th>
                <th>
                    <a href="?sort=numero_telephone&order=<?= (isset($_GET['sort']) && $_GET['sort'] === 'numero_telephone' && isset($_GET['order']) && $_GET['order'] === 'asc') ? 'desc' : 'asc' ?>">
                        Téléphone
                    </a>
                </th>
                <th>
                    <a href="?sort=qualifications&order=<?= (isset($_GET['sort']) && $_GET['sort'] === 'qualifications' && isset($_GET['order']) && $_GET['order'] === 'asc') ? 'desc' : 'asc' ?>">
                        Qualifications
                    </a>
                </th>
                <th>CV</th>
                <th>Modifier</th>
                <th>Approuver</th>
                <th>Rejeter</th>
                <th>Supprimer</th>
            </tr>
            </thead>
            <tbody>
            <?php
            require_once("../../../../controller/TeacherController.php");
            require_once("../../../../configdb.php");
            require_once("../debug.php");

            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $perPage = 10;
            $offset = ($currentPage - 1) * $perPage;

            $searchQuery = $_GET['search'] ?? '';
            $sortColumn = $_GET['sort'] ?? 'id_enseignant';
            $sortOrder = $_GET['order'] ?? 'asc';
            try {
                $teachersController = new TeacherController();

                if (!empty($searchQuery)) {
                    Debugger::log("Searching teachers with query: {$searchQuery}");
                    $teachers = $teachersController->searchTeacher($searchQuery);
                } else {
                    Debugger::log("Fetching teachers sorted by {$sortColumn} in {$sortOrder} order.");
                    $teachers = $teachersController->ShowTeachersByOrder($sortOrder, $sortColumn);
                }
                Debugger::dump($teachers, "Fetched Teachers Data");
                if (empty($teachers)) {
                    echo "<tr><td colspan='10' class='text-center'>Aucun enseignant trouvé.</td></tr>";
                } else {
                    foreach ($teachers as $teacher) {
                        $uploadDir = "../../../../uploads/images/";
                        $imagePath = $teacher['image'] ? $uploadDir . basename($teacher['image']) : null;
                        if ($imagePath && file_exists($imagePath)) {
                            $imageSrc = $imagePath;
                        } else {
                            $imageSrc = "https://via.placeholder.com/50"; // Default placeholder
                        }
                        $cvLink = isset($teacher['cv']) && file_exists("../../../../uploads/cvs/" . basename($teacher['cv']))
                            ? "../../../../uploads/cvs/" . basename($teacher['cv'])
                            : null;

                        echo "<tr>
                                <td class='text-center'>
                                    <img src='{$imageSrc}' alt='Photo' width='50' height='50' class='rounded'>
                                </td>
                                <td>{$teacher['nom']}</td>
                                <td>{$teacher['email']}</td>
                                <td>{$teacher['numero_telephone']}</td>
                                <td>{$teacher['qualifications']}</td>
                                <td>";
                        if ($cvLink) {
                            echo "<a href='{$cvLink}' download='cv_{$teacher['id_enseignant']}.pdf' class='btn btn-sm btn-primary'>Télécharger CV</a>";
                        } else {
                            echo "Aucun CV";
                        }
                        echo "</td>
                                <td><a href='modify_teacher.php?id={$teacher['id_enseignant']}' class='btn btn-warning btn-sm'>Modifier</a></td>
                                <td><a href='accept-teacher.php?id={$teacher['id_enseignant']}' class='btn btn-success btn-sm'>Approuver</a></td>
                                <td><a href='reject-teacher.php?id={$teacher['id_enseignant']}' class='btn btn-secondary btn-sm'>Rejeter</a></td>
                                <td><a href='delete-teacher.php?id={$teacher['id_enseignant']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Êtes-vous sûr ?\")'>Supprimer</a></td>
                              </tr>";
                    }
                }
            } catch (Exception $e) {
                Debugger::log("Error occurred: " . $e->getMessage());
                echo "<tr><td colspan='10' class='text-center text-danger'>Erreur: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if (!empty($teachers) && empty($searchQuery)): ?>
        <nav>
            <ul class="pagination">
                <?php
                $totalTeachers = $teachersController->countAllTeachers();
                $totalPages = ceil($totalTeachers / $perPage);

                for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i === $currentPage) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&sort=<?= $sortColumn ?>&order=<?= $sortOrder ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
