<?php
include '../../Controller/EvaluationController.php';
$eval= null;
$evalC =new EvaluationController();
$db = config::getConnexion();

$sql_chapitre = "SELECT id_chapitre, titre FROM chapitre";
$query_chapitre = $db->query($sql_chapitre);
$chapitres = $query_chapitre->fetchAll();

if(isset($_POST['matiere'])&& isset($_POST['duree'])&& isset($_POST['noteMax'])&& isset($_POST['date2'])&& isset($_POST['quest1']) && isset($_POST['quest2']) && isset($_POST['quest3']) && isset($_POST['quest4']) && isset($_POST['quest5'])){
    if(!empty($_POST['matiere'])&& !empty($_POST['duree'])&& !empty($_POST['noteMax'])&& !empty($_POST['date2'])&& !empty($_POST['quest1']) && !empty($_POST['quest2']) && !empty($_POST['quest3']) && !empty($_POST['quest4']) && !empty($_POST['quest5'])){
   
    $sql_chapitre = "SELECT id_chapitre FROM chapitre WHERE titre = :matiere";
      $stmt = $db->prepare($sql_chapitre);
      $stmt->execute(['matiere' => $_POST['matiere']]);
      $id_chapitre = $stmt->fetchColumn();

    $eval=new evaluation(
    NULL,
    $_POST['matiere'],
    $_POST['duree'],
    $_POST['noteMax'],
    new DateTime($_POST['date2']),
     $_POST['quest1'],
     $_POST['quest2'],
     $_POST['quest3'],
     $_POST['quest4'],
     $_POST['quest5'],
        $id_chapitre
    
    );
            
            
            $evalC->updateEvaluation($_GET['id'],$eval);
    
           header('Location:EvaluationList.php');
        } else
            $error = "Missing information";
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
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />

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
</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <img src="logo web.png" alt="" />
                <span class="d-none d-lg-block">NexDegree</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>
        <!-- End Logo -->

        <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword" />
                <button type="submit" title="Search">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
        <!-- End Search Bar -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle" href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number">4</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            You have 4 new notifications
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li><hr class="dropdown-divider" /></li>
                        <li class="dropdown-footer">
                            <a href="#">Show all notifications</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-chat-left-text"></i>
                        <span class="badge bg-success badge-number">3</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                        <li class="dropdown-header">
                            You have 3 new messages
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li><hr class="dropdown-divider" /></li>
                        <li class="dropdown-footer">
                            <a href="#">Show all messages</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <!-- Dashboard -->
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
                <a class="nav-link" href="">
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                </a>
            </li>Profile -->

            <!-- 
            <li class="nav-item">
                <a class="nav-link" href="">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Login</span>
                </a>
            </li>Login -->
        </ul>
    </aside>
    <!-- End Sidebar -->

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

        <!-- Begin Page Content -->
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <div class="row">
                    <div class="col-xl-12 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">

                                <?php
                                    $eval=$evalC->getEvaluation($_GET['id']);
                                    ?>


                                            <form  action="" method="POST"  id="formAdd">

                            
                                            <select name="matiere" class="form-select" aria-label="Default select example" required>
          <option value="">Titre</option>
          <?php foreach ($chapitres as $chapitre): ?>
            <option value="<?= $chapitre['titre'] ?>"><?= $chapitre['titre'] ?></option>
          <?php endforeach; ?>
        </select>
                                            <span id="matiere_error"></span><br>


                                            <label for="duree">Duration:</label><br>
                                            <input class="form-control form-control-user" type="number"  name="duree" value="<?php echo $eval['duree']; ?>">
                                            <span id="duree_error" style="color: red;"></span><br>

                                            
                                    
                                                    <label for="noteMax">MaxScore:</label><br>
                                                <input class="form-control form-control-user" type="number"  name="noteMax" value="<?php echo $eval['noteMax']; ?>">
                                                <span id="noteMax_error" style="color: red;"></span><br>

                                                <label for="date2">Date:</label><br>
                                                <input class="form-control form-control-user" type="date"  name="date2" value="<?php echo $eval['date2']; ?>">
                                                    <span id="date_error"style="color: red;"></span><br>

                                        
                                                <label for="quest1">Question 1:</label><br>
                                                <textarea class="form-control form-control-user" id="quest1" name="quest1" rows="4" cols="50"></textarea>
                                                    <span id="quest1_error" style="color: red;"></span><br>

                                                    <label for="quest2">Question 2:</label><br>
                                                <textarea class="form-control form-control-user" id="quest2" name="quest2" rows="4" cols="50"></textarea>
                                                    <span id="quest2_error" style="color: red;"></span><br>

                                                    <label for="quest3">Question 3:</label><br>
                                                <textarea class="form-control form-control-user" id="quest3" name="quest3" rows="4" cols="50"></textarea>
                                                    <span id="quest3_error" style="color: red;"></span><br>

                                                    <label for="quest4">Question 4:</label><br>
                                                <textarea class="form-control form-control-user" id="quest4" name="quest4" rows="4" cols="50"></textarea>
                                                    <span id="quest4_error" style="color: red;"></span><br>

                                                    <label for="quest5">Question 5:</label><br>
                                                <textarea class="form-control form-control-user" id="quest5" name="quest5" rows="4" cols="50"></textarea>
                                                    <span id="quest5_error" style="color: red;"></span><br>

                                                                        <button type="submit" 
                                                                        class="btn btn-primary btn-user btn-block" 
                                                                        onClick="validerFormulaire()"
                                                                        >Update Evaluation</button>



                                        </form>


                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Content -->

    </main>

    <!-- Footer -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>2024 NexDegree</span></strong>. All Rights Reserved
        </div>
    </footer>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <script src="js/addEvaluation.js"></script>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
</body>

</html>
