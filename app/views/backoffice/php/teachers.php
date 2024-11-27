<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .table-container {
            margin-bottom: 30px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .table-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="table-container" id="teachersTable">
        <h2>Teachers</h2>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>ID <a href="?sort=enseignants&field=id_enseignant" class="btn btn-link btn-sm">Sort</a></th>
                    <th>User ID <a href="?sort=enseignants&field=utilisateur_id" class="btn btn-link btn-sm">Sort</a></th>
                    <th>Qualifications <a href="?sort=enseignants&field=qualifications" class="btn btn-link btn-sm">Sort</a></th>
                    <th>CV</th>
                    <th>Actions</th> <!-- New column for actions -->
                </tr>
                </thead>
                <tbody id="teachersBody">
                <?php
                require_once("../../../controller/add.php");
                require_once("../../../Model/Enseignant.php");
                require_once 'debug.php';

                // Get and sanitize query parameters
                $sort = isset($_GET['sort']) ? htmlspecialchars($_GET['sort']) : 'enseignants';
                $field = isset($_GET['field']) ? htmlspecialchars($_GET['field']) : 'id_enseignant';

                try {
                    $sql = config::getConnexion();
                    $query = "SELECT * FROM enseignants ORDER BY $field";
                    $stmt = $sql->prepare($query);
                    $stmt->execute();
                    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (empty($teachers)) {
                        echo "<tr><td colspan='5' class='text-center'>No teachers found in the database.</td></tr>";
                    } else {
                        foreach ($teachers as $teacher) {
                            $cv_data = !empty($teacher['cv']) ? base64_encode($teacher['cv']) : null;
                            $cv_link = $cv_data ? "data:application/pdf;base64,{$cv_data}" : '#';

                            echo "<tr>
                                    <td>{$teacher['id_enseignant']}</td>
                                    <td>{$teacher['utilisateur_id']}</td>
                                    <td>{$teacher['qualifications']}</td>
                                    <td>";
                            if ($cv_data) {
                                echo "<a href='{$cv_link}' download='cv_{$teacher['id_enseignant']}.pdf' class='btn btn-sm btn-primary'>Download CV</a>";
                            } else {
                                echo "No CV Available";
                            }
                            echo "</td>
                                    <td>
                                        <a href='modify_teacher.php?id={$teacher['id_enseignant']}' class='btn btn-warning btn-sm'>Modify</a>
                                        <a href='delete-teacher.php?id={$teacher['utilisateur_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                    </td>
                                </tr>";
                        }
                    }
                } catch (PDOException $e) {
                    echo "<tr><td colspan='5' class='text-center'>Error loading teachers: {$e->getMessage()}</td></tr>";
                    Debugger::log("Error loading teachers: " . $e->getMessage());
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
