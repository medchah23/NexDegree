

<?php
include_once(__DIR__ . '/../../Controller/chapitre_controller.php');

$controller = new chapitre_controller();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['id_chapitre']) && !empty($_POST['id_chapitre'])) {
        $id_chapitre = $_POST['id_chapitre'];

        $update_success = $controller->update_chapitre($id_chapitre);  

        if ($update_success) {
            header('Location: index.php');
            exit;
        } else {
            echo "Failed to update the chapter. Please try again.";
        }
    } else {
        echo "Invalid chapter ID.";
        exit;
    }
}

if (isset($_GET['id_chapitre']) && !empty($_GET['id_chapitre'])) {
    $id_chapitre = $_GET['id_chapitre'];

    $chapitre = $controller->getChapitreById($id_chapitre);

    if (!$chapitre) {
        echo "Chapter not found!";
        exit;
    }
} else {
    echo "id_chapitre not found in URL.";
    exit;
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

    <!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      
        

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
        </ul>
      <!-- End Dashboard Nav -->

      

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Add Chapter</h1>
      <nav>
        <ol class="breadcrumb">
          
          <li class="breadcrumb-item active">Add Chapter</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">

              

















            <!-- General Form Elements -->
            

            <form action="updateChapter.php?id_chapitre=<?php echo $id_chapitre; ?>" method="POST" id="myform" enctype="multipart/form-data">
            <input type="hidden" name="id_chapitre" value="<?php echo htmlspecialchars($chapitre['id_chapitre']); ?>">

    <div class="row mb-3">
        <label for="titre" class="col-sm-2 col-form-label">Titre</label>
        <div class="col-sm-10">
            <input type="text" name="titre" class="form-control" id="titre" value="<?php echo htmlspecialchars($chapitre['titre']); ?>"  >
        </div>
    </div>
    
    <div class="row mb-3">
    <label for="contenu" class="col-sm-2 col-form-label">Upload PDF</label>
    <div class="col-sm-10">
        <input type="file" name="contenu" class="form-control"  id="contenu" accept=".pdf" >
    </div>
</div>

    <div class="row mb-3">
        <label for="date_debut" class="col-sm-2 col-form-label">Date Début</label>
        <div class="col-sm-10">
            <input type="date" name="date_debut" class="form-control" value="<?php echo htmlspecialchars($chapitre['date_debut']); ?>"  id="date_debut">
        </div>
    </div>
    <div class="row mb-3">
        <label for="objectif" class="col-sm-2 col-form-label">Duree</label>
        <div class="col-sm-10">
            <input type="text" name="duree" class="form-control" value="<?php echo htmlspecialchars($chapitre['duree']); ?>" id="duree">
        </div>
    </div>
    <div class="row mb-3">
        <label for="objectif" class="col-sm-2 col-form-label">Objectif</label>
        <div class="col-sm-10">
            <input type="text" name="objectif" class="form-control" value="<?php echo htmlspecialchars($chapitre['objectif']); ?>" id="objectif">
        </div>
    </div>
    <div class="row mb-3">
        <label for="activite" class="col-sm-2 col-form-label">Activité</label>
        <div class="col-sm-10">
            <input type="text" name="activite" class="form-control" value="<?php echo htmlspecialchars($chapitre['activite']); ?>" id="activite">
        </div>
    </div>
    <div class="row mb-3">
        <label for="res_supp" class="col-sm-2 col-form-label">Ressources supplémentaires</label>
        <div class="col-sm-10">
            <input type="text" name="res_supp" class="form-control" value="<?php echo htmlspecialchars($chapitre['res_supp']); ?>" id="res_supp">
        </div>
    </div>
    <div class="row mb-3">
        <legend class="col-form-label col-sm-2 pt-0">Evaluation incluse</legend>
        <div class="col-sm-10">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="evaluation_incluse" <?php echo ($chapitre['evaluation_incluse'] == 1) ? 'checked' : ''; ?> id="evaluation_incluse">
                
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <label for="type_de_evaluation" class="col-sm-2 col-form-label">Type de Evaluation</label>
        <div class="col-sm-10">
            <input type="text" name="type_de_evaluation" value="<?php echo htmlspecialchars($chapitre['type_de_evaluation']); ?>" class="form-control" id="type_de_evaluation">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-10">
            <input type="submit" name="submit" class="btn btn-primary" value="Update Chapter">
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
    
    const activite = document.getElementById("activite").value.trim();
    if (activite === "") {
        errors.push("Activité doit être rempli.");
    }
    const duree = document.getElementById("duree").value.trim();

    if (!duree || isNaN(duree) || duree <= 0) {
        errors.push("Veuillez entrer une durée valide (nombre positif).");
    }
   

    const dateInput = document.getElementById('date_debut');
    if (!dateInput.value) {
        errors.push("Veuillez sélectionner une date de début.");
    } 

    /**const fileInput = document.getElementById('contenu');
    if (!fileInput.files.length) {
        errors.push("Veuillez uploader un fichier.");
    } else {
        const file = fileInput.files[0];

        const allowedFileTypes = ['application/pdf'];
        if (!allowedFileTypes.includes(file.type)) {
            errors.push("Le fichier doit être un PDF.");
        }

        const maxSizeInBytes = 5 * 1024 * 1024; // 5MB
        if (file.size > maxSizeInBytes) {
            errors.push("Le fichier doit être inférieur à 5MB.");
        }
    }*/


    

    const objectif = document.getElementById("objectif").value.trim();
    if (objectif === "") {
        errors.push("Objectif doit être rempli.");
    }

    const resSupp = document.getElementById("res_supp").value.trim();
    if (resSupp === "") {
        errors.push("Ressources supplémentaires doit être rempli.");
    }

    const evaluationIncluse = document.getElementById("evaluation_incluse").checked;
    const typeDeEvaluation = document.getElementById("type_de_evaluation").value.trim();
    if (evaluationIncluse && typeDeEvaluation === "") {
        errors.push("Type de Evaluation doit être rempli si 'Evaluation incluse' est cochée.");
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