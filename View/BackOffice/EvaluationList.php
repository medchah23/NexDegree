<?php
include '../../Controller/EvaluationController.php';
include(__DIR__ . '/../../Controller/chapitre_controller.php');
$db = config::getConnexion();

$sql_chapitre = "SELECT id_chapitre, titre FROM chapitre";
$query_chapitre = $db->query($sql_chapitre);
$chapitres = $query_chapitre->fetchAll();
$evalc=new EvaluationController();
    $list=$evalc->listEvaluation();


    //code pour lier la recherche par id
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['query'])) {
        $query = trim($_POST['query']);
        if (is_numeric($query)) {
            // Recherche par ID
            $list = [];
            $result = $evalc->getEvaluation($query);
            if ($result) {
                $list[] = $result; // Ajoutez le résultat à la liste
            }
        } else {
            // Message pour indiquer que l'ID est invalide
            $list = [];
            echo '<p>No evaluation found for the given ID.</p>';
        }
    } else {
        // Charger toutes les évaluations
        $list = $evalc->listEvaluation();
    }
    



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Evaluation</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon" />
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect" />
    <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
      rel="stylesheet"
    />

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet" />
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet" />
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet" />
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet" />

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet" />

    <style>
        .table {
            width: 150%;
            table-layout: fixed;
        }

        .table th, .table td {
            word-wrap: break-word;
            text-overflow: ellipsis;
            padding: 6px;
        }

        .table td:nth-child(1), .table td:nth-child(2) {
            width: 80px;
        }

        .table td:nth-child(6) {
            width: 120px;
        }

        .table-responsive {
            margin-left: 10px;
            overflow-x: auto;
        }
    </style>
</head>

<body id="page-top">
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="index.php" class="logo d-flex align-items-center">
                <img src="logo web.png" alt="" />
                <span class="d-none d-lg-block">NexDegree</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>

            <div class="search-bar">
    <form class="search-form d-flex align-items-center" method="POST" action="">
        <input type="text" name="query" placeholder="Search by ID" title="Enter ID to search" />
        <button type="submit" title="Search">
            <i class="bi bi-search"></i>
        </button>
    </form>
</div>

      <!-- End Search Bar -->
        </div>
    </header>

    <div id="wrapper">
        <aside id="sidebar" class="sidebar">
            <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
        <a class="nav-link collapsed" href="backoffice.php">
          <i class="bi bi-grid"></i>
          <span>dashboard</span>
        </a>
      </li>
            <li class="nav-item">
        <a class="nav-link collapsed" href="index.php">
          <i class="bi bi-grid"></i>
          <span>Chapitre</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="addchapitre.php">
          <i class="bi bi-grid"></i>
          <span>Add Chapter</span>
        </a>
        </li>
        <li class="nav-item">
        <a class="nav-link collapsed" href="affichematiere.php">
          <i class="bi bi-grid"></i>
          <span>Matiere</span>
        </a>
        </li> 
        <li class="nav-item">
        <a class="nav-link collapsed" href="addmatiere.php">
          <i class="bi bi-grid"></i>
          <span>Add Matiere</span>
        </a>
        </li> 
        <li class="nav-item">
        <a class="nav-link " href="posts.php">
          <i class="bi bi-grid"></i>
          <span>Posts</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="comments.php">
          <i class="bi bi-grid"></i>
          <span>Comments</span>
        </a>
      </li>
        <li class="nav-item">
        <a class="nav-link collapsed" href="quizList.php">
          <i class="bi bi-grid"></i>
          <span>Quiz list</span>
        </a>
        </li> 
        <li class="nav-item">
        <a class="nav-link collapsed" href="addquiz.php">
          <i class="bi bi-grid"></i>
          <span>Add quiz </span>
        </a>
        </li> 
        <li class="nav-item">
        <a class="nav-link collapsed" href="addQuestion.php">
          <i class="bi bi-grid"></i>
          <span>Add Question </span>
        </a>
        </li> 
        <li class="nav-item">
        <a class="nav-link collapsed" href="addEvaluation.php">
          <i class="bi bi-grid"></i>
          <span>Add Evaluation </span>
        </a>
        </li> 
        <li class="nav-item">
        <a class="nav-link collapsed" href="EvaluationList.php">
          <i class="bi bi-grid"></i>
          <span>Evaluation list </span>
        </a>
        </li> 
                      <!-- 

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-person"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="View\FrontOffice\index.php">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span>Home</span>
                    </a>
                </li> -->
            </ul>
        </aside>
        <main id="main" class="main">
      <div class="pagetitle">
        <h1>Evaluation</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Evaluation</li>
          </ol>
        </nav>
      </div>
      <!-- End Page Title -->

        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h2 mb-0 text-gray-800">Evaluation List</h1>
        </div>
            
                    <div class="row" style="margin-top: 8px;">
                        <div class="col-xl-12 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="table-responsive">


                                        <label for="filterSubject"></label>
        <select name="matiere" id="filterSubject" class="form-select" aria-label="Default select example" required>
          <option value="">Titre</option>
          <?php foreach ($chapitres as $chapitre): ?>
            <option value="<?= $chapitre['titre'] ?>"><?= $chapitre['titre'] ?></option>
          <?php endforeach; ?>
        </select>



                                        
                                       
                                        <table class="table table-bordered" id="evaluationTable">
    <tr>
        <th> ID </th>
        <th> Subject </th>
        <th> Duration </th>
        <th>
            Max Score
            <select id="sortMaxScore" style="margin-left: 2px;">
                <option value="none">sorted</option>
                <option value="asc">Asc</option>
                <option value="desc">Desc</option>
            </select>
        </th>
        <th id="sortByDate" style="cursor: pointer;"> Date </th>
        <th> Question 1 </th>
        <th> Question 2 </th>
        <th> Question 3 </th>
        <th> Question 4 </th>
        <th> Question 5 </th>
    </tr>
    <?php foreach ($list as $eval) { ?>
        <tr>
            <td><?php echo $eval['id'] ?></td>
            <td><?php echo $eval['matiere'] ?></td>
            <td><?php echo $eval['duree'] ?></td>
            <td><?php echo $eval['noteMax'] ?></td>
            <td><?php echo $eval['date2'] ?></td>
            <td><?php echo $eval['quest1'] ?></td>
            <td><?php echo $eval['quest2'] ?></td>
            <td><?php echo $eval['quest3'] ?></td>
            <td><?php echo $eval['quest4'] ?></td>
            <td><?php echo $eval['quest5'] ?></td>
            <td><a href="deleteEvaluation.php?id=<?php echo $eval['id'] ?>">Delete</a></td>
            <td><a href="updateEvaluation.php?id=<?php echo $eval['id'] ?>">Update</a></td>
            <td><a href="ReponseList.php?id_evaluation=<?php echo $eval['id'] ?>">Answers</a></td>
            <td><a href="qrcode.php?id_evaluation=<?php echo $eval['id'] ?>">QRCode</a></td>
        </tr>
    <?php } ?>
