<?php
// Start the session at the top of the file before any output
session_start();

// Include necessary files
include 'config.php';
include 'loginfunction.php'; // Include the file with the login function

// Call the function to handle login
handleLogin();
?>
<?php include 'header.php';?>
<!-- Hero Section Start -->

<div class="page-login-hero zigzag-bg" style="background: url(images/login-hero.jpg) no-repeat;">

    <div class="container">
        <div class="login-main" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="150">
            <div class="login-title">
                <h1>Sign In</h1>
            </div>

            <div class="login-form">
                <div class="section-title">
                    <h4>Let's Get Started</h4>
                    <p>Sign in to continue to ResilientKidzAdmin.</p>
                </div>
                <form id="login-form" action="login.php" method="POST" autocomplete="on">
                    <div class="input-group">
                        <label for="login_email" class="form-label">E-mail:</label>
                        <input type="email" class="form-control" id="login_email" name="email" placeholder="E-mail" required autocomplete="email">
                        <div class="line"></div>
                    </div>
                    <div class="input-group">
                        <label for="login_password" class="form-label">Password:</label>
                        <span class="eye-icon" onclick="togglePasswordVisibility()">
                            <i class="far fa-eye" id="eye"></i>
                        </span>
                        <input type="password" class="form-control" id="login_password" name="password" required autocomplete="current-password">
                        <div class="line"></div>
                    </div>
                    <div class="input-group justify-content-between">
                        <div class="custom-checkbox">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">Remember Me</label>
                        </div>
                        <p><a href="#" title="Forgot Password?">Forgot Password?</a></p>
                    </div>
                    <div class="btn-group">
                        <input type="submit" class="btn yellow" value="Sign In">
                    </div>
                </form>
                <div class="login-other-text p-1 mt-4 " style="border-radius: 0%;">
                    <p>Don't have an account? <a href="#webinar-registration-popup" class=" popup-with-form" title="Register Now">Register Now</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Section End -->

</div>
<!-- Footer Start -->

<footer>
    <div class="footer-bottom">
        <div class="container">
            <p>© 2023 Resilient Kidz. All rights reserved</p>
        </div>
    </div>
</footer>

<!-- Footer End -->
<!-- Bootstrap Js -->

<script src="js/jquery-3.7.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<!-- Animation Js -->

<script type="text/javascript" src="js/jquery.easing.js"></script>
<script type="text/javascript" src="js/aos.js"></script>

<!-- Menu Js -->

<script type="text/javascript" src="js/webslidemenu.js"></script>
<!-- Slider Js -->

<script type="text/javascript" src="js/slick.min.js"></script>
<!-- Popus Js -->

<script type="text/javascript" src="js/magnific-popup.min.js"></script>
<!-- Masonry Js -->

<script type="text/javascript" src="js/isotope.pkgd.min.js"></script>

<!-- Script Js -->

<script type="text/javascript" src="js/main.js"></script>

<!-- Include Bootstrap JS (optional, if needed for your project) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>


