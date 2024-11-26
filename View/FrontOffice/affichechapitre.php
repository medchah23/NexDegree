<?php 
include(__DIR__ . '/../../Controller/chapitre_controller.php');

if (!isset($_GET['id_matiere'])) {
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

  <title>Chapters</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/icon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

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
    <a class="nav-link collapsed" href="affichematiere.php">
      <i class="bi bi-grid"></i>
      <span>Matiere</span>
    </a>
    
    
  <!-- End Dashboard Nav -->

  
  

  

</aside><!-- End Sidebar-->

  <main id="main" class="main">




    
    <!--AFFICHE CHAPITRE-->



    <section class="section">
    <h1 class="mb-4">Chapters for Subject: <?= htmlspecialchars($matiere_name) ?></h1>

    <?php if (empty($chapitres)): ?>
        <p class="text-muted">No chapters available for this subject.</p>
    <?php else: ?>
        <?php foreach ($chapitres as $chapitre): ?>
            <div class="card mb-4">
                <div class="card-header">
                    Chapter: <?= htmlspecialchars($chapitre['titre']) ?>
                </div>
                <div class="card-body">
                    <ul>
                        <li>Date Start: <?= isset($chapitre['date_debut']) ? htmlspecialchars($chapitre['date_debut']) : 'N/A'; ?></li>
                        <li>Duration: <?= isset($chapitre['duree']) ? htmlspecialchars($chapitre['duree']) : 'N/A'; ?></li>
                        <li>Objective: <?= isset($chapitre['objectif']) ? htmlspecialchars($chapitre['objectif']) : 'N/A'; ?></li>
                        <li>Activity: <?= isset($chapitre['activite']) ? htmlspecialchars($chapitre['activite']) : 'N/A'; ?></li>
                        <li>Supplementary Resources: <?= isset($chapitre['res_supp']) ? htmlspecialchars($chapitre['res_supp']) : 'N/A'; ?></li>
                        <li>Evaluation Included: <?= isset($chapitre['evaluation_incluse']) && $chapitre['evaluation_incluse'] ? 'Yes' : 'No'; ?></li>
                        <li>Evaluation Type: 
                            <?= isset($chapitre['type_de_evaluation']) && $chapitre['evaluation_incluse'] ? htmlspecialchars($chapitre['type_de_evaluation']) : 'NONE'; ?>
                        </li>
                    </ul>
                </div>
                <div class="card-footer">
                <?php if (isset($chapitre['contenu']) && !empty($chapitre['contenu']) && file_exists("../uploads/" . $chapitre['contenu'])): ?>
        <a href="../uploads/<?= htmlspecialchars($chapitre['contenu']); ?>" download="<?= htmlspecialchars($chapitre['contenu']); ?>">Download PDF</a>
    <?php else: ?>
        <span class="text-danger">No file uploaded</span>
    <?php endif; ?>
</div>

            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>



   










  </main>

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NexDegree</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
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