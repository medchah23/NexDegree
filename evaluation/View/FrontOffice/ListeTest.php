<?php
include '../../controller/EvaluationController.php';
$evaluationControl = new EvaluationController();
$list = $evaluationControl->listEvaluation();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>NexDegree</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Free HTML Templates" name="keywords" />
    <meta content="Free HTML Templates" name="description" />
    <link rel="icon" href="logo web.png" type="image/png"  />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
      href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito&display=swap"
      rel="stylesheet"
    />

    <!-- Font Awesome -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
      rel="stylesheet"
    />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet" />
  </head>

  <body>
    <!-- Navbar Start -->
    <div class="container-fluid bg-light position-relative shadow">
      <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5">
        <a href="index.php" class="navbar-brand">
          <img src="logo web.png" alt="Logo" style="height: 50px;" />
        </a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
          <div class="navbar-nav font-weight-bold mx-auto py-0">
            <a href="index.php" class="nav-item nav-link">Home</a>
            <a href="EvaluationList.php" class="nav-item nav-link">Evaluation</a>
          </div>
        </div>
      </nav>
    </div>
    <!-- Navbar End -->

    <!-- Header Start -->
    <div class="container-fluid bg-primary mb-5">
      <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
        <h3 class="display-3 font-weight-bold text-white">Available Tests</h3>
        <div class="d-inline-flex text-white">
          <p class="m-0"><a class="text-white" href="index.php">Home</a></p>
          <p class="m-0 px-2">/</p>
          <p class="m-0">Tests</p>
        </div>
      </div>
    </div>
    <!-- Header End -->

    <!-- Test Links Start -->
    <main style="padding: 40px 20px; text-align: center">
  <h2>Available Tests for the Selected Subject</h2>
  <div style="margin-top: 20px;">
    <?php foreach ($list as $evaluation): ?>
      <p>
        <a
          href="testfrancais.php?test_id=<?php echo $evaluation['evaluationID']; ?>"
          style="text-decoration: none; color: #007bff; font-size: 18px;"
        >
          Test ID: <?php echo $evaluation['evaluationID']; ?> <!-- Affichage de l'ID du test -->
        </a>
      </p>
    <?php endforeach; ?>
  </div>
</main>
    <!-- Test Links End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-secondary text-white mt-5 py-5 px-sm-3 px-md-5">
      <div class="container-fluid pt-5" style="border-top: 1px solid rgba(23, 162, 184, 0.2)">
        <p class="m-0 text-center text-white">
          &copy; <a class="text-primary font-weight-bold" href="#">NexDegree</a>. All Rights Reserved.
        </p>
      </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary p-3 back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
