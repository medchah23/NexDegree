<?php
include '../../controller/QuizController.php';
$quizController = new QuizController();

// Check if id_chapitre is set in the URL
if (isset($_GET['id_chapitre'])) {
    $id_chapitre = intval($_GET['id_chapitre']); // Sanitize input
    $quizzes = $quizController->listQuizzesByChapitre($id_chapitre); // Fetch quizzes by chapitre ID
} else {
    $quizzes = $quizController->listQuizzes(); // Fetch all quizzes if no chapitre is selected
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Quiz</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="keywords" />
    <meta content="" name="description" />
    <link href="img/icon.png" rel="icon"> 
    <!-- Bootstrap Icons -->

     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="img/favicon.ico" rel="icon" />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet" />
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <style>
     /* Card Styles */
.card {
  border-radius: 12px; /* Rounded corners for elegance */
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
  transform: translateY(-10px); /* Slight lift on hover */
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1); /* Soft shadow on hover */
}

.card-body {
  padding: 30px;
  background-color: #f8f9fa; /* Light background for a soft feel */
  border-bottom: 2px solid #e9ecef; /* Subtle border at the bottom */
}

.card-title {
  font-size: 1.3rem;
  font-weight: 600;
  color: #212529; /* Dark text color */
}

.card-text {
  font-size: 1rem;
  color: #6c757d; /* Muted color for description */
  line-height: 1.5;
}

.card-footer {
  background-color: transparent;
  padding-top: 10px;
  padding-bottom: 10px;
}

.card-footer .row {
  border-top: 1px solid #e9ecef; /* Subtle border separating footer content */
}

.card-footer .col-6 {
  padding-top: 6px;
}

.card-footer .text-right {
  font-weight: 500;
  color:rgb(51, 135, 226); /* Blue color for labels */
}

/* Button Styles */
.btn-primary {
  background-color: #007bff;
  border: none;
  font-weight: 500;
  padding: 12px 24px;
  text-transform: uppercase;
  letter-spacing: 1px;
  border-radius: 30px;
  transition: background-color 0.3s, transform 0.3s ease;
}

.btn-primary:hover {
  background-color: #0056b3; /* Darker shade on hover */
  transform: translateY(-2px);
}

.card-body .btn {
  margin-top: 10px;
}

/* Text Styles */
.text-primary {
  color:rgb(32, 73, 117) !important; /* Primary color for text */
}

.text-muted {
  color:rgb(0, 0, 0) !important; /* Muted color for text */
}

.section-title span {
  font-weight: 600;
  font-size: 1.1rem;
  color:rgb(3, 41, 146);
  text-transform: uppercase;
}

