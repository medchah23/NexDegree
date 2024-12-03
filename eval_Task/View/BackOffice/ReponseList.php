<?php
require_once "../../Controller/EvaluationController.php";

if (isset($_GET['id_evaluation'])) {
    $id_evaluation = $_GET['id_evaluation'];
    $evaluationController = new EvaluationController();
    $evaluations = $evaluationController->joinEvaluationResponse($id_evaluation);
} else
    header("Location:EvaluationList.php");
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
            width: 88%;
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
            margin-left: 180px;
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
                <a class="nav-link" href="EvaluationList.php">
                    <i class="bi bi-card-list"></i>
                    <span>Test List</span>
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

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>
            </nav>

            <div class="container-fluid">
                <div class="row" style="margin-top: 50px;">
                    <div class="col-xl-12 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="table-responsive">
                                        <h2 class="sidebar-nav">Réponse pour Evaluation #<?php echo $id_evaluation; ?></h2>
                                        <br>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th> #ID Evaluation </th>
                                                <th> #ID Reponse </th>
                                                <th> #ID User </th>
                                                <th> Réponse 1 </th>
                                                <th> Réponse 2 </th>
                                                <th> Réponse 3 </th>
                                                <th> Réponse 4 </th>
                                                <th> Réponse 5 </th>
                                                <th> Note </th>
                                                <th> Rémarque </th>
                                            </tr>
                                            <?php
                                            foreach($evaluations as $eval){
                                            ?>
                                            <tr>
                                                <td><?php echo $eval['id'] ?></td>
                                                <td><?php echo $eval['idrep'] ?></td>
                                                <td><?php echo $eval['iduser'] ?></td>
                                                <td><?php echo $eval['rep1'] ?></td>
                                                <td><?php echo $eval['rep2'] ?></td>
                                                <td><?php echo $eval['rep3'] ?></td>
                                                <td><?php echo $eval['rep4'] ?></td>
                                                <td><?php echo $eval['rep5'] ?></td>
                                                <?php
                                                    if($eval['statusnote']){
                                                ?>
                                                    <td><strong><?php echo $eval['note'] ?></strong></td>
                                                    <td><?php echo $eval['remarque'] ?></td>
                                                <?php
                                                    } else {
                                                ?>
                                                <td>Non noté</td>
                                                <td>--</td>
                                                <td> <a href="noterReponse.php?idrep=<?php echo $eval['idrep']?>&max_score=<?php echo $eval['noteMax']; ?>">Noter</a></td>
                                                <?php } ?>
                                                <?php
                                                }

                                                ?>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
