<?php include 'header.php'; ?>
<?php include 'blogdata.php'; // This should contain the logic to connect to your database 
?>

<?php
// Get the Blog ID from the URL
if (isset($_GET['id'])) {
    $blog_id = $_GET['id'];

    // Check if the database connection is successful
    if ($conn === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT * FROM blog WHERE id = ?");

    // Check if the prepare statement was successful
    if ($stmt === false) {
        die("ERROR: Could not prepare query: " . $conn->error);
    }

    // Bind the parameters
    $stmt->bind_param("i", $blog_id);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();
    $blog_post = $result->fetch_assoc();
}
?>

<!-- Hero Section Start -->
<div class="page-inner-header top-zigzag-bg blue programs-page-hero">
    <div class="container" data-aos="fade-up" data-aos-duration="1000">
        <h1><?php echo htmlspecialchars($blog_post['title']); ?></h1>
        <ol class="breadcrumb">
            <li><a href="#" class="">Home</a></li>
            <li><a href="#" class="">Blog</a></li>
            <li class="active"><?php echo htmlspecialchars($blog_post['title']); ?></li>
        </ol>
    </div>
</div>
<!-- Hero Section End -->

<section class="inner-content-section p-0">
    <div class="programs-list-section blog-single-section">
        <div class="container" data-aos="fade-up" data-aos-duration="1000">
            <div class="small-container">
                <div class="blog-single-col blog-col-8">
                    <div class="blog-single ">
                        <div class="top-author">
                            <p>
                                <img src="images/<?php echo htmlspecialchars($blog_post['image']); ?>" alt="<?php echo htmlspecialchars($blog_post['title']); ?>" class="aligncenter" width="100%" height="auto">
                            </p>
                        </div>
                        <h2><?php echo htmlspecialchars($blog_post['title']); ?></h2>
                        <p><?php echo htmlspecialchars($blog_post['description']); ?></p>
                        <p><strong>Posted on: <?php echo htmlspecialchars($blog_post['created_at']); ?></strong></p>
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="comments-section">
                    <h5>Comments</h5>
                    <?php include 'comments.php'; ?>
                </div>

                <div class="post-comment">
                    <div class="post-comment-section">
                        <div class="contact-main-section-inner">
                            <div class="contact-row-top">
                                <div id="respond" class="comment-respond">
                                    <form id="comment-form" class="comment-form form-main" method="POST" novalidate>
                                        <input type="hidden" name="blog_id" value="<?php echo $blog_id; ?>">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="post-comment-title single-comment-title">Leave a Comment</div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="input-group">
                                                    <label for="name" class="form-label">Name:</label>
                                                    <input type="text" id="name" name="name" class="form-control" required>
                                                    <div class="line"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="input-group">
                                                    <label for="email" class="form-label">E-mail:</label>
                                                    <input type="email" id="email1" name="email" class="form-control" required>
                                                    <div class="line"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input-group">
                                                    <label for="website" class="form-label">Website URL (http://example.com)</label>
                                                    <input type="text" id="website" name="website" class="form-control">
                                                    <div class="line"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input-group">
                                                    <label for="message" class="form-label">Message:</label>
                                                    <textarea id="message" name="message" class="form-control" rows="6" required></textarea>
                                                    <div class="line"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="btn-group">
                                                    <input type="submit" class="btn yellow" value="Submit">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div><!-- #respond -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- AJAX Form Submission -->
<script>
    $(document).ready(function() {
        $('#comment-form').on('submit', function(e) {
            e.preventDefault();

            // Validate form fields
            var name = $('#name').val().trim();
            var email = $('#email1').val().trim();
            var message = $('#message').val().trim();

            if (name === '' || email === '' || message === '') {
                alert('Please fill in all required fields.');
                return;
            }

            // Validate email format
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert('Please enter a valid email address.');
                return;
            }

            // Proceed with AJAX submission
            $.ajax({
                type: 'POST',
                url: 'submit_comment.php',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('.comments').append(response.html);
                        $('#comment-form')[0].reset();
                        alert('Comment added successfully!');
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('An error occurred while submitting the comment.');
                }
            });
        });
    });
</script>