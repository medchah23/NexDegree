<?php
include_once ("../../controller/UserController.php");
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../FrontOffice/html/sign_in.html");
    exit();
}
include(__DIR__ . '/../../Controller/chapitre_controller.php');
$chapitreController = new chapitre_controller();
$list = $chapitreController->show_all_chapitre(); 
$sql_matiere = "SELECT id_matiere, nom FROM matiere";
$db = config::getConnexion();
$query_matiere = $db->query($sql_matiere);
$matieres = $query_matiere->fetchAll();
include '../../controller/PostController.php';
$postC = new PostController();
$postsList = $postC->listPosts();

include '../../controller/CommentController.php';
$commentC = new CommentController();
$commentsList = $commentC->listComments();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard</title>
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
    </div><

    

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
              <a class="dropdown-item d-flex align-items-center" href="php/profile.php">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
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
              <a class="dropdown-item d-flex align-items-center" href="php/logout.php">
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

      <!-- End Dashboard Nav -->

      
      

      

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      
    </div><!-- End Page Title -->
    
    



    <script>
   document.getElementById("myform").addEventListener("submit", function (event) {
    let errors = [];
    
    const idMatiere = document.querySelector("select[name='id_matiere']").value;
    if (idMatiere === "") {
        errors.push("Veuillez sélectionner une Matière.");
    }
    });
</script>


    
    <!--AFFICHE CHAPITRE-->



<section class="section">

<section class="section">
  <form action="chapitrechosen.php" method="GET">
    <div class="row mb-3">
      <label class="col-sm-2 col-form-label">Select Matière</label>
      <div class="col-sm-10">
        <select name="id_matiere" class="form-select" aria-label="Default select example" required>
          <option value="">Select Matière</option>
          <?php foreach ($matieres as $matiere): ?>
            <option value="<?= $matiere['id_matiere'] ?>"><?= $matiere['nom'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-sm-10">
        <button type="submit" class="btn btn-primary">View Chapters</button>
      </div>
    </div>
  </form>
</section>

<section class="section dashboard">
      <div class="row">
        <div class="col-lg-12">
          <h2>Posts Overview</h2>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Title</th>
                <th>Content</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($postsList as $post) { ?>
              <tr>
                <td><?php echo htmlspecialchars($post['title']); ?></td>
                <td><?php echo htmlspecialchars(mb_strimwidth($post['content'], 0, 100, '...')); ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-lg-12">
        <h2>Comments Overview</h2>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Comment ID</th>
              <th>Post ID</th>
              <th>User ID</th>
              <th>Content</th>
              <th>Created At</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($commentsList as $comment) { ?>
            <tr>
              <td><?php echo htmlspecialchars($comment['comment_id']); ?></td>
              <td><?php echo htmlspecialchars($comment['post_id']); ?></td>
              <td><?php echo htmlspecialchars($comment['user_id']); ?></td>
              <td><?php echo htmlspecialchars(mb_strimwidth($comment['content'], 0, 100, '...')); ?></td>
              <td><?php echo htmlspecialchars($comment['created_at']); ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </section>

         
    </section>



   
















  </main><!-- End #main -->

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