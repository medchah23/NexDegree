<?php
session_start();
require_once("../../controller/UserController.php");
require_once("../../Model/session.php");
if (!isset($_SESSION['user_token']) || !isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header("Location: html/sign_in.html");
    exit();
}

try {
    // Initialize UserController and Session
    $userController = new UserController();
    $session = new Session();

    // Validate the session
    $isValid = $session->validateSession($_SESSION['user_token']);
    if (!$isValid) {
        // Destroy session if invalid
        $session->destroySession($_SESSION['user_token']);
        header("Location: .php");
        exit();
    }

    $user = $userController->getUserById2($_SESSION['user_id']);
    if (!$user) {
        throw new Exception("User not found.");
    }
} catch (Exception $e) {
    error_log("Profile error: " . $e->getMessage());
    echo "Error: " . htmlspecialchars($e->getMessage());
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Profile - NexDegree</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Educational Platform" name="keywords">
    <meta content="NexDegree - Profile Page" name="description">

    <!-- Favicon -->
    <link href="../assets/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
<!-- Header -->
<div class="container-fluid bg-light position-relative shadow">
    <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5">
        <a href="index.php" class="navbar-brand font-weight-bold text-secondary" style="font-size: 30px;">
            <i class="fas fa-graduation-cap"></i> NexDegree
        </a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
            <div class="navbar-nav font-weight-bold mx-auto py-0">
                <a href="index.php" class="nav-item nav-link">Home</a>
                <a href="profile.php" class="nav-item nav-link active">Profile</a>
                <a href="settings.php" class="nav-item nav-link">Settings</a>
                <a href="logout.php" class="nav-item nav-link">Logout</a>
            </div>
        </div>
    </nav>
</div>

<!-- Profile Section -->
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <img src="<?= $user['profile_image'] ?? '../assets/img/default-profile.png'; ?>"
                         alt="Profile Image"
                         class="rounded-circle img-fluid mb-3"
                         style="width: 150px; height: 150px; object-fit: cover;">
                    <h4><?= htmlspecialchars($user['nom']); ?></h4>
                    <p class="text-muted"><?= htmlspecialchars($user['email']); ?></p>
                    <p class="badge bg-primary"><?= ucfirst($user['role']); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile Details</div>
                <div class="card-body">
                    <p><strong>Name:</strong> <?= htmlspecialchars($user['nom']); ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></p>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($user['numero_telephone']); ?></p>
                    <p><strong>Role:</strong> <?= ucfirst($user['role']); ?></p>
                    <p><strong>Status:</strong> <?= htmlspecialchars($user['statut']); ?></p>
                    <p><strong>Account Created:</strong> <?= htmlspecialchars($user['cree_a']); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Back to Top Button -->
<a href="#" class="btn btn-primary p-3 back-to-top"><i class="fa fa-angle-double-up"></i></a>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/isotope/isotope.pkgd.min.js"></script>
<script src="lib/lightbox/js/lightbox.min.js"></script>

<!-- Template Javascript -->
<script src="js/main.js"></script>
</body>
</html>
