<?php
session_start();
if (!isset($_SESSION['user_token']) || !isset($_SESSION['user_id'])) {
    header("Location: html/sign_in.html");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>NexDegree - Educational Platform</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Educational Platform" name="keywords">
    <meta content="NexDegree - Where Knowledge Knows No Boundaries" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

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

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
<!-- Navbar Start -->
<div class="container-fluid bg-light position-relative shadow">
    <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5">
        <a href="index.php" class="navbar-brand font-weight-bold text-secondary" style="font-size: 50px;">
            <i class="fa fa-graduation-cap"></i>
            <span class="text-primary">NexDegree</span>
        </a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
            <div class="navbar-nav font-weight-bold mx-auto py-0">
                <a href="index.php" class="nav-item nav-link active">Home</a>
                <a href="about.php" class="nav-item nav-link">About</a>
                <a href="courses.php" class="nav-item nav-link">Courses</a>
                <a href="teachers.php" class="nav-item nav-link">Teachers</a>
                <a href="gallery.php" class="nav-item nav-link">Gallery</a>
                <a href="contact.php" class="nav-item nav-link">Contact</a>
            </div>
            <?php if (isset($_SESSION['user_token'])): ?>
            <!-- User is logged in -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Account</a>
                <div class="dropdown-menu rounded-0 m-0">
                    <a href="profile.php" class="dropdown-item">Profile</a>
                    <a href="settings.php" class="dropdown-item">Settings</a>
                    <a href="logout.php" class="dropdown-item">Logout</a>
                </div>
            </div>
            <?php else: ?>
            <!-- User is not logged in -->
            <a href="html/sign_in.html" class="btn btn-primary px-4">Login</a>
            <?php endif; ?>
        </div>
    </nav>
</div>
<a href="#" class="btn btn-primary p-3 back-to-top"><i class="fa fa-angle-double-up"></i></a>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/isotope/isotope.pkgd.min.js"></script>
<script src="lib/lightbox/js/lightbox.min.js"></script>
<script src="mail/jqBootstrapValidation.min.js"></script>
<script src="mail/contact.js"></script>
<script src="js/main.js"></script>
</body>

</html>
