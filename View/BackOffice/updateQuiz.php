<?php

include '../../Controller/QuizController.php';

$error = "";
$quiz = null;

// Créer une instance du contrôleur
$quizController = new QuizController();
$db = config::getConnexion();

$sql_chapitre = "SELECT id_chapitre, titre FROM chapitre";
$query_chapitre = $db->query($sql_chapitre);
$chapitres = $query_chapitre->fetchAll();
$sql_matiere = "SELECT id_matiere, nom FROM matiere";
$query_matiere = $db->query($sql_matiere);
$matieres = $query_matiere->fetchAll();

if (isset($_GET['id'])) {
    $quiz = $quizController->showQuiz($_GET['id']);
    
    
    if (!$quiz) {
        $error = "Aucun quiz trouvé avec cet ID.";
    }
} else {
    $error = "ID du quiz manquant.";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["titre"], $_POST["description"], $_POST["id_matiere"], $_POST["created_at"], $_POST["id"])) {
    if (!empty($_POST["titre"]) && !empty($_POST["description"]) && !empty($_POST["id_matiere"]) && !empty($_POST["created_at"])) {
      $sql_chapitre = "SELECT id_chapitre FROM chapitre WHERE titre = :titre";
      $stmt = $db->prepare($sql_chapitre);
      $stmt->execute(['titre' => $_POST['titre']]);
      $id_chapitre = $stmt->fetchColumn();
      $quiz = new Quiz(
            $_POST['id'], 
            $_POST['titre'],
            $_POST['description'],
            $_POST['id_matiere'],
            new DateTime($_POST['created_at']),
            $id_chapitre
        );

       
        $quizController->updateQuiz($quiz, $_POST['id']);

      
        header('Location: quizList.php');
        exit;
    } else {
        $error = "Tous les champs doivent être remplis.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Modifier un Quiz - Dashboard</title>
  <link href="assets/img/icon.png" rel="icon">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>


  <header id="header" class="header fixed-top d-flex align-items-center">
  <div class="d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <img src="assets/img/nexdegree.png" alt="">
        
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
  </header>


  <aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

<li class="nav-item">
        <a class="nav-link collapsed" href="backoffice.php">
          <i class="bi bi-grid"></i>
          <span>dashboard</span>
        </a>
      </li>
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

  
  

  

</aside>

  <main id="main" class="main"> 
  <div class="pagetitle">
    <h1>Modifier un Quiz</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="quizList.php">Quiz</a></li>
        <li class="breadcrumb-item active">Modifier</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Formulaire de mise à jour de Quiz</h5>

            <?php if ($error): ?>
              <div class="alert alert-danger"><?= $error ?></div>
            <?php elseif ($quiz): ?>
             
              <form action="updatequiz.php?id=<?= $_GET['id'] ?>" method="POST" id="updateQuizForm">
             
                <input type="hidden" name="id" value="<?= $quiz->getId() ?>">

                <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Titre</label>
           <div class="col-sm-10">
        <select name="titre" class="form-select" aria-label="Default select example" required>
          <option value="">Titre</option>
          <?php foreach ($chapitres as $chapitre): ?>
            <option value="<?= $chapitre['titre'] ?>"><?= $chapitre['titre'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>

                <div class="row mb-3">
                  <label for="description" class="col-sm-2 col-form-label">Description</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" id="description" name="description"><?= htmlspecialchars($quiz->getDescription()) ?></textarea>
                    <span id="description_error"></span>
                  </div>
                </div>

                <div class="row mb-3">
      <label class="col-sm-2 col-form-label">Category</label>
      <div class="col-sm-10">
        <select name="id_matiere" class="form-select" aria-label="Default select example" required>
          <option value="">Select Matière</option>
          <?php foreach ($matieres as $matiere): ?>
            <option value="<?= $matiere['nom'] ?>"><?= $matiere['nom'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
<br>
<br>
                <div class="row mb-3">
                  <label for="created_at" class="col-sm-2 col-form-label">Date de création</label>
                  <div class="col-sm-10">
                    <input type="date" class="form-control" id="created_at" name="created_at" value="<?= $quiz->getCreatedAt()->format('Y-m-d') ?>">
                    <span id="created_at_error"></span>
                  </div>
                </div>

                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Mettre à jour Quiz</button>
                </div>
              </form>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>


<footer id="footer" class="footer">
  <div class="copyright">
    &copy; Copyright <strong><span>Quiz Admin</span></strong>. All Rights Reserved
  </div>
</footer>


<script>
  document.addEventListener("DOMContentLoaded", function () { 
 
    var titleElement = document.querySelector("form input[name='title']");
    var descriptionElement = document.querySelector("form textarea[name='description']");
    var categoryElement = document.querySelector("form select[name='category']");
    var createdAtElement = document.querySelector("form input[name='created_at']");

    
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

    // Validation dynamique des champs
    titleElement.addEventListener("input", validateTitle);
    descriptionElement.addEventListener("input", validateDescription);
    categoryElement.addEventListener("change", validateCategory);
    createdAtElement.addEventListener("change", validateCreatedAt);

    // Vérifier tous les champs avant la soumission
    document.getElementById("updateQuizForm").addEventListener("submit", function (e) {
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

<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
    </body>
    </html>
    







