
<?php
include '../../controller/QuizController.php';
$quizController = new QuizController();
$quizzes = $quizController->listQuizzes();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Quiz List</title>
    <link href="css/style.css" rel="stylesheet" />
</head>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
   
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>
            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Quiz List</h1>
                </div>

                <!-- Content Row -->
                <div class="row">

                    <div class="col-xl-12 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th>Category</th>
                                                    <th>Created At</th>
                                                    <th colspan="2">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($list as $quiz) {
                                                ?>
                                                <tr>
                                                    <td><?= $quiz['id']; ?></td>
                                                    <td><?= $quiz['title']; ?></td>
                                                    <td><?= $quiz['description']; ?></td>
                                                    <td><?= $quiz['category']; ?></td>
                                                    <td><?= $quiz['created_at']; ?></td>
                                                    <td align="center">
                                                        <form method="POST" action="updateQuiz.php">
                                                            <input type="submit" name="update" value="Update">
                                                            <input type="hidden" value="<?= $quiz['id']; ?>" name="id">
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <a href="deleteQuiz.php?id=<?= $quiz['id']; ?>">Delete</a>
                                                    </td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    <!-- Available Quizzes Section End -->

    <!-- Footer Start -->
  
    <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Quiz Management 2024</span>
                        </div>
                    </div>
                </footer>

            </div>

        </div>
    <!-- Footer End -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <!-- Template JavaScript -->
    <script src="js/main.js"></script>
</body>

</html>

