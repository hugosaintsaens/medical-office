<?php 
    require 'securite/identification.php';
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Menu</title>
        <!-- Site Icons -->
        <link rel="shortcut icon" href="images/fevicon.ico.png" type="image/x-icon" />
        <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
        <!-- Bootstrap CSS -->
	   	<link rel="stylesheet" href="css/bootstrap.min.css">
	   	<!-- Site CSS -->
	   	<link rel="stylesheet" href="style.css">
	   	<!-- Colors CSS -->
	   	<link rel="stylesheet" href="css/colors.css">
	   	<!-- ALL VERSION CSS -->
	   	<link rel="stylesheet" href="css/versions.css">
	   	<!-- Responsive CSS -->
	   	<link rel="stylesheet" href="css/responsive.css">
	   	<!-- Custom CSS -->
	   	<link rel="stylesheet" href="css/custom.css">
    </head>
    <header>
        <div class="header-top wow fadeIn">
            <div class="container">
                <a href="menu.php"><img src="images/logo2.png" alt="#"></a>
           </div>
        </div>
        <div class="header-bottom wow fadeIn">
           <div class="container">
                <nav class="main-menu">
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li><a class="active" href="menu.php">Menu</a></li>
                            <li><a data-scroll href="usagers.php">Patients</a></li>
                            <li><a data-scroll href="medecins.php">Médecins</a></li>
                            <li><a data-scroll href="consultations.php">Consultations</a></li>
                            <li><a data-scroll href="statistiques.php">Statistiques</a></li>
                            <li><a data-scroll href="securite/deconnexion.php">Déconnexion</a></li>
						</ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>

    <body>
        <!-- LOADER -->
        <div id="preloader">
            <img class="preloader" src="images/loaders/heart-loading2.gif" alt="">
        </div>
        <!-- END LOADER -->

      <div id="doctors" class="parallax section db" data-stellar-background-ratio="0.4" style="background:#fff;" data-scroll-id="doctors" tabindex="-1">
        <div class="container">
            <div class="heading">
                </br></br></br></br>
               <h2>Menu</h2>
            </div>
            <div class="row dev-list text-center">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 wow fadeIn">
                    <a href="usagers.php"><img src="images/patient.png" alt="" class="img-responsive img-rounded"></a>
                    <div class="widget-title">
                        <h3>Patient</h3>
                        <large>Patient</large>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 wow fadeIn">
                    <a href="medecins.php"><img src="images/doctor.png" alt="" class="img-responsive img-rounded"></a>
                    <div class="widget-title">
                        <h3>Médecins</h3>
                        <medium>Médecins</medium>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 wow fadeIn">
                    <a href="consultations.php"><img src="images/calendar.png" alt="" class="img-responsive img-rounded"></a>
                    <div class="widget-title">
                        <h3>Consultations</h3>
                        <large>Consultations</large>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="copyright-area">
        <div class="container">
               	<div class="col-md-8">
                  	<div class="footer-text">
                    	<p>© 2020 Cabinet Médical. Thomas LY, Hugo SAINT-SAËNS.</p>
                  	</div>
               	</div>
        </div>
    </div>

    <!-- all js files -->
    <script src="js/all.js"></script>
    <!-- all plugins -->
    <script src="js/custom.js"></script>
    <!-- map -->
</html>