<?php
include '../../controller/QuizController.php';
$quizController = new QuizController();
$quizzes = $quizController->listQuizzes();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8" />
    <title>KidKinder - Kindergarten Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Free HTML Templates" name="keywords" />
    <meta content="Free HTML Templates" name="description" />
    <!-- Favicon-->
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
</head>

</head>
<body id="page-top">
    <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#page-top">
                <img class="navbar-brand" src="img/esprit.png" alt="logo-esprit" width="100%" height="30%"/>
            </a>
            <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#portfolio">Quizzes</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#about">About</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#contact">Contact</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="./../BackOffice/quizList.php">Dashboard</a></li>
                </ul>
            </div>
        </div>
    </nav>

  <!-- Header Start -->
  <div class="container-fluid bg-primary px-0 px-md-5 mb-5">
      <div class="row align-items-center px-3">
        <div class="col-lg-6 text-center text-lg-left">
          <h4 class="text-white mb-4 mt-5 mt-lg-0">Quiz Portal</h4>
          <h1 class="display-3 font-weight-bold text-white">
            New Approach to Kids Education
          </h1>
          <p class="text-white mb-4">
          Test Your Knowledge - Multiple Topics</p>
       
        </div>
        <div class="col-lg-6 text-center text-lg-right">
          <img class="img-fluid mt-5" src="img/x.png" alt="" />
        </div>
      </div>
    </div>
    <!-- Header End -->
   <!-- Class Start -->
   <section class="page-section portfolio" id="portfolio">
<div class="container-fluid pt-5">
  <div class="container">
    <div class="text-center pb-2">
      <p class="section-title px-5">
        <span class="px-2">Available Quizzes</span>
      </p>
      <h1 class="mb-4">Explore Our Quizzes</h1>
    </div>
    <div class="row">
      <!-- Replace this block with dynamic PHP code for each quiz -->
      <?php foreach ($quizzes as $quiz): ?>
  <div class="col-lg-4 mb-5">
    <div class="card border-0 bg-light shadow-sm pb-2">
      <div class="card-body text-center">
        <h4 class="card-title"><?= htmlspecialchars($quiz['title']) ?></h4>
        <p class="card-text"><?= htmlspecialchars($quiz['description']) ?></p>
      </div>
      <div class="card-footer bg-transparent py-4 px-5">
        <div class="row border-bottom">
          <div class="col-6 py-1 text-right border-right">
            <strong>Category</strong>
          </div>
          <div class="col-6 py-1"><?= htmlspecialchars($quiz['category']) ?></div>
        </div>
        <div class="row">
          <div class="col-6 py-1 text-right border-right">
            <strong>Created At</strong>
          </div>
          <div class="col-6 py-1"><?= htmlspecialchars($quiz['created_at']) ?></div>
        </div>
      </div>
      <a href="quizDetails.php?id=<?= $quiz['id'] ?>" class="btn btn-primary px-4 mx-auto mb-4">Join  Quiz</a>
    </div>
  </div>
<?php endforeach; ?>

    </div>
  </div>
</div>
</section>
<!-- Class End -->


  

<section class="page-section" id="about">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">About</h2>
        
            <div class="row justify-content-center">
                <p align="center">Our quiz portal allows users to challenge themselves across various topics.</br> 
                    Explore available quizzes and test your knowledge today!   
                </p>
            </div>
        </div>
    </section>
    <section class="page-section" id="contact">
    <div
      class="container-fluid bg-secondary text-white mt-5 py-5 px-sm-3 px-md-5"
    >
      <div class="row pt-5">
        <div class="col-lg-3 col-md-6 mb-5">
          <a
            href=""
            class="navbar-brand font-weight-bold text-primary m-0 mb-4 p-0"
            style="font-size: 40px; line-height: 40px"
          >
          <a class="navbar-brand" href="#page-top">
                <img class="navbar-brand" src="img/esprit.png" alt="logo-esprit" width="100%" height="30%"/>
            </a>
          </a>
          <p>
          A dynamic educational platform that transforms learning into an engaging and personalized experience
          guiding you through every step of your journey. 
          </p>
          <div class="d-flex justify-content-start mt-4">
            <a
              class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
              style="width: 38px; height: 38px"
              href="#"
              ><i class="fab fa-twitter"></i
            ></a>
            <a
              class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
              style="width: 38px; height: 38px"
              href="#"
              ><i class="fab fa-facebook-f"></i
            ></a>
            <a
              class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
              style="width: 38px; height: 38px"
              href="#"
              ><i class="fab fa-linkedin-in"></i
            ></a>
            <a
              class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
              style="width: 38px; height: 38px"
              href="#"
              ><i class="fab fa-instagram"></i
            ></a>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-5">
          <h3 class="text-primary mb-4">Get In Touch</h3>
          <div class="d-flex">
            <h4 class="fa fa-map-marker-alt text-primary"></h4>
            <div class="pl-3">
              <h5 class="text-white">Address</h5>
              <p>123 Street, New York, USA</p>
            </div>
          </div>
          <div class="d-flex">
            <h4 class="fa fa-envelope text-primary"></h4>
            <div class="pl-3">
              <h5 class="text-white">Email</h5>
              <p>info@example.com</p>
            </div>
          </div>
          <div class="d-flex">
            <h4 class="fa fa-phone-alt text-primary"></h4>
            <div class="pl-3">
              <h5 class="text-white">Phone</h5>
              <p>+216 87512666 </p>
            </div>
          </div>
        </div>
        </section>
  
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