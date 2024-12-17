<?php
include '../../controller/EvaluationController.php';
session_start();
if (!isset($_SESSION['user_token']) || !isset($_SESSION['user_id'])) {
    header("Location: html/sign_in.html");
    exit();
}
$user = $_SESSION['user_id'];
$evalc = new EvaluationController();
$matiere = "x";
$id_chapitre = isset($_GET['id_chapitre']) ? intval($_GET['id_chapitre']) : 0;

if ($matiere != 'done') {
    $list = $evalc->listEvaluationBySubject($user, $id_chapitre);
} else {
    $list = $evalc->joinEvaluationReponseClient($user, $id_chapitre);
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>NexDegree</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Free HTML Templates" name="keywords" />
    <meta content="Free HTML Templates" name="description" />
    <link href="img/icon.png" rel="icon"> 

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
      href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
      rel="stylesheet"
    />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet" />
  </head>
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
  <body>
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
    <div class="container-fluid bg-primary mb-5">
      <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
        <h3 class="display-3 font-weight-bold text-white">Evaluation</h3>
        <div class="d-inline-flex text-white">
          <p class="m-0"><a class="text-white" href="index.php">Home</a></p>
          <p class="m-0 px-2">/</p>
          <p class="m-0">Tests</p>
        </div>
      </div>
    </div>
    <!-- Header End -->

    <!-- Matiere Filter Start -->
    <div style="text-align: center; margin-bottom: 30px;">
      <h4>Filter by Subject:</h4>
      <a href="view_done_tests.php?user_id=<?= $user ?>&id_chapitre=<?= $id_chapitre ?>" class="btn btn-primary m-2">Done</a>
      </div>
    <!-- Matiere Filter End -->

    <!-- Test Links Start -->
    <main id="Evaluation" style="padding: 40px 20px; text-align: center">
      <h2>Available Tests</h2>
      <div style="margin-top: 20px;">
        <?php if (count($list) > 0): ?>

            <?php if($matiere != "done"): ?>
          <?php foreach ($list as $eval): ?>
            <p>
              <a
                href="test.php?id=<?php echo $eval['id']; ?>"
                style="text-decoration: none; color: #007bff; font-size: 18px;">
                Test ID: <?php echo $eval['id']; ?> - <?php echo $eval['matiere']; ?>
              </a>
            </p>
          <?php endforeach; ?>
          <?php else: ?>
                <?php foreach ($list as $eval): ?>
                    <p>
                        <a
                                href="#"
                                style="text-decoration: none; color: #007bff; font-size: 18px;">
                            Test ID: <?php echo $eval['id']; ?> - <?php echo $eval['matiere']; ?>
                        </a>
                        <?php if(!$eval['statusnote']): ?>
                            <a
                                    href="modifierReponse.php?id_reponse=<?php echo $eval['idrep']; ?>"
                                    style="text-decoration: none; color: #d9ff00; font-size: 18px;">
                                modifier
                            </a>
                            <a
                                    href="supprimerReponse.php?id_reponse=<?php echo $eval['idrep']; ?>"
                                    style="text-decoration: none; color: #ff0015; font-size: 18px;">
                                supprimer
                            </a>
                        <?php else: ?>
                            Note : <?php echo $eval['note']; ?> - Remarque : <?php echo $eval['remarque']; ?>
                        <?php endif; ?>
                    </p>
                <?php endforeach; ?>
            <?php endif; ?>

        <?php else: ?>
          <p>No tests available for this subject.</p>
        <?php endif; ?>
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
