<?php
include 'header.php';
include 'functions.php';

// Fetch the blog post
$blog_post = getBlogPostWithId();
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
                        <p>
                            <?php
                            if (is_array($blog_post['description'])) {
                                echo implode(', ', $blog_post['description']);
                            } else {
                                echo htmlspecialchars($blog_post['description']);
                            }
                            ?>
                        </p>
                        <p><strong>Posted on: <?php echo htmlspecialchars(date('F j, Y, g:i a', strtotime($blog_post['created_at']))); ?></strong></p>
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="comments-section">
                    <h5>Comments</h5>
                    <div id="commentsDiv"><?php echo displayComments($blog_post['id']); ?></div>
                </div>

                <!-- Comment Form -->
                <div class="post-comment">
                    <div class="post-comment-section">
                        <div class="contact-main-section-inner">
                            <div class="contact-row-top">
                                <div id="respond" class="comment-respond">
                                    <form id="comment-form" class="comment-form form-main" method="POST" novalidate>
                                        <input type="hidden" name="blog_id" value="<?php echo htmlspecialchars($blog_post['id']); ?>">
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
                                                    <input type="email" id="email" name="email" class="form-control" required>
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
                                                    <input type="button" class="btn yellow" value="Submit" onclick="ajaxSubmitComment();">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div id="ajaxMessage"></div>
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