<?php 
include(__DIR__ . '/../../Controller/matiere_controller.php');
session_start();
if (!isset($_SESSION['user_token']) || !isset($_SESSION['user_id'])) {
    header("Location: html/sign_in.html");
    exit();
}


$matiereController = new matiere_controller();
$semester = isset($_GET['semester']) ? $_GET['semester'] : null;

$list = $matiereController->show_all_matiere($semester); 
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
                <a href="accueil.php" class="nav-item nav-link active">Forum</a>
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
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Account</a>
            <div class="dropdown-menu rounded-0 m-0">
                <a href="profile.php" class="dropdown-item">Profile</a>
                <a href="logout.php" class="dropdown-item">Logout</a>
            </div>
        </div>
    </nav>
</div>
    <div class="container-fluid py-5">
        <div class="container">
            <h2 class="text-center mb-4">Select Your Semester</h2>
            <div class="semester-selection text-center mb-5">
    <form action="" method="GET">
        <button type="submit" name="semester" value="1" 
        class="semester-btn <?= isset($_GET['semester']) && $_GET['semester'] == 1 ? 'active' : '' ?>"
        data-semester="1">
    Semester 1
</button>
<button type="submit" name="semester" value="2" 
        class="semester-btn <?= isset($_GET['semester']) && $_GET['semester'] == 2 ? 'active' : '' ?>"
        data-semester="2">
    Semester 2
</button>
<button type="submit" name="semester" value="3" 
        class="semester-btn <?= isset($_GET['semester']) && $_GET['semester'] == 3 ? 'active' : '' ?>"
        data-semester="3">
    Semester 3
</button>

    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const semesterButtons = document.querySelectorAll('.semester-btn');
    
    // Check if there's an active semester in the URL and set it on page load
    const urlParams = new URLSearchParams(window.location.search);
    const activeSemester = urlParams.get('semester');

    semesterButtons.forEach(button => {
        const semesterValue = button.getAttribute('data-semester');

        // If the semester from the URL matches this button, set it as active
        if (semesterValue === activeSemester) {
            button.classList.add('active');
        } else {
            button.classList.remove('active');
        }

        // Add click event listener
        button.addEventListener('click', function(event) {
            // Prevent default form submission
            event.preventDefault();

            // Get the semester value for this button
            const semesterValue = this.getAttribute('data-semester');
            const currentUrl = new URL(window.location.href);

            // Toggle the active state in the URL
            if (currentUrl.searchParams.get('semester') === semesterValue) {
                // If the clicked semester is already active, remove the query parameter
                currentUrl.searchParams.delete('semester');
            } else {
                // If the clicked semester is not active, set it as the active semester
                currentUrl.searchParams.set('semester', semesterValue);
            }

            // Redirect to the new URL
            window.location.href = currentUrl.toString();
        });
    });
});
</script>




            <?php if (empty($list)): ?>
        <p class="text-muted">No Matiere available .</p>
    <?php else: ?>
        <?php foreach ($list as $matiere): ?>
            <div class="card mb-4">
                <div class="card-header" style="color : rgb(201, 100, 29); font-weight: 600;">
                    Matiere : <?= $matiere['nom']; ?>
                </div>
                <div class="card-body" style="color:black;">
                    <ul>
                    <li>Niveau : <?= $matiere['niveau']; ?></li>
                      <li>Semseter : <?= $matiere['sems']; ?></li>
                      <li>Credit : <?= $matiere['credit']; ?></li>
                      <li>Prerequis : <?= $matiere['prerequis']; ?></li><br>
                      <li>Description : <?= $matiere['description']; ?></li>
                      
                        
                    </ul>
                </div>
                <div class="card-footer">
                <p style="color: rgb(193, 18, 31);">Nombre de chapitre : <?= $matiere['nombre_chapitre']; ?></p>
                <a style="font-weight:400;" href="affichechapitre.php?id_matiere=<?php echo $matiere['id_matiere']; ?>" >View Chapters</a>
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
    <a href="index.php" class="btn btn-primary p-3 back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
