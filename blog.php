<?php
include 'header.php';
include 'config.php'; // Ensure this file connects to your database
include 'functions.php'; // Include the file with your functions

// Fetch blog posts
$blogs = getBlogPosts($conn);
?>

<!-- Hero Section Start -->
<div class="page-inner-header top-zigzag-bg blue programs-page-hero">
    <div class="container" data-aos="fade-up" data-aos-duration="1000">
        <h1>Blog</h1>
        <ol class="breadcrumb">
            <li><a href="#" class="">Home</a></li>
            <li class="active">Blog</li>
        </ol>
    </div>
</div>
<!-- Hero Section End -->

<section class="inner-content-section p-0">
    <div class="programs-list-section blog-list-section">
        <div class="container" data-aos="fade-up" data-aos-duration="1000">
            <div class="section-title">
                <h2>Lorem Ipsum is simply dummy text</h2>
                <p>Sit amet consectetur adipiscing sedey eiusmod tempor incididunt</p>
            </div>
            <div class="container mt-5">
                <div class="row program-filter" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="150">
                    <div class="recent-article-list">
                        <div class="row">
                            <?php
                            if (!empty($blogs)) {
                                foreach ($blogs as $row) {
                                    $imageSrc = isset($row["image"]) && !empty($row["image"]) ? '/phpwork/projectwork/images/' . $row["image"] : '/phpwork/projectwork/images/program-img1.jpg';

                                    echo '<div class="col-md-4" data-aos="fade-up" data-aos-duration="1000">';
                                    echo '  <div class="article-block">';
                                    echo '      <div class="article-thumb"><a href="blog-single.php?id=' . htmlspecialchars($row["id"]) . '" title=""><img src="' . htmlspecialchars($imageSrc) . '" alt="' . htmlspecialchars($row["title"]) . '"></a></div>';
                                    echo '      <div class="article-content">';
                                    echo '          <div class="other-info">';
                                    echo '              <ul>';
                                    echo '                  <li class="date">' . date('d M Y', strtotime($row["created_at"])) . '</li>';
                                    echo '                  <li class="comments"><a href="#" title="Comments">Comments <strong>' . htmlspecialchars($row['comment_count']) . '</strong></a></li>';
                                    echo '              </ul>';
                                    echo '          </div>';
                                    echo '          <h2><a href="blog-single.php?id=' . htmlspecialchars($row["id"]) . '" title="">' . htmlspecialchars($row["title"]) . '</a></h2>';
                                    echo '          <p>' . htmlspecialchars($row["short_description"]) . '</p>';
                                    echo '          <p><a class="btn-link" href="blog-single.php?id=' . htmlspecialchars($row["id"]) . '" title="">Read more <i class="fa-solid fa-arrow-right"></i></a></p>';
                                    echo '      </div>';
                                    echo '  </div>';
                                    echo '</div>';
                                }
                            } else {
                                echo "No blog posts found.";
                            }
                            ?>
                        </div>
                        <div class="btn-block text-center mt-4" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                            <a href="#" class="btn yellow" title="View All Blogs">Load More Blogs</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include 'footer.php'; ?>