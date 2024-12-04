<?php
include '../../controller/PostController.php';
include '../../controller/CommentController.php';

$postC = new PostController();
$commentC = new CommentController();
$postsList = $postC->listPosts();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Forum Website - frontoffice</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Free HTML Templates" name="keywords" />
    <meta content="Free HTML Templates" name="description" />
    <script>
        function validatePostForm(event) {
            const postTitle = document.getElementById('postTitle');
            const postContent = document.getElementById('postContent');
            
            let title = postTitle.value.trim();
            let content = postContent.value.trim();

            if (title === "") {
                alert("Title is required.");
                event.preventDefault(); 
                postTitle.focus();
                return false;
            }
            if (title.length < 5) {
                alert("Title must be at least 5 characters long.");
                event.preventDefault();
                postTitle.focus();
                return false;
            }

            if (content === "") {
                alert("Content is required.");
                event.preventDefault(); 
                postContent.focus();
                return false;
            }
            if (content.length < 10) {
                alert("Content must be at least 10 characters long.");
                event.preventDefault();
                postContent.focus();
                return false;
            }

            return true;
        }

        window.addEventListener('DOMContentLoaded', function () {
            const postForm = document.querySelector('#postForm form');
            if (postForm) {
                postForm.addEventListener('submit', validatePostForm);
            }
        });
    </script>
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
      href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito&display=swap"
      rel="stylesheet"
    />

    <!-- Font Awesome -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
      rel="stylesheet"
    />

    <!-- Flaticon Font -->
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet" />

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet" />
  </head>

  <body>
    <!-- Navbar Start -->
    <div class="container-fluid bg-light position-relative shadow">
      <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5">
        <a href="" class="navbar-brand font-weight-bold text-secondary" style="font-size: 50px">
          <img src="img/esprit.png" alt="">
        </a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
          <div class="navbar-nav font-weight-bold mx-auto py-0">
            <a href="acceuil.php" class="nav-item nav-link active">Home</a>
            <a href="about.html" class="nav-item nav-link">About</a>
            <a href="postfront.php" class="nav-item nav-link">Forum</a>
            <a href="contact.html" class="nav-item nav-link">Contact</a>
            <a href="backoffice.php" class="nav-item nav-link">Dashboard</a>
          </div>
          <a href="" class="btn btn-primary px-4">GET STARTED</a>
        </div>
      </nav>
    </div>
    <!-- Navbar End -->

    <!-- Header Start -->
    <div class="container-fluid bg-primary px-0 px-md-5 mb-5">
      <div class="row align-items-center px-3">
        <div class="col-lg-6 text-center text-lg-left">
          <h4 class="text-white mb-4 mt-5 mt-lg-0">Connect. Discuss. Share.</h4>
          <h1 class="display-3 font-weight-bold text-white">A Place to Share Ideas and Insights</h1>
          <p class="text-white mb-4">
            This forum is your gateway to knowledge and community. Here, you can ask questions, get answers, and learn from others' experiences. Join the conversation and let's learn together!
          </p>
          <a href="" class="btn btn-secondary mt-1 py-3 px-5">GET STARTED</a>
        </div>
        <div class="col-lg-6 text-center text-lg-right">
          <img class="img-fluid mt-5" src="img/header.png" alt="" />
        </div>
      </div>
    </div>
    <!-- Header End -->

    <section id="courses" class="courses section">
        <div class="container">
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            
            <button id="createPostBtn" class="btn btn-primary mb-4">Create Post</button>
            
            <div id="postForm" style="display:none;">
                <form method="POST" action="../BackOffice/addPost.php">
                    <div class="mb-3">
                        <label for="postTitle" class="form-label">Post Title</label>
                        <input type="text" class="form-control" id="postTitle" name="title" />
                    </div>
                    <div class="mb-3">
                        <label for="postContent" class="form-label">Post Content</label>
                        <textarea class="form-control" id="postContent" name="content" rows="4"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Post</button>
                </form>
            </div>

            <div class="row justify-content-center">
            <?php foreach ($postsList as $post) { 
    // Make sure the post ID is a valid integer
    $postId = isset($post['id']) && is_numeric($post['id']) ? (int)$post['id'] : 0; 
    $comments = $commentC->listComments($postId);
?>
                <div class="col-md-6 col-lg-4 mb-5">
                    <div class="post-item mx-auto">
                        <h4><?php echo isset($post['title']) ? $post['title'] : 'No Title'; ?></h4>
                        <p class="text-muted"><?php echo isset($post['content']) ? $post['content'] : 'No Content'; ?></p>
                        <p class="text-muted">Posted by: <?php echo isset($post['author']) ? $post['author'] : 'Unknown'; ?> on <?php echo isset($post['created_at']) ? $post['created_at'] : 'Date not available'; ?></p>

                        <!-- Comment Section -->
                        <div class="comments-section">
                            <h5>Comments</h5>
                            <ul>
                                <?php if (!empty($comments)) {
                                    foreach ($comments as $comment) { ?>
                                        <li>
                                            <strong><?php echo isset($comment['author']) ? $comment['author'] : 'Anonymous'; ?>:</strong>
                                            <?php echo isset($comment['content']) ? $comment['content'] : 'No content'; ?>
                                            <span class="text-muted">on <?php echo isset($comment['created_at']) ? $comment['created_at'] : 'Date not available'; ?></span>
                                        </li>
                                <?php } 
                                } else {
                                    echo '<li>No comments yet.</li>';
                                } ?>
                            </ul>

                            <form method="POST" action="../BackOffice/addComment.php">
                                <input type="hidden" name="post_id" value="<?php echo $postId; ?>" />
                                <div class="mb-3">
                                    <textarea class="form-control" name="content" rows="2" placeholder="Add a comment..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-secondary btn-sm">Post Comment</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('createPostBtn').addEventListener('click', function() {
            var postForm = document.getElementById('postForm');
            postForm.style.display = (postForm.style.display === 'none' || postForm.style.display === '') ? 'block' : 'none';
        });
    </script>
    
    <!-- Footer Start -->
    <div class="container-fluid bg-secondary text-white mt-5 py-5 px-sm-3 px-md-5">
      <div class="row pt-5">
        <div class="col-lg-3 col-md-6 mb-5">
          <a href="" class="navbar-brand font-weight-bold text-primary m-0 mb-4 p-0" style="font-size: 40px; line-height: 40px">
            <img src="img/esprit.png" alt="">
          </a>
          <p>
            This website is designed to make learning more accessible and engaging. You'll find a variety of resources and a supportive community to help you succeed.
          </p>
        </div>
        <div class="col-lg-3 col-md-6 mb-5">
          <h3 class="text-primary mb-4">Our Services</h3>
          <div class="d-flex flex-column justify-content-start">
            <a class="text-white mb-2" href="about.html"><i class="fa fa-angle-right mr-2"></i>About</a>
            <a class="text-white mb-2" href="blog.html"><i class="fa fa-angle-right mr-2"></i>Forum</a>
            <a class="text-white mb-2" href="contact.html"><i class="fa fa-angle-right mr-2"></i>Contact</a>
            <a class="text-white mb-2" href="team.html"><i class="fa fa-angle-right mr-2"></i>Our Team</a>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-5">
          <h3 class="text-primary mb-4">Contact Us</h3>
          <p><i class="fa fa-map-marker-alt mr-2"></i>Espirt, Ariana</p>
          <p><i class="fa fa-phone-alt mr-2"></i>+216 34 567 567</p>
          <p><i class="fa fa-envelope mr-2"></i>info@example.com</p>
          <div class="d-flex justify-content-start mt-4">
            <a class="btn btn-outline-primary btn-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
            <a class="btn btn-outline-primary btn-square mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
            <a class="btn btn-outline-primary btn-square mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
            <a class="btn btn-outline-primary btn-square" href="#"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
      </div>
    </div>
    <!-- Footer End -->

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
