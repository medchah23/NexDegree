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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
    <link href="css/style1.css" rel="stylesheet" />
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
            <a href="index.php" class="nav-item nav-link active">Home</a>
                <a href="accueil.php" class="nav-item nav-link active">Forum</a>
                <a href="about.html" class="nav-item nav-link">About</a>
            <a href="contact.html" class="nav-item nav-link">Contact</a>
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
    $postId = isset($post['post_id']) && is_numeric($post['post_id']) ? (int)$post['post_id'] : 0; 
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

<?php
                                      if ($postId == $comment['post_id']) {
                                        ?>

<li>
                                            <strong><?php echo isset($comment['author']) ? $comment['author'] : 'Anonymous'; ?>:</strong>
                                            <?php echo isset($comment['content']) ? $comment['content'] : 'No content'; ?>
                                            <span class="text-muted">on <?php echo isset($comment['created_at']) ? $comment['created_at'] : 'Date not available'; ?></span>
                                        </li>

                                <?php } }
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
    <!-- Chatbot Toggler -->
    <button id="chatbot-toggler">
      <span class="material-symbols-rounded">mode_comment</span>
      <span class="material-symbols-rounded">close</span>
    </button>

    <div class="chatbot-popup">
      <!-- Chatbot Header -->
      <div class="chat-header">
        <div class="header-info">
          <svg class="chatbot-logo" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 1024 1024">
            <path
              d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5zM867.2 644.5V453.1h26.5c19.4 0 35.1 15.7 35.1 35.1v121.1c0 19.4-15.7 35.1-35.1 35.1h-26.5zM95.2 609.4V488.2c0-19.4 15.7-35.1 35.1-35.1h26.5v191.3h-26.5c-19.4 0-35.1-15.7-35.1-35.1zM561.5 149.6c0 23.4-15.6 43.3-36.9 49.7v44.9h-30v-44.9c-21.4-6.5-36.9-26.3-36.9-49.7 0-28.6 23.3-51.9 51.9-51.9s51.9 23.3 51.9 51.9z"
            />
          </svg>
          <h2 class="logo-text">Chatbot</h2>
        </div>
        <button id="close-chatbot" class="material-symbols-rounded">keyboard_arrow_down</button>
      </div>

      <!-- Chatbot Body -->
      <div class="chat-body">
        <div class="message bot-message">
          <svg class="bot-avatar" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 1024 1024">
            <path
              d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5zM867.2 644.5V453.1h26.5c19.4 0 35.1 15.7 35.1 35.1v121.1c0 19.4-15.7 35.1-35.1 35.1h-26.5zM95.2 609.4V488.2c0-19.4 15.7-35.1 35.1-35.1h26.5v191.3h-26.5c-19.4 0-35.1-15.7-35.1-35.1zM561.5 149.6c0 23.4-15.6 43.3-36.9 49.7v44.9h-30v-44.9c-21.4-6.5-36.9-26.3-36.9-49.7 0-28.6 23.3-51.9 51.9-51.9s51.9 23.3 51.9 51.9z"
            />
          </svg>
          <!-- prettier-ignore -->
          <div class="message-text"> Hey there 👋 <br /> How can I help you today? </div>
        </div>
      </div>

      <!-- Chatbot Footer -->
      <div class="chat-footer">
        <form action="#" class="chat-form">
          <textarea placeholder="Message..." class="message-input" required></textarea>
          <div class="chat-controls">
            <button type="button" id="emoji-picker" class="material-symbols-outlined">sentiment_satisfied</button>
            <div class="file-upload-wrapper">
              <input type="file" accept="image/*" id="file-input" hidden />
              <img src="#" />
              <button type="button" id="file-upload" class="material-symbols-rounded">attach_file</button>
              <button type="button" id="file-cancel" class="material-symbols-rounded">close</button>
            </div>
            <button type="submit" id="send-message" class="material-symbols-rounded">arrow_upward</button>
          </div>
        </form>
      </div>
    </div>

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
    <script src="https://cdn.jsdelivr.net/npm/emoji-mart@latest/dist/browser.js"></script>
    <script src="js/main.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>
