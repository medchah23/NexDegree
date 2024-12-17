<?php
require_once "../../Controller/ReponseController.php";
require_once "../../Controller/EvaluationController.php";

$reponseController = new ReponseController();
$evaluationController = new EvaluationController();

if(isset($_GET['id_reponse'])){
    $reponse = $reponseController->getReponse($_GET['id_reponse']);
    $evaluation = $evaluationController->getEvaluation($reponse['id']);
} else if(
    isset($_POST['id_reponse']) && isset($_POST['rep1']) && isset($_POST['rep2']) && isset($_POST['rep3'])
    && isset($_POST['rep4']) && isset($_POST['rep5'])
){
    $rp = new reponse(
        $_POST['id_reponse'],
        $_POST['rep1'],
        $_POST['rep2'],
        $_POST['rep3'],
        $_POST['rep4'],
        $_POST['rep5']
    );
    $reponseController->updateReponse($rp);
    header("Location:index.php");
} else
    header("Location:index.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>NexDegree </title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Free HTML Templates" name="keywords" />
    <meta content="Free HTML Templates" name="description" />
    <link href="img/icon.png" rel="icon"> 


    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon" />

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

    <!-- Flaticon Font -->
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet" />

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet" />

  <!-- Smooth Scrolling -->
  <style>
      html {
        scroll-behavior: smooth;
      }
    </style>




  </head>

  <body>
    <!-- Navbar Start -->
    
    <!-- Navbar End -->

    <!-- Header Start -->
    <div class="container-fluid bg-primary mb-5">
      <div
        class="d-flex flex-column align-items-center justify-content-center"
        style="min-height: 400px"
      >
        <h3 class="display-3 font-weight-bold text-white">Modifier le Test</h3>
        <div class="d-inline-flex text-white">
          
        </div>
      </div>
    </div>
<main id="content" style="padding: 40px 20px;">



    <div class="container">

        <?php if ($evaluation): ?>
            <h3>Test ID: <?php echo $evaluation['id']; ?></h3>
            <p>Subject: <?php echo $evaluation['matiere']; ?></p>
            <p>Duration: <?php echo $evaluation['duree']; ?> minutes</p>
            <p>Max Score: <?php echo $evaluation['noteMax']; ?></p>
            <p>Test Date: <?php echo $evaluation['date2']; ?></p>


        <?php else: ?>
            <p>No test found with that ID.</p>
        <?php endif; ?>
    </div>






    <h1>   <p>Subject: <?php echo $evaluation['matiere']; ?></p> </h1>
    <form action="modifierReponse.php" method="post" id="reponseForm">
        <input type="number" name="id_reponse" value="<?php echo $reponse['idrep']; ?>" hidden>
        <!-- Question 1 -->
        <div style="margin-bottom: 20px;">
            <p>Question 1 : <?php echo $evaluation['quest1']; ?></p>
            <label for="question1">Votre réponse :</label>
            <textarea id="question1" name="rep1" rows="2" cols="50" style="width: 100%; padding: 10px;"><?php echo $reponse['rep1']; ?></textarea>
            <span id="quest1_error" style="color: red;"></span>
        </div>
        <!-- Question 2 -->
        <div style="margin-bottom: 20px;">
            <p>Question 2 : <?php echo $evaluation['quest2']; ?></p>
            <label for="question2">Votre réponse :</label>
            <textarea id="question2" name="rep2" rows="2" cols="50" style="width: 100%; padding: 10px;"><?php echo $reponse['rep2']; ?></textarea>
            <span id="quest2_error" style="color: red;"></span>
        </div>
        <!-- Question 3 -->
        <div style="margin-bottom: 20px;">
            <p>Question 3 :<?php echo $evaluation['quest3']; ?></p>
            <label for="question3">Votre réponse :</label>
            <textarea id="question3" name="rep3" rows="2" cols="50" style="width: 100%; padding: 10px;"><?php echo $reponse['rep3']; ?></textarea>
            <span id="quest3_error" style="color: red;"></span>
        </div>
        <!-- Question 4 -->
        <div style="margin-bottom: 20px;">
            <p>Question 4 :<?php echo $evaluation['quest4']; ?></p>
            <label for="question4">Votre réponse :</label>
            <textarea id="question4" name="rep4" rows="2" cols="50" style="width: 100%; padding: 10px;"><?php echo $reponse['rep4']; ?></textarea>
            <span id="quest4_error" style="color: red;"></span>
        </div>
        <!-- Question 5 -->
        <div style="margin-bottom: 20px;">
            <p>Question 5 :<?php echo $evaluation['quest5']; ?></p>
            <label for="question5">Votre réponse :</label>
            <textarea id="question5" name="rep5" rows="2" cols="50" style="width: 100%; padding: 10px;"><?php echo $reponse['rep5']; ?></textarea>
            <span id="quest5_error" style="color: red;"></span>
        </div>
        <!-- Submit Button -->
        <button type="submit" style="padding: 10px 20px; background-color: #007bff; color: #fff; border: none;">Modifier</button>
    </form>
</main>

<!-- Footer Start -->
<div
    class="container-fluid bg-secondary text-white mt-5 py-5 px-sm-3 px-md-5"
>

    <div
        class="container-fluid pt-5"
        style="border-top: 1px solid rgba(23, 162, 184, 0.2)"
    >
        <p class="m-0 text-center text-white">
            &copy;
            <a class="text-primary font-weight-bold" href="#">NexDegree</a>.
            All Rights Reserved.


            >
        </p>
    </div>
</div>
<!-- Footer End -->

<!-- Back to Top -->
<a href="#" class="btn btn-primary p-3 back-to-top"
><i class="fa fa-angle-double-up"></i
    ></a>

<!-- JavaScript Libraries -->
<script src="js/reponse.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/isotope/isotope.pkgd.min.js"></script>
<script src="lib/lightbox/js/lightbox.min.js"></script>

<!-- Contact Javascript File -->
<script src="mail/jqBootstrapValidation.min.js"></script>
<script src="mail/contact.js"></script>

<!-- Template Javascript -->
<script src="js/main.js"></script>
</body>
</html>



