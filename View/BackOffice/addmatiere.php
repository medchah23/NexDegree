

<?php
include_once(__DIR__ . '/../../Controller/matiere_controller.php');

$controller = new matiere_controller();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
      $nom = $_POST['nom'];
      $description = $_POST['description'];
      $credit = $_POST['credit'];
      $sems = $_POST['sems'];
      $niveau = $_POST['niveau'];
      $prerequis = $_POST['prerequis'];
      $nombre_chapitre = $_POST['nombre_chapitre'];

      $matiere = new matiere(
        null,
        $nom, 
        $description, 
        $credit, 
        $sems, 
        $niveau,
        $prerequis,
         $nombre_chapitre
    ); 
    
        $controller->add_matiere($matiere );  

        
    } else {
        echo "Invalid matiere ID.";
        exit;
    }
}


?>






<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Forms / Elements - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
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
    
  <!-- End Dashboard Nav -->

  
  

  

</aside><!-- End Sidebar-->
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
        
      <!-- End Dashboard Nav -->

      
      

      

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Add Matiere</h1>
      <nav>
        
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">

              

















            <!-- General Form Elements -->
            

            <form action="addmatiere.php" method="POST" id="myform">
<br>
    <div class="row mb-3">
        <label for="Nom" class="col-sm-2 col-form-label">Nom</label>
        <div class="col-sm-10">
            <input type="text" name="nom" class="form-control" id="nom"  >
        </div>
    </div>
    
    

    <div class="row mb-3">
        <label for="description" class="col-sm-2 col-form-label">description</label>
        <div class="col-sm-10">
            <textarea type="text" name="description" class="form-control"  id="description"></textarea>
        </div>
    </div>
    <div class="row mb-3">
        <label for="credit" class="col-sm-2 col-form-label">credit</label>
        <div class="col-sm-10">
            <input type="text" name="credit" class="form-control"  id="credit">
        </div>
    </div>
    <div class="row mb-3">
        <label for="sems" class="col-sm-2 col-form-label">sems</label>
        <div class="col-sm-10">
            <input type="text" name="sems" class="form-control" id="sems">
        </div>
    </div>
    <div class="row mb-3">
        <label for="niveau" class="col-sm-2 col-form-label">Niveau</label>
        <div class="col-sm-10">
            <input type="text" name="niveau" class="form-control"  id="niveau">
        </div>
    </div>
    <div class="row mb-3">
        <label for="prerequis" class="col-sm-2 col-form-label">prerequis</label>
        <div class="col-sm-10">
            <textarea type="text" name="prerequis" class="form-control"  id="prerequis"></textarea>
        </div>
    </div>
    
    <div class="row mb-3">
        <label for="nombre_chapitre" class="col-sm-2 col-form-label">Nombre De Chapitre</label>
        <div class="col-sm-10">
            <input type="text" name="nombre_chapitre"  class="form-control" id="nombre_chapitre">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-10">
            <input type="submit" name="submit" class="btn btn-primary" value="Add Matiere">
        </div>
    </div>
</form>


            
            <!-- End General Form Elements -->

            </div>
          </div>

        </div>
        <script>
   document.getElementById("myform").addEventListener("submit", function (event) {
    let errors = [];
    
    const nom = document.getElementById("nom").value.trim();
    if (nom === "") {
        errors.push("Nom doit être rempli.");
    }

    const description = document.getElementById("description").value.trim();
    if (description === "") {
        errors.push("description doit être rempli.");
    }
    const credit = document.getElementById("credit").value.trim();

    if (!credit || isNaN(credit) || credit <= 0) {
        errors.push("Credit est invalid ");
    }

    const nombre_chapitre = document.getElementById("nombre_chapitre").value.trim();

    if (!nombre_chapitre || isNaN(nombre_chapitre) || nombre_chapitre <= 0) {
        errors.push("nombre de chapitre est invalid ");
    }

    const sems = document.getElementById("sems").value.trim();

    if (!sems || isNaN(sems) || sems <= 0) {
        errors.push("sems est invalid ");
    }
    const niveau = document.getElementById("niveau").value.trim();

    if (!niveau || isNaN(niveau) || niveau <= 0) {
        errors.push("niveau est invalid ");
    }
   

    const prerequis = document.getElementById("prerequis").value.trim();
    if (prerequis === "") {
        errors.push("prerequis doit être rempli.");
    }

    
    
    if (errors.length > 0) {
        event.preventDefault(); 
        alert(errors.join("\n")); 
    }
});

</script>
        

        
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