<?php
include '../../Controller/ResponseController.php'; // Inclure ton contrôleur de réponses

if (isset($_POST['id'], $_POST['iduser'], $_POST['rep1'], $_POST['rep2'], $_POST['rep3'], $_POST['rep4'], $_POST['rep5'], $_POST['note'],$_POST['remarque'],$_POST['statusnote'])) {
    // Vérifier que les champs nécessaires ne sont pas vides
    if (!empty($_POST['id']) && !empty($_POST['iduser']) && !empty($_POST['rep1']) && !empty($_POST['rep2']) && !empty($_POST['rep3']) && !empty($_POST['rep4']) && !empty($_POST['rep5']) &&  !empty($_POST['note'])&&  !empty($_POST['remarque'])&& !empty($_POST['statusnote'])) {
        
        // Créer un nouvel objet Réponse
        $response = new Response(
            NULL, // L'ID peut être auto-incrémenté dans la DB
            $_POST['id'],
            $_POST['iduser'],
            $_POST['rep1'],
            $_POST['rep2'],
            $_POST['rep3'],
            $_POST['rep4'],
            $_POST['rep5'],
            $_POST['note'],
            $_POST['remarque'],
            isset($_POST['statusnote']) ? true : false
        );

        // Instancier le contrôleur et ajouter la réponse
        $repC = new ResponseController();
        $repC->addResponse($rep);

        // Rediriger après l'ajout
        header('Location: ResponseList.php');
        exit();
    }
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
            <!-- End Notification Icon -->

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
              <li class="dropdown-header">
                You have 4 new notifications
                <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
              </li>
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
            <!-- End Messages Icon -->

            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
              <li class="dropdown-header">
                You have 3 new messages
                <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
              </li>
              <li class="dropdown-footer">
                <a href="#">Show all messages</a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- End Icons Navigation -->
    </header>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
      <ul class="sidebar-nav" id="sidebar-nav">
        <!-- Dashboard -->
        <li class="nav-item">
                    <a class="nav-link" >
                        <i class="bi bi-grid"></i>
                        <span>Response</span>
                    </a>
                </li>

        <!-- Test List -->
        <li class="nav-item">
          <a class="nav-link" href="EvaluationList.php">
            <i class="bi bi-card-list"></i>
            <span>Response List</span>
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
          <a class="nav-link" href="index.php">
            <i class="bi bi-box-arrow-in-right"></i>
            <span>Home</span>
          </a>
        </li>Main Page -->
      </ul>
    </aside>
    <!-- End Sidebar -->

    <main id="main" class="main">
      <div class="pagetitle">
        <h1>Response</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Evaluation</li>
          </ol>
        </nav>
      </div>
      <!-- End Page Title -->

      <!-- Begin Page Content -->
      <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800">Add a Response</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
          <!-- Form for Adding a Test -->
          <div class="col-xl-12 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  
               <!-- <form action="" method="POST">
        <label for=""> Subject </label>
        <input type="text" name="matiere">

        <label for=""> Duration </label>
        <input type="number" name="duree">
        
        <label for="">Max Score</label>
        <input type="date" name="date2">


        <label for="">Date</label>
        <input type="number" name="noteMax">

       
        <label for="">Description</label>
        <input type="text" name="description2">

        <input type="submit" value="OK">
    </form>
-->

                   
                         <form action="" method="POST">
                            <label for="id">ID Evaluation:</label><br>
                            <input class="form-control form-control-user" id="id" type="number" name="id"><br>
                            <span id="id_error"></span><br>

                            
                            <label for="iduser">ID User:</label><br>
                            <input class="form-control form-control-user" id="iduser" type="number" name="iduser"><br>
                            <span id="iduser_error"></span><br>


                            <label for="rep1">Answer 1:</label><br>
                            <textarea class="form-control form-control-user" id="rep1" name="rep1" rows="4" cols="50"></textarea><br>
                            <span id="rep1_error"></span><br>


                            <label for="rep2">Answer 2:</label><br>
                            <textarea class="form-control form-control-user" id="rep2" name="rep2" rows="4" cols="50"></textarea><br>
                            <span id="rep2_error"></span><br>


                            <label for="rep3">Answer 3:</label><br>
                            <textarea class="form-control form-control-user" id="rep3" name="rep3" rows="4" cols="50"></textarea><br>
                            <span id="rep3_error"></span><br>


                            <label for="rep4">Answer 4:</label><br>
                            <textarea class="form-control form-control-user" id="rep4" name="rep4" rows="4" cols="50"></textarea><br>
                            <span id="rep4_error"></span><br>


                            <label for="rep5">Answer 5:</label><br>
                            <textarea class="form-control form-control-user" id="rep5" name="rep5" rows="4" cols="50"></textarea><br>
                            <span id="rep5_error"></span><br>


                            <label for="note">Score:</label><br>
                            <input class="form-control form-control-user" id="note" type="number" name="note"><br>
                            <span id="note_error"></span><br>


                            <label for="remarque">Remark:</label><br>
                            <textarea class="form-control form-control-user" id="remarque" name="remarque" rows="4" cols="50"></textarea><br>
                            <span id="remarque_error"></span><br>


                            <label for="statusnote">Statut de la note:</label><br>
                            <input type="checkbox" name="statusnote" value="1"><br>
                            <span id="statusnote_error"></span><br>


                            <button type="submit" 
                                                class="btn btn-primary btn-user btn-block" 
                                                onClick="validerFormulaire()"
                                                >Add Answer</button></form>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Page Content -->
    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
      <div class="copyright">
        &copy; Copyright <strong><span>2024 NexDegree</span></strong>. All Rights Reserved
      </div>
    </footer>
    <!-- End Footer -->




    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
      <i class="bi bi-arrow-up-short"></i>
    </a>
    <!-- Custom JS -->
    <script src="js/addReponse.js"></script>

    <!-- JS Files -->
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
