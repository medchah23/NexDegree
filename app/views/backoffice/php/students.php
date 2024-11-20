<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
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
    <div class="table-container" id="studentsTable">
        <h2>Students</h2>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>ID <a href="?sort=etudiants&field=id_etudiant" class="btn btn-link btn-sm">Sort</a></th>
                    <th>User ID <a href="?sort=etudiants&field=id_utilisateur" class="btn btn-link btn-sm">Sort</a></th>
                    <th>Level <a href="?sort=etudiants&field=niveau" class="btn btn-link btn-sm">Sort</a></th>
                    <th>Profile Image</th>
                    <th>Actions</th> <!-- New column for actions -->
                </tr>
                </thead>
                <tbody id="studentsBody">
                <?php
                require_once("../../../controller/add.php");
                require_once("../../../Model/etudient.php");
                require_once 'debug.php';

                $sort = $_GET['sort'] ?? 'etudiants';
                $field = $_GET['field'] ?? 'id_etudiant';

                try {
                    $sql = config::getConnexion();
                    $query = "SELECT * FROM etudiants ORDER BY $field";
                    $stmt = $sql->prepare($query);
                    $stmt->execute();
                    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (empty($students)) {
                        echo "<tr><td colspan='5'>No students found</td></tr>";
                    } else {
                        foreach ($students as $student) {
                            $image_data = !empty($student['image_profil']) ? base64_encode($student['image_profil']) : null;
                            $image_src = $image_data ? "data:image/jpeg;base64,{$image_data}" : '#';

                            echo "<tr>
                                    <td>{$student['id_etudiant']}</td>
                                    <td>{$student['id_utilisateur']}</td>
                                    <td>{$student['niveau']}</td>
                                    <td>";
                            if ($image_data) {
                                echo "<img src='{$image_src}' alt='Profile Image' width='50' height='50' class='rounded'>";
                            } else {
                                echo "No Image";
                            }
                            echo "</td>
                                    <td>
                                        <a href='modify_student.php?id={$student['id_etudiant']}' class='btn btn-warning btn-sm'>Modify</a>
                                        <a href='delete-student.php?id={$student['id_utilisateur']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                    </td>
                                </tr>";
                        }
                    }
                } catch (PDOException $e) {
                    echo "<tr><td colspan='5'>Error loading students</td></tr>";
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
