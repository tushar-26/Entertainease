<?php
session_start();
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Male_Fashion Template">
    <meta name="keywords" content="Male_Fashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/jpg" href="img/logo.jpg">
    <title>Contact Page</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <style>
        .contact__text {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .contact__text .section-title {
            margin-bottom: 20px;
        }

        .contact__text ul {
            list-style: none;
            padding: 0;
        }

        .contact__text ul li {
            margin-bottom: 10px;
        }

        .contact__text ul li h4 {
            margin-bottom: 5px;
        }

        .contact__text ul li p {
            margin: 0;
        }

        .contact__image {
            
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .contact__image img {
            max-width: 100%;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <?php
    include("header.php");
    ?>

    <!-- Contact Section Begin -->
    <section class="contact spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 contact__text">
                    <div class="section-title">
                        <span>Information</span>
                        <h2>Contact Us</h2>
                        <p>Got questions or need assistance? We’re here to help! At EntertainEase, we value our customers and are committed to providing prompt support for all your movie ticket booking needs. Whether you have inquiries, face any issues, or just want to share your thoughts, don’t hesitate to reach out.

                            You can contact us through our email or by providing feedback, and our dedicated support team will ensure your concerns are addressed as quickly as possible. Thank you for choosing EntertainEase — we’re just a message away!
                        </p>
                    </div>
                    <ul>
                        <li>
                            <h4>Regards,</h4>
                            <p><span style="color: red; font-weight: bold; margin-right:5px;">Tushar,</span> Vats, Kirtan, Darshita, Tejal, and Khushi
                                <br /><span style="color:navy; font-weight: bold;">savdiyatushar17@gmail.com</span><br>
                                vatspatel45@gmail.com<br />
                                kirtan656@gmail.com</p>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6 col-md-6 contact__image">
                    <img src="img/Contact.jpg" alt="Contact Image">
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->

    <!-- Footer Section Begin -->
    <?php
    include("footer.php");
    ?>

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.nicescroll.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>