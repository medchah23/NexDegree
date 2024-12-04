<?php
// quizList.php

include '../../controller/QuizController.php';
$quizController = new QuizController();
$quizzes = $quizController->listQuizzes(); // Appel à la méthode listQuizzes pour récupérer les quiz
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Quiz - Dashboard</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Sidebar and Header (copié depuis votre template) -->
    <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
    <a class="navbar-brand" href="#page-top">
                <img class="navbar-brand" src="assets/img/esprit.png" alt="logo-esprit" width="100%" height="30%"/>
            </a>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>
    </header>

    <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item active">
                    <a class="nav-link" href="#">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                </li>
                <li class="nav-item">
        <a class="nav-link collapsed" href="addQuiz.php">
          <i class="bi bi-list"></i>
          <span>Ajouter Quiz</span>
        </a>
      </li><!-- End Quiz List Nav -->
  
        </ul>
    </aside>

    <!-- Main Content -->
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Gestion des Quiz</h1>
            <nav>

                    <li class="breadcrumb-item active">Quiz</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Liste des Quiz</h5>

                            <!-- Bouton pour créer un quiz -->
                            <a href="addQuiz.php" class="btn btn-success mb-3">
                                <i class="bi bi-plus-circle"></i> Créer un nouveau Quiz
                            </a>

                            <!-- Table des Quiz -->
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
                                                <!-- Bouton Update -->
                                                <a href="updateQuiz.php?id=<?= $quiz['id'] ?>" class="btn btn-primary btn-sm">
                                                    <i class="bi bi-pencil-square"></i> Modifier
                                                </a>

                                                <!-- Bouton Delete -->
                                              
                                                <!-- Bouton Delete -->
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

