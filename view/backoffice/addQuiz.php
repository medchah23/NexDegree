<?php

include '../../controller/QuizController.php';
$error = "";

$quiz = null;
// Créer une instance du contrôleur
$quizController = new QuizController();

if (
    isset($_POST["title"]) && isset($_POST["description"]) && isset($_POST["category"]) && isset($_POST["created_at"])
) {
    if (
        !empty($_POST["title"]) && !empty($_POST["description"]) && !empty($_POST["category"]) && !empty($_POST["created_at"])
    ) {
        $quiz = new Quiz(
            null,
            $_POST['title'],
            $_POST['description'],
            $_POST['category'],
            new DateTime($_POST['created_at'])
        );

        // Ajouter le quiz via le contrôleur
        $quizController->addQuiz($quiz);

        header('Location:quizList.php');
    } else {
        $error = "Missing information";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Ajouter un Quiz - Dashboard</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

<header id="header" class="header fixed-top d-flex align-items-center">

<div class="d-flex align-items-center justify-content-between">
<a href="x.html" class="logo d-flex align-items-center">
<img class="navbar-brand" src="assets/img/esprit.png" alt="logo-esprit" width="50%" height="30%"/>
</a>
    
  <i class="bi bi-list toggle-sidebar-btn"></i>
</div><!-- End Logo -->


</header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item active">
                    <a class="nav-link" href="#">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                </li>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="quizList.php">
          <i class="bi bi-list"></i>
          <span>Quiz List</span>
        </a>
      </li><!-- End Quiz List Nav -->
    </ul>
  </aside><!-- End Sidebar -->

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Ajouter un Quiz</h1>
      <nav>
        <ol class="breadcrumb">
         
          <li class="breadcrumb-item"><a href="quizList.php">Quiz</a></li>
          <li class="breadcrumb-item active">Ajouter</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Formulaire d'ajout de Quiz</h5>

              <!-- Formulaire d'ajout de Quiz -->
              <form action="" method="POST" id="addQuizForm">
                <div class="row mb-3">
                  <label for="title" class="col-sm-2 col-form-label">Titre</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="title" name="title" required>
                 
                    <span id="title_error" class="bg-success-light"><?php echo $error; ?></span>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="description" class="col-sm-2 col-form-label">Description</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" id="description" name="description" required></textarea>
                    <span id="description_error" class="bg-success-light"><?php echo $error; ?></span>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="categorie" class="col-sm-2 col-form-label">Categorie</label>
                  <div class="col-sm-10">
                    <select class="form-control" id="categorie" name="category" required>
                      <option value="science">Science</option>
                      <option value="mathematics">Mathematics</option>
                      <option value="literature">Literature</option>
                    </select>
                    <span id="category_error" class="bg-success-light"><?php echo $error; ?></span><br>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="created_at" class="col-sm-2 col-form-label">Date de création</label>
                  <div class="col-sm-10">
                    <input type="date" class="form-control" id="created_at" name="created_at" required>
                    <span id="created_at_error" class="bg-success-light"><?php echo $error; ?></span>
                  </div>
                </div>

                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Ajouter Quiz</button>
                </div>
              </form><!-- End Formulaire d'ajout de Quiz -->

            </div>
          </div>

        </div>
      </div>
    </section>
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Quiz Admin</span></strong>. All Rights Reserved
    </div>
  </footer><!-- End Footer -->

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script>
    document.addEventListener("DOMContentLoaded", function () { 
        // Sélection des éléments du formulaire
        var titleElement = document.querySelector("form input[name='title']");
        var descriptionElement = document.querySelector("form textarea[name='description']");
        var categoryElement = document.querySelector("form select[name='category']");
        var createdAtElement = document.querySelector("form input[name='created_at']");

        // Fonction de validation pour le titre
        function validateTitle() {
            var titleErrorElement = document.getElementById("title_error");
            var titleErrorValue = titleElement.value;
            if (titleErrorValue.length < 3) {
                titleErrorElement.innerHTML = "Le titre doit contenir au moins 3 caractères";
                titleErrorElement.style.color = "red";
                return false;
            } else {
                titleErrorElement.innerHTML = "Correct";
                titleErrorElement.style.color = "green";
                return true;
            }
        }

        // Fonction de validation pour la description
        function validateDescription() {
            var descriptionErrorElement = document.getElementById("description_error");
            var descriptionErrorValue = descriptionElement.value;

            if (descriptionErrorValue.length < 8) {
                descriptionErrorElement.innerHTML = "La description doit contenir au moins 8 caractères";
                descriptionErrorElement.style.color = "red";
                return false;
            } else {
                var pattern = /^[A-Za-z\s]+$/;
                if (!pattern.test(descriptionErrorValue)) {
                    descriptionErrorElement.innerHTML = "La description doit contenir uniquement des lettres et des espaces";
                    descriptionErrorElement.style.color = "red";
                    return false;
                } else {
                    descriptionErrorElement.innerHTML = "Correct";
                    descriptionErrorElement.style.color = "green";
                    return true;
                }
            }
        }

        // Fonction de validation pour la catégorie
        function validateCategory() {
            var categoryErrorElement = document.getElementById("category_error");
            var categoryErrorValue = categoryElement.value;
            if (categoryErrorValue === "") {
                categoryErrorElement.innerHTML = "La catégorie est obligatoire";
                categoryErrorElement.style.color = "red";
                return false;
            } else {
                categoryErrorElement.innerHTML = "Correct";
                categoryErrorElement.style.color = "green";
                return true;
            }
        }

        // Fonction de validation pour la date de création
        function validateCreatedAt() {
            var createdAtErrorElement = document.getElementById("created_at_error");
            var createdAtErrorValue = createdAtElement.value;
            if (createdAtErrorValue === "") {
                createdAtErrorElement.innerHTML = "La date de création est obligatoire";
                createdAtErrorElement.style.color = "red";
                return false;
            } else {
                createdAtErrorElement.innerHTML = "Correct";
                createdAtErrorElement.style.color = "green";
                return true;
            }
        }

        // Validation dynamique des champs avec 'keyup'
        titleElement.addEventListener("keyup", validateTitle); // 'keyup' pour le titre
        descriptionElement.addEventListener("keyup", validateDescription); // 'keyup' pour la description
        categoryElement.addEventListener("change", validateCategory); // 'change' pour la catégorie
        createdAtElement.addEventListener("change", validateCreatedAt); // 'change' pour la date de création

        // Vérifier tous les champs avant la soumission
        document.getElementById("addQuizForm").addEventListener("submit", function (e) {
            if (
                !validateTitle() ||
                !validateDescription() ||
                !validateCategory() ||
                !validateCreatedAt()
            ) {
                e.preventDefault();
                alert("Veuillez remplir tous les champs correctement avant de soumettre.");
            }
        });
    });
</script>

</body>

</html>


