<?php include 'header.php'; ?>

<!-- Hero Section Start -->

<div class="page-inner-hero zigzag-bg about-page-hero">
    <div class="page-header-img" style="background: url(images/contact-hero.jpg) no-repeat;">
        <div class="container" data-aos="fade-up" data-aos-duration="1000">
            <h1>Contact Us</h1>
            <ol class="breadcrumb">
                <li><a href="#" class="">Home</a></li>
                <li class="active">Contact Us</li>
            </ol>
        </div>
    </div>
</div>

<!-- Hero Section End -->

<section class="inner-content-section p-0">

    <!-- Contact Form Section Start -->

    <div class="contact-main-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-7">
                    <div class="contact-form-container">
                        <!-- Success Message Placeholder -->
                        <?php if (isset($_GET['success']) && $_GET['success'] === 'true') : ?>
                            <div id="success-message" style="color:green; font-weight:bold; text-align:left;">
                                Your message has been sent successfully!
                            </div>
                        <?php endif; ?>
                        <div class="section-title" data-aos="fade-up" data-aos-duration="1000">
                            <h4>Write To Us.....</h4>
                            <p>….about your queries, concerns, feedback. We are all ears.</p>
                        </div>
                        <div>
                            <form action="submit_contact.php" class="form-main" method="POST">
                                <div class="input-group w-50">
                                    <label for="name" class="form-label">Name:</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                    <div class="line"></div>
                                </div>
                                <div class="input-group w-50">
                                    <label for="organisation" class="form-label">Organisation Name:</label>
                                    <input type="text" class="form-control" id="organisation" name="organisation">
                                    <div class="line"></div>
                                </div>
                                <div class="input-group w-50">
                                    <label for="email" class="form-label">E-mail:</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="input-group w-50">
                                    <label for="phone" class="form-label">Phone Number:</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" pattern="[0-9]{10}" required>
                                    <div class="line"></div>
                                </div>
                                <div class="input-group w-100">
                                    <label for="message" class="form-label">Message:</label>
                                    <textarea class="form-control" rows="6" id="message" name="message" required></textarea>
                                    <div class="line"></div>
                                </div>
                                <div class="btn-group">
                                    <input type="submit" class="btn yellow" value="Submit Message">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-5">
                    <div class="contact-info-main">
                        <div class="contact-info-block" data-aos="fade-up" data-aos-duration="1000">
                            <div class="contact-icon"><img src="images/email-icon.png" alt=""></div>
                            <div class="contact-text">
                                <div class="label">Email</div>
                                <p><a href="mailto:example@resilientkidz.com">example@resilientkidz.com</a></p>
                            </div>
                        </div>
                        <div class="contact-info-block" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                            <div class="contact-icon"><img src="images/phone-icon.png" alt=""></div>
                            <div class="contact-text">
                                <div class="label">Phone</div>
                                <p><a href="tel:+091-413-554-8598" title="(+091) 413 554 8598">(+091) 413 554 8598</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Form Section End -->

    <!-- Map Section Start -->

    <div class="map-direction-section top-zigzag-bg" data-aos="fade-up" data-aos-duration="1000">
        <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d8465.52019564277!2d72.87772566571091!3d19.065467677346128!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1slokmanya%20tilak%20terminus!5e0!3m2!1sen!2sin!4v1703158029991!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    <!-- Map Section End -->

</section>

<?php include 'footer.php'; ?>