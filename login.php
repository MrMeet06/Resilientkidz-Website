<?php include 'header.php'; ?>



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
                <form id="login-form" action="login.php" method="POST">
                    <div class="input-group">
                        <label for="login_email" class="form-label">E-mail:</label>
                        <input type="text" class="form-control" id="login_email" name="email" placeholder="E-mail" required>
                        <div class="line"></div>
                    </div>
                    <div class="input-group">
                        <label for="login_password" class="form-label">Password:</label>
                        <span class="eye-icon" onclick="togglePasswordVisibility()">
                            <i class="far fa-eye" id="eye"></i>
                        </span>
                        <input type="password" class="form-control" id="login_password" name="password" required>
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
                    <p>Don't have an account? <a href="#" title="Register Now">Register Now</a></p>
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
<!-- JavaScript for toggling password visibility -->
<script>
    function togglePasswordVisibility() {
        var passwordField = document.getElementById("password");
        var eyeIcon = document.getElementById("eye");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
</script>

</body>

</html>

<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to fetch the user data based on the provided email
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            echo "<script>alert('You have successfully login');</script>";
            // header('Location: dashboard.php');
            // exit();
        } else {
            echo "<script>alert('Something Went Wrong');</script>";
        }
    } else {
        echo 'no_user_found';
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'invalid_request';
}
?>