<?php
include '../../Controller/EvaluationController.php';
$evalc=new EvaluationController();
    $list=$evalc->listEvaluation();
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
        <form class="search-form d-flex align-items-center" method="POST" action="#">
          <input type="text" name="query" placeholder="Search" title="Enter search keyword" />
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
                    <a class="nav-link" href="index.php">
                        <i class="bi bi-grid"></i>
                        <span>Evaluation</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="addEvaluation.php">
                        <i class="bi bi-card-list"></i>
                        <span>Add Test</span>
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
                                        <select id="filterSubject">
                                            <option value="all">Subjects</option>
                                            <option value="Maths">Maths</option>
                                            <option value="French">French</option>
                                            <option value="Science">Science</option>
                                        </select>
                                            
                                            <table class="table table-bordered" id="evaluationTable" >
                                            <tr>
                                                <th> ID </th>
                                                <th> Subject </th>
                                                <th> Duration </th>
                                                <th id="sortByMaxScore" style="cursor: pointer;">Max Score</th>
                                                <th> Date </th>
                                                <th> Question 1 </th>
                                                <th> Question 2 </th>
                                                <th> Question 3 </th>
                                                <th> Question 4 </th>
                                                <th> Question 5 </th>


                                            </tr>
                                            <?php
                                            foreach($list as $eval){
                                                ?>
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


                                                <td> <a href="deleteEvaluation.php?id=<?php echo $eval['id']?>">Delete</a></td>
                                                <td> <a href="updateEvaluation.php?id=<?php echo $eval['id']?>">Update</a></td>
                                                <td> <a href="ReponseList.php?id_evaluation=<?php echo $eval['id']?>">Answers</a></td>

                                                <?php
                                            }
                                            
                                            ?>
                                        </table>
                                        <script>
                                            document.getElementById("sortByMaxScore").addEventListener("click", function () {
                                                const table = document.getElementById("evaluationTable");
                                                const rows = Array.from(table.rows).slice(1); // Obtenir toutes les lignes sauf l'en-tête
                                                const isAscending = this.dataset.order === "asc"; // Vérifier l'ordre actuel
                                                this.dataset.order = isAscending ? "desc" : "asc"; // Basculer l'ordre

                                                rows.sort((a, b) => {
                                                    const valA = parseFloat(a.cells[3].textContent.trim()) || 0; // Colonne Max Score (index 3)
                                                    const valB = parseFloat(b.cells[3].textContent.trim()) || 0;
                                                    return isAscending ? valA - valB : valB - valA;
                                                });

                                                // Réorganiser les lignes dans le tableau
                                                rows.forEach(row => table.appendChild(row));
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
