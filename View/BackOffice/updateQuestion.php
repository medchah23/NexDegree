<?php
include_once '../../controller/QuestionController.php';
include_once '../../controller/QuizController.php';

$error = "";
$questionController = new QuestionController();
$quizController = new QuizController();

// Récupérer la liste des quiz pour le champ de sélection
$quizList = $quizController->getAllQuizzes();

// Vérification de l'ID de la question pour la mise à jour
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $questionId = $_GET['id'];

    // Récupérer la question existante
    $question = $questionController->getQuestionById($questionId);
    if (!$question) {
        die("La question n'existe pas.");
    }
}

// Vérification du formulaire pour mettre à jour une question
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST["quiz_id"], $_POST["texte"], $_POST["type"], $_POST["points"], $_POST["temps_limite"]) &&
        !empty($_POST["quiz_id"]) && !empty($_POST["texte"]) && !empty($_POST["type"]) &&
        !empty($_POST["points"]) && !empty($_POST["temps_limite"])
    ) {
        // Créer une nouvelle instance de la classe Question pour la mise à jour
        $question = new Question(
            $questionId,  // ID de la question à mettre à jour
            $_POST['quiz_id'],
            $_POST['texte'],
            $_POST['type'],
            (int)$_POST['points'],
            new DateTime($_POST['temps_limite'])
        );

        // Mettre à jour la question via le contrôleur
        $questionController->updateQuestion($question, $questionId);

        // Rediriger vers la liste des quiz après mise à jour
        header('Location: quizList.php');
        exit();
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
  <title>Modifier la Question</title>
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
    <h1>Modifier la Question</h1>
  </div>
  <section class="section">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Formulaire de modification de la Question</h5>
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <!-- Formulaire de modification de la Question -->
                    <form action="" method="POST" id="updateQuestionForm">

                        <div class="mb-3">
                            <label for="quiz_id" class="form-label">Quiz</label>
                            <select id="quiz_id" name="quiz_id" class="form-control" required>
                                <option value="">-- Sélectionner un Quiz --</option>
                                <?php if (!empty($quizList)): ?>
                                    <?php foreach ($quizList as $quiz): ?>
                                        <option value="<?= htmlspecialchars($quiz['id']); ?>" <?= $quiz['id'] == $question['quiz_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($quiz['id']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="">Aucun quiz disponible</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="texte" class="form-label">Texte de la Question</label>
                            <textarea id="texte" name="texte" class="form-control" rows="3" required><?= htmlspecialchars($question['texte']) ?></textarea>
                            <span id="texte_error" class="bg-success-light"><?php echo $error; ?></span>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Type de Question</label>
                            <select id="type" name="type" class="form-control" required>
                                <option value="">-- Sélectionner un Type --</option>
                                <option value="multiple" <?= $question['type'] == 'type' ? 'selected' : '' ?>>Choix multiples</option>
                                <option value="true_false" <?= $question['type'] == 'true_false' ? 'selected' : '' ?>>Vrai ou Faux</option>
                                <option value="input" <?= $question['type'] == 'open_answer' ? 'selected' : '' ?>>Réponse ouverte</option>

                            </select>
                            <span id="type_error" class="bg-success-light"><?php echo $error; ?></span>
                        </div>

                        <div class="mb-3">
                            <label for="points" class="form-label">Points</label>
                            <input type="number" id="points" name="points" class="form-control" min="1" value="<?= htmlspecialchars($question['points']) ?>" required>
                            <span id="points_error" class="bg-success-light"><?php echo $error; ?></span>
                        </div>

                        <div class="mb-3">
                            <label for="temps_limite" class="form-label">Temps limite (en secondes)</label>
                            <input type="datetime-local" id="temps_limite" name="temps_limite" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($question['temps_limite'])) ?>" required>
                        </div>
                        <br>
                                        
                                        <button type="submit" 
                                        class="btn btn-primary btn-user btn-block" 
                                        onClick="validerFormulaire()"
                                        >Mettre à jour </button> 
    </form>
                     
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

<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Sélection des éléments du formulaire pour 'Question'
        var texteElement = document.querySelector("form textarea[name='texte']");
        var typeElement = document.querySelector("form select[name='type']");
        var pointsElement = document.querySelector("form input[name='points']");
        var tempsLimiteElement = document.querySelector("form input[name='temps_limite']");

        // Fonction de validation pour le texte
        function validateTexte() {
            var texteErrorElement = document.getElementById("texte_error");
            var texteErrorValue = texteElement.value;
            if (texteErrorValue.length < 5) { // Minimum 5 caractères
                texteErrorElement.innerHTML = "Le texte de la question doit contenir au moins 5 caractères";
                texteErrorElement.style.color = "red";
                return false;
            } else {
                texteErrorElement.innerHTML = "Correct";
                texteErrorElement.style.color = "green";
                return true;
            }
        }

        // Fonction de validation pour le type de question
        function validateType() {
            var typeErrorElement = document.getElementById("type_error");
            var typeErrorValue = typeElement.value;
            if (typeErrorValue === "") {
                typeErrorElement.innerHTML = "Le type de question est obligatoire";
                typeErrorElement.style.color = "red";
                return false;
            } else {
                typeErrorElement.innerHTML = "Correct";
                typeErrorElement.style.color = "green";
                return true;
            }
        }

        // Fonction de validation pour les points
        function validatePoints() {
            var pointsErrorElement = document.getElementById("points_error");
            var pointsErrorValue = pointsElement.value;
            if (pointsErrorValue === "" || isNaN(pointsErrorValue) || pointsErrorValue <= 0) {
                pointsErrorElement.innerHTML = "Les points doivent être un nombre positif";
                pointsErrorElement.style.color = "red";
                return false;
            } else {
                pointsErrorElement.innerHTML = "Correct";
                pointsErrorElement.style.color = "green";
                return true;
            }
        }

        // Fonction de validation pour le temps limite
        function validateTempsLimite() {
            var tempsLimiteErrorElement = document.getElementById("temps_limite_error");
            var tempsLimiteErrorValue = tempsLimiteElement.value;
            if (tempsLimiteErrorValue === "" || isNaN(tempsLimiteErrorValue) || tempsLimiteErrorValue <= 0) {
                tempsLimiteErrorElement.innerHTML = "Le temps limite doit être un nombre positif";
                tempsLimiteErrorElement.style.color = "red";
                return false;
            } else {
                tempsLimiteErrorElement.innerHTML = "Correct";
                tempsLimiteErrorElement.style.color = "green";
                return true;
            }
        }

        // Validation dynamique des champs avec 'keyup' ou 'change'
        texteElement.addEventListener("keyup", validateTexte); // 'keyup' pour le texte
        typeElement.addEventListener("change", validateType); // 'change' pour le type
        pointsElement.addEventListener("keyup", validatePoints); // 'keyup' pour les points
        tempsLimiteElement.addEventListener("keyup", validateTempsLimite); // 'keyup' pour le temps limite

        // Vérifier tous les champs avant la soumission
        document.getElementById("updateQuestionForm").addEventListener("submit", function (e) {
            if (
                !validateTexte() ||
                !validateType() ||
                !validatePoints() ||
                !validateTempsLimite()
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