</table>

<script>
function sortTable(columnIndex, isNumeric, order) {
    const table = document.getElementById("evaluationTable");
    const rows = Array.from(table.rows).slice(1); // Exclude header row

    rows.sort((a, b) => {
        const valA = isNumeric ? parseFloat(a.cells[columnIndex].textContent.trim()) || 0 
                               : a.cells[columnIndex].textContent.trim();
        const valB = isNumeric ? parseFloat(b.cells[columnIndex].textContent.trim()) || 0 
                               : b.cells[columnIndex].textContent.trim();
        return order === "asc" ? valA - valB : valB - valA;
    });

    rows.forEach(row => table.appendChild(row));
}

// Handle sorting by Max Score
document.getElementById("sortMaxScore").addEventListener("change", function () {
    const order = this.value;
    if (order === "asc" || order === "desc") {
        sortTable(3, true, order);
    }
});
</script>


                                        <script>
                                            document.getElementById("filterSubject").addEventListener("change", function () {
                                                const filterValue = this.value.toLowerCase();
                                                const rows = document.querySelectorAll("#evaluationTable tr");

                                                rows.forEach((row, index) => {
                                                    if (index === 0) return; // Ignorer l'en-tête
                                                    const subject = row.cells[1].textContent.toLowerCase();
                                                    row.style.display = (filterValue === "all" || subject === filterValue) ? "" : "none";
                                                });
                                            });
                                        </script>

                                        <script>
                                            document.getElementById("sortByDate").addEventListener("click", function () {
                                            const table = document.getElementById("evaluationTable");
                                            const rows = Array.from(table.rows).slice(1); // Exclure l'en-tête
                                            const isAscending = this.dataset.order === "asc"; // Vérifier l'ordre actuel
                                            this.dataset.order = isAscending ? "desc" : "asc"; // Alterner entre ascendant et descendant

                                            rows.sort((a, b) => {
                                                // Extraire et convertir les valeurs des dates
                                                const dateA = new Date(a.cells[4].textContent.trim()); // Colonne Date (index 4)
                                                const dateB = new Date(b.cells[4].textContent.trim());

                                                // Comparer les années, puis les mois, puis les jours
                                                if (dateA.getFullYear() !== dateB.getFullYear()) {
                                                    return isAscending 
                                                        ? dateA.getFullYear() - dateB.getFullYear()
                                                        : dateB.getFullYear() - dateA.getFullYear();
                                                }
                                                if (dateA.getMonth() !== dateB.getMonth()) {
                                                    return isAscending 
                                                        ? dateA.getMonth() - dateB.getMonth()
                                                        : dateB.getMonth() - dateA.getMonth();
                                                }
                                                return isAscending 
                                                    ? dateA.getDate() - dateB.getDate()
                                                    : dateB.getDate() - dateA.getDate();
                                            });

                                            // Réorganiser les lignes triées dans le tableau
                                            rows.forEach(row => table.appendChild(row));
                                        });

                         </script>


                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </main>

            <footer id="footer" class="footer">
                <div class="copyright">
                    &copy; Copyright <strong><span>2024 NexDegree.</span></strong> All Rights Reserved
                </div>
            </footer>

            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>
        </div>
    </div>

    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
