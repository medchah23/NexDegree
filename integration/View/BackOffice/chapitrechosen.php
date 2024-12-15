<?php 
include(__DIR__ . '/../../Controller/chapitre_controller.php');

if (!isset($_GET['id_matiere'])) {
    // Redirect back if no matière is selected
    header('Location: index.php');
    exit();
}

$id_matiere = intval($_GET['id_matiere']);

// Fetch chapters for the selected matière
$chapitreController = new chapitre_controller();
$chapitres = $chapitreController->get_chapitres_by_matiere($id_matiere);

$sql_matiere = "SELECT nom FROM matiere WHERE id_matiere = ?";
$db = config::getConnexion();
$query_matiere = $db->prepare($sql_matiere);
$query_matiere->execute([$id_matiere]);
$matiere_name = $query_matiere->fetchColumn();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/icon.png" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <img src="assets/img/nexdegree.png" alt="">
        
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        
        <li class="nav-item dropdown">

          

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">K. Anderson</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>Kevin Anderson</h6>
              <span>Web Designer</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  
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

  
  

  

</aside>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Chapitres</h1>
      
    </div><!-- End Page Title -->
    
    







    
    <!--AFFICHE CHAPITRE-->



<section class="section">




          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Table with stripped rows</h5>

              <!-- Table with stripped rows -->

              <table class="table table-striped">
    <thead>
        <tr>
            <th>Title</th>
            <th>Content</th>
            <th>Start Date</th>
            <th>Duration</th>
            <th>Objective</th>
            <th>Activity</th>
            <th>Supplementary Resources</th>
            <th>Evaluation Included</th>
            <th>Evaluation Type</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($chapitres as $chapter): ?>
            <tr>
                <td><?= htmlspecialchars($chapter['titre']); ?></td>
                <td>
    <?php if (isset($chapter['contenu']) && !empty($chapter['contenu']) && file_exists("../uploads/" . $chapter['contenu'])): ?>
        <a href="../uploads/<?= htmlspecialchars($chapter['contenu']); ?>" download="<?= htmlspecialchars($chapter['contenu']); ?>">Download PDF</a>
    <?php else: ?>
        <span class="text-danger">No file uploaded</span>
    <?php endif; ?>
            </td>

                <td><?= htmlspecialchars($chapter['date_debut']); ?></td>
                <td><?= htmlspecialchars($chapter['duree']); ?></td>
                <td><?= htmlspecialchars($chapter['objectif']); ?></td>
                <td><?= htmlspecialchars($chapter['activite']); ?></td>
                <td><?= htmlspecialchars($chapter['res_supp']); ?></td>
                <td><?= $chapter['evaluation_incluse'] ? 'Yes' : 'No'; ?></td>
                <td>
                    <?php
                    echo ($chapter['evaluation_incluse'] == 0 || $chapter['evaluation_incluse'] == 'No') ? 'NONE' : htmlspecialchars($chapter['type_de_evaluation']);
                    ?>
                </td>
                <td>
                    <a href="updateChapter.php?id_chapitre=<?= htmlspecialchars($chapter['id_chapitre']); ?>">Update</a>
                </td>
                <td>
                    <a href="delete.php?id_chapitre=<?= htmlspecialchars($chapter['id_chapitre']); ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>



            </div>
          </div>

          

        </div>
      </div>
    </section>



   
















  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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