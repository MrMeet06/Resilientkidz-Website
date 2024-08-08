<?php
include 'header.php';
include 'functions.php';
?>

<!-- Hero Section Start -->
<div class="page-inner-header top-zigzag-bg blue programs-page-hero">
    <div class="container" data-aos="fade-up" data-aos-duration="1000">
        <h1>Programs</h1>
        <ol class="breadcrumb">
            <li><a href="#" class="">Home</a></li>
            <li class="active">Programs</li>
        </ol>
    </div>
</div>
<!-- Hero Section End -->

<section class="inner-content-section p-0">

    <!-- Programs List Section Start -->
    <div class="programs-list-section">
        <div class="container" data-aos="fade-up" data-aos-duration="1000">
            <div class="section-title">
                <h2>Lorem Ipsum is simply dummy text</h2>
            </div>
            <div class="controlls" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                <ul id="program-flters">
                    <li data-filter="*" class="filter-active">All</li>
                    <?php
                    $categories = getCategories();
                    foreach ($categories as $cat_data) {
                    ?>
                        <li data-filter=".<?php echo strtolower(str_replace(' ', '-', $cat_data['name'])); ?>"><?php echo $cat_data['name']; ?></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="row program-filter" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="150">
                <?php
                $programs = getPrograms();
                if (!empty($programs)) {
                    foreach ($programs as $program_data) {
                ?>
                        <div class="col-md-6 col-lg-4 grid-item <?php echo strtolower(str_replace(' ', '-', $program_data['category_name'])); ?>">
                            <div class="program-block">
                                <div class="program-thumb"><img src="<?php echo $program_data['image']; ?>" alt="Program Image"></div>
                                <div class="program-info">
                                    <div class="years">1-2 years</div>
                                    <h2><?php echo $program_data['name']; ?></h2>
                                    <p><?php echo $program_data['description']; ?></p>
                                    <div class="price-info">
                                        <ul>
                                            <li>
                                                <div class="label">Only</div>
                                                <div class="price"><strong>₹</strong><?php echo number_format($program_data['price'], 2); ?></div>
                                            </li>
                                            <li>
                                                <div class="label">Duration</div>
                                                <div class="duration"><?php echo $program_data['category_name']; ?></div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="btn-group">
                                        <div class="select-program custom-checkbox">
                                            <input class="form-check-input select-program-btn" type="checkbox" value="" id="select-program-<?php echo $program_data['id']; ?>" data-price="<?php echo $program_data['price']; ?>">
                                            <label class="form-check-label" for="select-program-<?php echo $program_data['id']; ?>">Select Program</label>
                                        </div>
                                        <div class="btn-info"><a href="#" class="btn yellow" title="view more">view more</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "No programs found.";
                }
                ?>
            </div>
        </div>
    </div>
    <!-- Programs List Section End -->

</section>

<!-- Popup Container -->
<div class="programs-popup">
    <div class="container">
        <div class="program-fees">
            <div class="object top left"> <img src="images/object-8-2.png" title=""> </div>
            <div class="label">ONLY PAY</div>
            <div class="price"><strong>₹</strong><span id="popup-price">0</span> <strike>₹2,997</strike></div>
        </div>
        <div class="program-purchase"><a href="#" class="btn yellow" title="purchase now">purchase now</a></div>
    </div>
</div>

<?php include 'footer.php'; ?>