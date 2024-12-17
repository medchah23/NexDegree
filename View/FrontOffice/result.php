<?php
$score = $_GET['score'] ?? 0;
$totalPoints = $_GET['totalPoints'] ?? 0;
$quizId = $_GET['quizId'] ?? 0;

// Calcul du pourcentage
$percentage = ($totalPoints > 0) ? ($score / $totalPoints) * 100 : 0;

// Messages d'encouragement en fonction du score
if ($score >= $totalPoints * 0.8) {
    $message = "Excellent travail ! Vous avez presque tout bon !";
} elseif ($score >= $totalPoints * 0.5) {
    $message = "Bon travail ! Continuez à vous améliorer.";
} else {
    $message = "Pas mal ! Mais vous pouvez faire mieux !";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Résultat du Quiz</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link href="img/icon.png" rel="icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito&display=swap"
        rel="stylesheet"
    />
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
        rel="stylesheet"
    />
    <link href="css/style.css" rel="stylesheet" />
    <style>
        h1.text-center { color: #2E86C1; font-size: 2.5em; text-transform: uppercase; }
        .card-header h3 { color: #D35400; }
        .card-header p { color: black; }
        .container .score-card {
            background: #ffffff;
            border: 2px solid #2E86C1;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin-top: 50px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            margin-top: 20px;
            background-color: #2E86C1;
            border: none;
            padding: 10px 20px;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #1A5276;
        }
        .progress-bar {
            width: 80%;
            background-color: #f3f3f3;
            border-radius: 25px;
            margin: 20px auto;
            overflow: hidden;
        }
        .progress {
            height: 25px;
            line-height: 25px;
            background-color: #2E86C1;
            text-align: center;
            color: white;
            border-radius: 25px 0 0 25px;
            width: 0;
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        .score-text {
            opacity: 0;
            animation: fadeIn 2s forwards;
        }

        /* Animated score bounce */
        .score-display {
            font-size: 3em;
            font-weight: bold;
            color: #D35400;
            opacity: 0;
            animation: bounceIn 2s forwards;
        }

        @keyframes bounceIn {
            0% { transform: scale(0.5); opacity: 0; }
            60% { transform: scale(1.2); }
            100% { transform: scale(1); opacity: 1; }
        }

        /* Typing effect */
        .typing {
            font-size: 2em;
            color: #F39C12;
            overflow: hidden;
            white-space: nowrap;
            border-right: .15em solid #2E86C1;
            width: 0;
            animation: typing 4s steps(30) 1s forwards;
        }

        @keyframes typing {
            0% { width: 0; }
            100% { width: 100%; }
        }

        /* Scroll effect */
        .scroll-in {
            animation: scrollIn 1s ease-out;
        }

        @keyframes scrollIn {
            0% {
                transform: translateY(50px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Confetti animation */
        .confetti {
            position: absolute;
            top: 50%;
            left: 50%;
            z-index: 1000;
            pointer-events: none;
        }

        @keyframes confettiFall {
            0% { top: 0; opacity: 1; }
            100% { top: 100%; opacity: 0; }
        }

        /* Confetti pieces */
        .confetti-piece {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: #F39C12;
            animation: confettiFall 2s infinite linear;
        }
    </style>
    <script>
        // Fonction pour animer la barre de progression
        window.onload = function() {
            const progress = document.querySelector('.progress');
            const percentage = <?= $percentage ?>;
            let width = 0;

            const interval = setInterval(function() {
                if (width >= percentage) {
                    clearInterval(interval);
                } else {
                    width++;
                    progress.style.width = width + '%';
                }
            }, 20);

            // Afficher la dynamique du score
            const scoreDisplay = document.querySelector('.score-display');
            scoreDisplay.style.opacity = 1;

            // Typing effect
            const typingEffect = document.querySelector('.typing');
            typingEffect.style.animationPlayState = 'running';

            // Animation de confettis
            const confettiContainer = document.querySelector('.confetti');
            for (let i = 0; i < 20; i++) {
                let piece = document.createElement('div');
                piece.classList.add('confetti-piece');
                piece.style.left = `${Math.random() * 100}%`;
                piece.style.animationDuration = `${Math.random() * 2 + 2}s`;
                confettiContainer.appendChild(piece);
            }

            // Modifier la couleur de fond
            const body = document.querySelector('body');
            if (percentage >= 80) {
                body.classList.add('excellent');
            } else if (percentage >= 50) {
                body.classList.add('good');
            } else {
                body.classList.add('needs-improvement');
            }
        };
    </script>
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-center">
        <img class="img-fluid mt-3" src="img/a.png" alt="Quiz Image" />
    </div>
    <div class="score-card">
    <h1>Votre Score : <?= htmlspecialchars($score) ?>/<?= htmlspecialchars($totalPoints) ?></h1>
    <p>Vous avez <?= round($percentage, 2) ?>% de bonnes réponses</p>
  

        <!-- Message dynamique -->
      

        <!-- Barre de progression -->
        <div class="progress-bar">
            <div class="progress" style="width: <?= $percentage ?>%;"></div>
        </div>

        <!-- Animation de confettis -->
        <div class="confetti"></div>

        <!-- Typing effect -->
        <div class="typing"><?= htmlspecialchars($message) ?></div>
        <a href="index.php" class="btn btn-secondary">Retour à l'accueil</a>
    </div>
</div>
</body>
</html>




