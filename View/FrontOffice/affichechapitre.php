<?php 
include(__DIR__ . '/../../Controller/chapitre_controller.php');

if (!isset($_GET['id_matiere'])) {
    header('Location: index.php');
    exit();
}

$id_matiere = intval($_GET['id_matiere']);

// Fetch chapters for the selected matière
$chapitreController = new chapitre_controller();
$chapitres = $chapitreController->get_chapitres_by_matiere($id_matiere);

$sql_matiere = "SELECT nom FROM matiere WHERE id_matiere = ?";
$db = config::getConnexion();
$query_matiere = $db->prepare($sql_matiere);
$query_matiere->execute([$id_matiere]);
$matiere_name = $query_matiere->fetchColumn();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>NexDegree</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Free HTML Templates">
    <meta name="description" content="Free HTML Templates">

    <!-- Favicon -->
    <link href="img/icon.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Flaticon Font -->
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <style>
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

    ul {
    list-style: none; /* Remove default list styling */
    padding: 0; /* Remove padding */
}

ul li {
    position: relative; /* Position relative for pseudo-element */
    padding-left: 20px; /* Add padding to make space for the ">" symbol */
}

ul li::before {
    content: ">"; /* Insert the ">" symbol */
    position: absolute; /* Position the symbol */
    left: 0; /* Align it to the left of the item */
    color: #0069d9; /* Set color for the symbol */
    font-weight: bold; /* Make it bold */
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
                <a href="index.php" class="nav-item nav-link active">Matiere</a>
                <a href="about.html" class="nav-item nav-link">About</a>
            <a href="contact.html" class="nav-item nav-link">Contact</a>
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

    <!-- Semester Selection and Matiere Display -->
    <div class="container-fluid py-5">
        <div class="container">
        <h1 class="mb-4">Chapters for Subject: <?= htmlspecialchars($matiere_name) ?></h1>

<?php if (empty($chapitres)): ?>
    <p class="text-muted">No chapters available for this subject.</p>
<?php else: ?>
    <?php foreach ($chapitres as $chapitre): ?>
        <div class="card mb-4">
            <div class="card-header" style="color : rgb(201, 100, 29);">
                Chapter: <?= htmlspecialchars($chapitre['titre']) ?>
            </div>
            <div class="card-body" style="color:black;">
                <ul>
                    <li>Date Start: <?= isset($chapitre['date_debut']) ? htmlspecialchars($chapitre['date_debut']) : 'N/A'; ?></li>
                    <li>Duration: <?= isset($chapitre['duree']) ? htmlspecialchars($chapitre['duree']) : 'N/A'; ?></li>
                    <li>Objective: <?= isset($chapitre['objectif']) ? htmlspecialchars($chapitre['objectif']) : 'N/A'; ?></li>
                    <li>Activity: <?= isset($chapitre['activite']) ? htmlspecialchars($chapitre['activite']) : 'N/A'; ?></li>
                    <li>Supplementary Resources: <?= isset($chapitre['res_supp']) ? htmlspecialchars($chapitre['res_supp']) : 'N/A'; ?></li>
                    <li>Evaluation Included: <?= isset($chapitre['evaluation_incluse']) && $chapitre['evaluation_incluse'] ? 'Yes' : 'No'; ?></li>
                    <li>Evaluation Type: 
                        <?= isset($chapitre['type_de_evaluation']) && $chapitre['evaluation_incluse'] ? htmlspecialchars($chapitre['type_de_evaluation']) : 'NONE'; ?>
                    </li>
                </ul>
            </div>
            <div class="card-footer">
            <?php 
                $file_path = "../uploads/" . basename($chapitre['contenu']);?>
                <a href="<?= htmlspecialchars($file_path); ?>" style="margin-left:20px; margin-right:20px;" >View PDF</a>
            <?php if (isset($chapitre['contenu']) && !empty($chapitre['contenu']) && file_exists("../uploads/" . $chapitre['contenu'])): ?>
    <a href="../uploads/<?= htmlspecialchars($chapitre['contenu']); ?>" download="<?= htmlspecialchars($chapitre['contenu']); ?>">Download PDF</a>
    <a style="margin-left:20px; margin-right:20px;" href="quiz.php?id_chapitre=<?= htmlspecialchars($chapitre['id_chapitre']) ?>" >Quiz</a>
    <a style="margin-left:20px; margin-right:20px;" href="ListeTest.php?id_chapitre=<?= htmlspecialchars($chapitre['id_chapitre']) ?>" >Test</a>

    <?php else: ?>
    <span class="text-danger">No file uploaded</span>
<?php endif; ?>
</div>

        </div>
    <?php endforeach; ?>
<?php endif; ?>
        </div>
    </div>
    <!-- Semester Selection and Matiere Display End -->

    <!-- Footer -->
    <div class="container-fluid bg-secondary text-white mt-5 py-5 px-sm-3 px-md-5">
        <div class="row pt-5">
            <div class="col-lg-3 col-md-6 mb-5">
                <a href="#" class="navbar-brand font-weight-bold text-primary m-0 mb-4 p-0" style="font-size: 40px; line-height: 40px;">
                
                    <span class="text-white">NexDegree</span>
                </a>
                <p>Its the New Way of education</p>
                <div class="d-flex justify-content-start mt-4">
                    <a class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
                        style="width: 38px; height: 38px;" href="#"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
                        style="width: 38px; height: 38px;" href="#"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
                        style="width: 38px; height: 38px;" href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
                        style="width: 38px; height: 38px;" href="#"><i class="fab fa-instagram"></i></a>
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
                        <p>+012 345 67890</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h3 class="text-primary mb-4">Quick Links</h3>
                <div class="d-flex flex-column justify-content-start">
                    <a class="text-white mb-2" href="index.php"><i class="fa fa-angle-right mr-2"></i>Matiere</a>
                    
                </div>
            </div>
        </div>
        <div class="container-fluid pt-5" style="border-top: 1px solid rgba(23, 162, 184, .2);;">
            <p class="m-0 text-center text-white">
                &copy; <a class="text-primary font-weight-bold" href="#">NexDegree</a>. All Rights Reserved. 
				
				<!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
				
            </p>
        </div>
    </div>

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary p-3 back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
