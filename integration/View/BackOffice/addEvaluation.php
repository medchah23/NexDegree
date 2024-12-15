<?php
include '../../Controller/EvaluationController.php';
//isset : true si la variable existe et n'est pas nulle
//post  : méthode essentielle pour interagir avec les formulaires HTML.
if(isset($_POST['matiere'])&& isset($_POST['duree'])&& isset($_POST['noteMax'])&& isset($_POST['date2'])&& isset($_POST['quest1']) && isset($_POST['quest2']) && isset($_POST['quest3']) && isset($_POST['quest4']) && isset($_POST['quest5'])){
    if(!empty($_POST['matiere'])&& !empty($_POST['duree'])&& !empty($_POST['noteMax'])&& !empty($_POST['date2'])&& !empty($_POST['quest1']) && !empty($_POST['quest2']) && !empty($_POST['quest3']) && !empty($_POST['quest4']) && !empty($_POST['quest5'])){
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
     $_POST['quest5']);
     
     $evalC =new EvaluationController();
     $evalC->addEvaluation($eval);
  header('Location:EvaluationList.php');
  header('index.php');

  

    }}
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
    <link href="assets/img/icon.png" rel="icon">


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
        <a class="nav-link collapsed" href="EvaluationList.php">
          <i class="bi bi-grid"></i>
          <span>Evaluation list</span>
        </a>
        </li> 
        <li class="nav-item">
        <a class="nav-link collapsed" href="addEvaluation.php">
          <i class="bi bi-grid"></i>
          <span>Add Evaluation</span>
        </a>
        </li> 

      <!-- End Dashboard Nav -->
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
      <!-- End Page Title -->

      <!-- Begin Page Content -->
      <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800">Add a Test</h1>
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

                   
                  <form  action="" method="POST" id="formAdd">

                    <label for="">Subject:</label><br>
                        <select class="form-control form-control-user"  name="matiere" >
                              <option value="Maths">Maths</option>
                              <option value="Physics">Physics</option>
                               <option value="Informatique">Informatique</option>
                        </select>
                    <span id="matiere_error"></span><br>

                    <label for="duree">Duration(minutes):</label><br>
                    <input class="form-control form-control-user" id="duree" type="number"  name="duree" >
                     <span id="duree_error" style="color: red;"></span><br>

                      <label for="noteMax">MaxScore:</label><br>
                         <input class="form-control form-control-user" id="noteMax" type="number"  name="noteMax" >
                           <span id="noteMax_error" style="color: red;"></span><br>

                           <label for="date2">Date:</label><br>
                           <input class="form-control form-control-user" id="date2" type="date"  name="date2" >
                              <span id="date_error" style="color: red;"></span><br>

                  
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
                        >Add Evaluation</button>



                  </form>
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
    <script src="js/addEvaluation.js"></script>

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
