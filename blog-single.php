<?php include 'header.php'; ?>
<?php include 'blogdata.php'; ?>

<?php
if (isset($_GET['id'])) {
    $blog_id = intval($_GET['id']);

    if ($conn === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    $stmt = $conn->prepare("SELECT * FROM blog WHERE id = ?");
    if ($stmt === false) {
        die("ERROR: Could not prepare query: " . $conn->error);
    }
    $stmt->bind_param("i", $blog_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $blog_post = $result->fetch_assoc();
}
?>

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

<section class="inner-content-section p-0">
    <div class="programs-list-section blog-single-section">
        <div class="container" data-aos="fade-up" data-aos-duration="1000">
            <div class="small-container">
                <div class="blog-single-col blog-col-8">
                    <div class="blog-single">
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
                    <?php
                    // Pass the blog_id as a GET parameter to comments.php to fetch the comments
                    $blog_id = isset($blog_id) ? $blog_id : 0;
                    include 'comments.php';
                    ?>
                </div>

                <!-- Comment Form -->
                <div class="post-comment">
                    <div class="post-comment-section">
                        <div class="contact-main-section-inner">
                            <div class="contact-row-top">
                                <div id="respond" class="comment-respond">
                                    <form id="comment-form" class="comment-form form-main" method="POST" novalidate>
                                        <input type="hidden" name="blog_id" value="<?php echo $blog_id; ?>">
                                        <div class="row">
                                            <!-- Form fields remain the same -->
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

            $.ajax({
                type: 'POST',
                url: 'comments.php', // The same file handles submission and fetching
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        // Append the new comment to the top of the comment list
                        $('.comments').prepend(response.html);
                        // Update the comment count
                        var commentCount = parseInt($('.comment-main-title').text().match(/\d+/)) + 1;
                        $('.comment-main-title').text('Comments (' + commentCount + ')');
                        // Reset the form
                        $('#comment-form')[0].reset();
                        alert('Comment added successfully!');
                        // Remove "No comments yet" message if it exists
                        $('.no-comments-message').remove();
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