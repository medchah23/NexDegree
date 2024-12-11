<?php
include '../../controller/CommentController.php';
$commentC = new CommentController();
$commentsList = $commentC->listComments();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back Office - Comments</title>
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex; 
        }

        #sidebar {
            width: 250px;
            background-color: # white;
            min-height: 100vh;
            position: fixed; 
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px); 
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        a {
            color: #007BFF;
            text-decoration: none;
            margin-right: 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        .btn {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link" href="backoffice.php">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="posts.php">
                    <i class="bi bi-grid"></i>
                    <span>Posts</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="comments.php">
                    <i class="bi bi-grid"></i>
                    <span>Comments</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <header id="header" class="header fixed-top d-flex align-items-center">
            <div class="d-flex align-items-center justify-content-between">
                <a href="backoffice.php" class="logo d-flex align-items-center">
                    <img src="assets/img/logo.png" alt="">
                </a>
                <i class="bi bi-list toggle-sidebar-btn"></i>
            </div>
        </header>

        <h1>Dashboard - Manae Comments</h1>

        <!-- Add New Comment Form -->
        <a href="addcomment.php" class="btn">Add a New Comment</a>

        <!-- Comments Table -->
        <h2>Comments List</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Comment ID</th>
                    <th>Post ID</th>
                    <th>User ID</th>
                    <th>Comment Content</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($commentsList as $comment): ?>
                <tr>
                    <td><?= htmlspecialchars($comment['comment_id']) ?></td>
                    <td><?= htmlspecialchars($comment['post_id']) ?></td>
                    <td><?= htmlspecialchars($comment['user_id']) ?></td>
                    <td><?= htmlspecialchars(mb_strimwidth($comment['content'], 0, 100, '...')) ?></td>
                    <td><?= htmlspecialchars($comment['created_at']) ?></td>
                    <td>
                        <a href="editComment.php?id=<?= $comment['comment_id'] ?>">Edit</a> |
                        <a href="deleteComment.php?id=<?= $comment['comment_id'] ?>" onclick="return confirm('Are you sure you want to delete this comment?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <footer id="footer" class="footer">
            <div class="copyright">
                &copy; Copyright <strong><span>NEXDEGREE</span></strong>. All Rights Reserved
            </div>
        </footer>
    </div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>   
    <script src="backoffice.js"></script>
</body>
</html>