h1 {
  font-size: 2.5rem;
  font-weight: 700;
  color: #212529;
}
.search-bar {
        width: auto;
        margin: 0;
        right: 0;
    }

    .search-form {
        display: flex;
        align-items: center;
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        border-radius: 5px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .search-form input {
        flex-grow: 1;
        padding: 8px 12px;
        border: none;
        outline: none;
        font-size: 14px;
        min-width: 150px;
    }

    .search-form input::placeholder {
        color: #adb5bd;
    }

    

    .search-form button {
        background: none;
        border: none;
        padding: 8px;
        cursor: pointer;
        color: #6c757d;
        transition: color 0.3s ease;
    }

    .search-form button:hover {
        color: #495057;
    }

        .semester-selection {
            margin: 20px 0;
        }

        .semester-btn {
            background-color: #ffffff;
            border: 1px solid #0096FF;
            border-radius: 50px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            margin-right: 10px;
        }

        .semester-btn:hover {
            background-color: #8fd9fb;
        }

        .semester-btn.active {
    background-color: #0069d9;
    color: white;
    border-color: #0062cc;
}

    </style>
  </head>
  <body id="page-top">
    <!-- Navbar Start -->
    <div class="container-fluid bg-light position-relative shadow">
    <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5">
        <a href="index.php" class="navbar-brand font-weight-bold text-secondary" style="font-size: 50px;">
        <img src="img/logo.png" style="width: 270px; height: 50px;" alt="NexDegree">
        </a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
            <div class="navbar-nav font-weight-bold mx-auto py-0 d-flex align-items-center">
                <a href="affichematiere.php" class="nav-item nav-link active">Matiere</a>
                <div class="search-bar ml-4">
                    <form class="search-form d-flex align-items-center" method="POST" action="search_chapters.php">
                        <input type="text" name="query" placeholder="Search Chapters..." 
                               value="<?= isset($_POST['query']) ? htmlspecialchars($_POST['query']) : '' ?>" />
                        <button type="submit" title="Search">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</div>
    <!-- Navbar End -->

    <!-- Header Start -->
    <div class="container-fluid bg-primary px-0 px-md-5 mb-5">
      <div class="row align-items-center px-3">
        <div class="col-lg-6 text-center text-lg-left">
          <h4 class="text-white mb-4 mt-5 mt-lg-0">Quiz Portal</h4>
          <h1 class="display-3 font-weight-bold text-white">New Approach to Kids Education</h1>
          <p class="text-white mb-4">Test Your Knowledge - Multiple Topics</p>
        </div>
        <div class="col-lg-6 text-center text-lg-right">
          <img class="img-fluid mt-5" src="img/x.png" alt="Educational Banner" />
        </div>
      </div>
    </div>
    <!-- Header End -->
<!-- Quizzes Section Start -->
<!-- Quizzes Section Start -->
<section class="page-section portfolio" id="portfolio">
  <div class="container-fluid pt-5">
    <div class="container">
      <div class="text-center pb-2">
        <p class="section-title px-5">
          <span class="px-2">Available Quizzes</span>
        </p>
        <h1 class="mb-4">Explore Our Quizzes</h1>
      </div>

      <!-- Displaying the Quizzes -->
      <div class="row">
        <?php if (empty($quizzes)): ?>
          <p class="text-center w-100">No quizzes available for this chapter.</p>
        <?php else: ?>
          <?php foreach ($quizzes as $quiz): ?>
            <div class="col-lg-4 mb-5">
              <div class="card border-light shadow-lg rounded-lg overflow-hidden">
                <div class="card-body text-center">
                  <h4 class="card-title text-dark font-weight-bold"><?= htmlspecialchars($quiz['title']) ?></h4>
                  <p class="card-text text-muted mb-4"><?= htmlspecialchars($quiz['description']) ?></p>
                </div>
                <div class="card-footer bg-transparent py-3 px-4">
                  <div class="row border-bottom">
                    <div class="col-6 py-1 text-right border-right">
                      <strong class="text-primary">Category</strong>
                    </div>
                    <div class="col-6 py-1"><?= htmlspecialchars($quiz['category']) ?></div>
                  </div>
                  <div class="row">
                    <div class="col-6 py-1 text-right border-right">
                      <strong class="text-primary">Created At</strong>
                    </div>
                    <div class="col-6 py-1"><?= htmlspecialchars($quiz['created_at']) ?></div>
                  </div>
                </div>
                <div class="card-body text-center">
                  <a href="view-quiz.php?id=<?= htmlspecialchars($quiz['id']) ?>" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm transition-all">Start Quiz</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<!-- Quizzes Section End -->

<!-- Quizzes Section End -->



    <!-- About Section Start -->
    <section class="page-section" id="about">
      <div class="container">
        <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">About</h2>
        <div class="row justify-content-center">
          <p align="center">Our quiz portal allows users to challenge themselves across various topics.<br> Explore available quizzes and test your knowledge today!</p>
        </div>
      </div>
    </section>
    <!-- About Section End -->

    <!-- Footer and Contact Info -->
    <section class="page-section" id="contact">
      <div class="container-fluid bg-secondary text-white mt-5 py-5 px-sm-3 px-md-5">
        <div class="row pt-5">
          <div class="col-lg-3 col-md-6 mb-5">
            <a class="navbar-brand" href="#page-top">
              <img class="navbar-brand" src="img/esprit.png" alt="Logo Esprit" width="100%" height="30%" />
            </a>
            <p>A dynamic educational platform that transforms learning into an engaging and personalized experience, guiding you through every step of your journey.</p>
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
                <p>+1 234 567 890</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary p-3 back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
