








<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>NexDegree </title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Free HTML Templates" name="keywords" />
    <meta content="Free HTML Templates" name="description" />
    <link rel="icon" href="logo web.png" type="image/png" />


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
    <div class="container-fluid bg-light position-relative shadow">
      <nav
        class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5"
      >
        <a
          href=""
          class="navbar-brand font-weight-bold text-secondary"
          style="font-size: 50px"
        >
          <i class="flaticon-043-teddy-bear"></i>
          <span class="text-primary">NexDegree</span>
        </a>
        <button
          type="button"
          class="navbar-toggler"
          data-toggle="collapse"
          data-target="#navbarCollapse"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div
          class="collapse navbar-collapse justify-content-between"
          id="navbarCollapse"
        >
          <div class="navbar-nav font-weight-bold mx-auto py-0">
            <a href="index.php" class="nav-item nav-link">Home</a>
            <a href="EvaluationList.php" class="nav-item nav-link">Evaluation</a>
            <a href="#content" class="nav-item nav-link">Content</a> <!-- Nouveau lien -->
            
         
      </nav>
    </div>
    <!-- Navbar End -->

    <!-- Header Start -->
    <div class="container-fluid bg-primary mb-5">
      <div
        class="d-flex flex-column align-items-center justify-content-center"
        style="min-height: 400px"
      >
        <h3 class="display-3 font-weight-bold text-white">Evaluation</h3>
        <div class="d-inline-flex text-white">
          <p class="m-0"><a class="text-white" href="">Home</a></p>
          <p class="m-0 px-2">/</p>
          <p class="m-0">Evaluation</p>
        </div>
      </div>
    </div>
    <!-- Header End -->

    <main id="content" style="padding: 40px 20px;">

    <h1> French Test </h1>
    <form action="submit_test.php" method="post">
      <!-- Question 1 -->
      <div style="margin-bottom: 20px;">
        <p>Question 1 : Quelle est la différence entre le passé composé et l'imparfait ?</p>
        <label for="question1">Votre réponse :</label>
        <textarea id="question1" name="question1" rows="2" cols="50" style="width: 100%; padding: 10px;"></textarea>
      </div>
      <!-- Question 2 -->
      <div style="margin-bottom: 20px;">
        <p>Question 2 : Qu'est-ce qu'une métaphore ?</p>
        <label for="question2">Votre réponse :</label>
        <textarea id="question2" name="question2" rows="2" cols="50" style="width: 100%; padding: 10px;"></textarea>
      </div>
      <!-- Question 3 -->
      <div style="margin-bottom: 20px;">
        <p>Question 3 Citez trois types de propositions subordonnées.</p>
        <label for="question1">Votre réponse :</label>
        <textarea id="question1" name="question1" rows="2" cols="50" style="width: 100%; padding: 10px;"></textarea>
      </div>
      <!-- Question 4 -->
      <div style="margin-bottom: 20px;">
        <p>Question 4 :Quel est le rôle d'un adjectif dans une phrase ?</p>
        <label for="question1">Votre réponse :</label>
        <textarea id="question1" name="question1" rows="2" cols="50" style="width: 100%; padding: 10px;"></textarea>
      </div>
      <!-- Question 5 -->
      <div style="margin-bottom: 20px;">
        <p>Question 5 :Comment conjuguer le verbe "être" au présent de l'indicatif ?</p>
        <label for="question1">Votre réponse :</label>
        <textarea id="question1" name="question1" rows="2" cols="50" style="width: 100%; padding: 10px;"></textarea>
      </div>
      <!-- Submit Button -->
      <button type="submit" style="padding: 10px 20px; background-color: #007bff; color: #fff; border: none;">Soumettre</button>
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



