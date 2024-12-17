
<?php
include '../../Controller/QuizController.php';
include '../../Controller/QuestionController.php';

$quizController = new QuizController();
$questionController = new QuestionController();

$quizzes = $quizController->listQuizzes(); // Récupérer les quiz
$questions = $questionController->listQuestions(); // Récupérer les questions
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Quiz - Dashboard</title>
    <link href="assets/img/icon.png" rel="icon">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Sidebar and Header -->
    <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <img src="assets/img/nexdegree.png" alt="">
        
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Search Bar -->
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

    <!-- Main Content -->
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Gestion des Quiz</h1>
            <nav>
                <li class="breadcrumb-item active">Quiz</li>
            </nav>
        </div>

        <!-- Liste des Quiz -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Liste des Quiz</h5>
                            <a href="addQuiz.php" class="btn btn-success mb-3">
                                <i class="bi bi-plus-circle"></i> Créer un nouveau Quiz
                            </a>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Titre</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Catégorie</th>
                                        <th scope="col">Date de création</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($quizzes as $quiz): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($quiz['id']) ?></td>
                                            <td><?= htmlspecialchars($quiz['title']) ?></td>
                                            <td><?= htmlspecialchars($quiz['description']) ?></td>
                                            <td><?= htmlspecialchars($quiz['category']) ?></td>
                                            <td><?= htmlspecialchars($quiz['created_at']) ?></td>
                                            <td>
                                                <a href="updateQuiz.php?id=<?= $quiz['id'] ?>" class="btn btn-primary btn-sm">
                                                    <i class="bi bi-pencil-square"></i> Modifier
                                                </a>
                                                <a href="deleteQuiz.php?id=<?= $quiz['id'] ?>" 
                                                   class="btn btn-danger btn-sm" 
                                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce quiz ?');">
                                                   <i class="bi bi-trash"></i> Supprimer
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Liste des Questions -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Liste des Questions</h5>
                            <a href="addQuestion.php" class="btn btn-success mb-3">
                                <i class="bi bi-plus-circle"></i> Créer un nouveau Question
                            </a>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Quiz ID</th>
                                        <th scope="col">Texte</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Points</th>
                                        <th scope="col">Temps Limite (s)</th>
                                        <th colspan="2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($questions as $question): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($question['id']) ?></td>
                                            <td><?= htmlspecialchars($question['quiz_id']) ?></td>
                                            <td><?= htmlspecialchars($question['texte']) ?></td>
                                            <td><?= htmlspecialchars($question['type']) ?></td>
                                            <td><?= htmlspecialchars($question['points']) ?></td>
                                            <td><?= htmlspecialchars($question['temps_limite']) ?></td>
                                            <td>
                                                <a href="updateQuestion.php?id=<?= $question['id'] ?>" class="btn btn-primary btn-sm">
                                                    <i class="bi bi-pencil-square"></i> Modifier
                                                </a>
                                                <a href="deleteQuestion.php?id=<?= $question['id'] ?>" 
                                                   class="btn btn-danger btn-sm" 
                                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette question ?');">
                                                   <i class="bi bi-trash"></i> Supprimer
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; 2024 <strong><span>Quiz Manager</span></strong>. Tous droits réservés.
        </div>
    </footer>

    <!-- JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
