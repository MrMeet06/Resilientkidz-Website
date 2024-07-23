<!doctype html>
<html lang="en">
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resilient Kidz</title>

    <!-- Favicon Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@600;700&family=Gochi+Hand&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Bootstrap Css -->
    <link rel="stylesheet" type="text/css" media="all" href="css/bootstrap.min.css">

    <!-- Animation Css -->
    <link rel="stylesheet" type="text/css" media="all" href="css/aos.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" media="all" href="css/fontawesome.min.css">

    <!-- Popup Css -->
    <link rel="stylesheet" type="text/css" media="all" href="css/magnific-popup.css">

    <!-- Menu Css -->
    <link rel="stylesheet" type="text/css" media="all" href="css/webslidemenu.css" />

    <!-- Slider Css -->
    <link rel="stylesheet" type="text/css" media="all" href="css/slick.css" />
    <link rel="stylesheet" type="text/css" media="all" href="css/slick-theme.css" />

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.min.js"></script>

    <!-- Main css -->
    <link rel="stylesheet" type="text/css" media="all" href="css/style.css">
    <link rel="stylesheet" type="text/css" media="all" href="css/custom.css">
</head>

<body>
    <div class="wsmenucontainer clearfix">
        <div id="overlapblackbg"></div>

        <!-- Header Start -->
        <header class="fixed-top">
            <div class="container">
                <div class="logo">
                    <a href="index.php" title="Resilient Kidz" rel="home">
                        <img src="images/logo.png" alt="Resilient Kidz" width="" height="">
                    </a>
                </div>
                <div class="navigation wsmain">
                    <nav class="wsmenu clearfix">
                        <ul class="mobile-sub wsmenu-list">
                            <li><a href="index.php" class="active">Home</a></li>
                            <li><a href="about.php">About</a>
                                <ul class="wsmenu-submenu">
                                    <li><a href="#">Submenu One</a></li>
                                    <li><a href="#">Submenu Two</a>
                                        <ul class="wsmenu-submenu-sub">
                                            <li><a href="#">Submenu item 1 Sub</a></li>
                                            <li><a href="#">Submenu item 2 Sub</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="programs.php">Programs</a></li>
                            <li><a href="testimonials.php">Testimonials</a></li>
                            <li><a href="blog.php">Blog</a></li>
                            <li><a href="contact.php">Contact Us</a></li>
                            <li class="d-md-none"><a href="#webinar-registration-popup" class="popup-with-form">Support</a></li>
                            <li class="d-md-none"><a href="login.php" class="">Login</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="header-right">
                    <div class="btn-block d-md-flex d-none">
                        <a href="#webinar-registration-popup" class="btn blue popup-with-form" title="Support">Support</a>
                        <a href="login.php" class="btn " title="Login">Login</a>
                        <!-- Register for Webinar Popup -->
                        <div id="webinar-registration-popup" class="webinar-registration-popup popup-container mfp-hide">
                            <div class="row g-0">
                                <div class="col-md-6">
                                    <div class="webinar-registration-left"><img src="images/webinar-registration-img.jpg" alt=""></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="webinar-registration-right">
                                        <h2>Register for Webinar</h2>
                                        <p>Some text Some text Some text Some text Some text Some text Some text</p>
                                        <form id="webinar-form" action="register.php" method="POST" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="fullname" class="form-label">Name:</label>
                                                <div class="input-group">
                                                    <i class="fa-regular fa-user"></i>
                                                    <input type="text" class="form-control" id="fullname" name="fullname" aria-describedby="Name" required>
                                                    <div class="line"></div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="email" class="form-label">E-mail:</label>
                                                <div class="input-group">
                                                    <i class="fa-solid fa-at"></i>
                                                    <input type="email" class="form-control" id="email" name="email" aria-describedby="E-mail:" required>
                                                    <div class="line"></div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password:</label>
                                                <div class="input-group">
                                                    <span class="eye-icon" onclick="togglePasswordVisibility()">
                                                        <i class="far fa-eye" id="eye"></i>
                                                    </span>
                                                    <input type="password" class="form-control" id="password" name="password" required>
                                                    <div class="line"></div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="phonenumber" class="form-label">Phone Number:</label>
                                                <div class="input-group">
                                                    <i class="fa-solid fa-mobile-screen-button"></i>
                                                    <input type="tel" class="form-control" id="phonenumber" name="phonenumber" required>
                                                    <div class="line"></div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="date" class="form-label">Date of Webinar:</label>
                                                <div class="input-group">
                                                    <input type="date" class="form-control" id="date" name="date" required>
                                                    <div class="line"></div>
                                                </div>
                                            </div>

                                            <div class="btn-group">
                                                <button type="submit" class="btn yellow" name="Register">Register</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wsmobileheader clearfix">
                        <a id="wsnavtoggle" class="animated-arrow"><span></span></a>
                    </div>
                </div>
            </div>
        </header>
        <!-- Header End -->