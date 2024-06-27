<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currus - Car Parts</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            position: relative;
            height: 100vh;
            margin: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .content {
            flex: 1;
            overflow-y: auto;
            background-image: url('https://images.unsplash.com/photo-1593142927924-087946ba0a16?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .custom-section {
            border: 1px solid #000;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
        }
        .social-icons a {
            margin: 0 10px;
            color: #000;
            font-size: 24px;
            text-decoration: none;
            transition: color 0.3s;
        }
        .social-icons a:hover {
            color: #555; /* Optional: change color on hover */
        }
        .navbar, footer {
            background-color: #212529;
        }
        .navbar-brand, .navbar-nav .nav-link, footer .text-muted {
            color: white !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="#"><b>Currus Connect</b></a>
    </nav>

    <div class="content">
        <section class="py-5">
            <div class="container custom-section">
                <div class="text-center">
                    <h1 class="font-bold">Welcome to Currus Connect</h1>
                </div>
                <div class="row justify-content-center text-center mb-2 mb-lg-4">
                    <div class="col-lg-8 col-xxl-7">
                        <h2 class="display-5 fw-bold"></h2>
                        <p class="lead"><strong>We are currently working hard to bring you the best car parts and accessories. <br> Please feel free to contact us if you have any questions</strong></p>
                        <h4>Contact us at <i>+(45) 28 18 08 49</i></h4>
                        <h5>Or</h5>
                        <h4>Email us at <i>service@currus-connect.com</i></h4>
                        <h5>Please do not hesitate to contact us, best regards <i>Currus Connect.</i></h5>
                    </div>
                    <div class="col-12 text-center mt-5">
                        <h5>If you would like to see more to Currus Connect, Feel free to check out our socials!</h5>
                        <div class="social-icons mt-4">
                            <a href="https://www.linkedin.com" target="_blank"><i class="fab fa-linkedin fa-2x"></i></a>
                            <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook fa-2x"></i></a>
                            <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram fa-2x"></i></a>
                            <a href="https://www.twitter.com" target="_blank"><i class="fab fa-twitter fa-2x"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <footer class="py-4">
        <div class="container text-center">
            <span class="text-muted">All rights reserved.</span> <br>
            <span class="text-muted">© 2024 Currus Connect ApS</span>
        </div>
    </footer>
</body>
</html>
