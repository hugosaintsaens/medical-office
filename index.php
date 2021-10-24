<?php
    session_start();
    
    if(isset($_POST['formidentifiant']) && isset($_POST['formmotdepasse'])) {
        $formidentifiant = htmlspecialchars($_POST['formidentifiant']);
        $formmotdepasse = htmlspecialchars($_POST['formmotdepasse']);
        if(!empty($formidentifiant) and !empty($formmotdepasse)) {
            require 'bdd/ouverture.php';
            $requeteform = $GLOBALS['bdd']->prepare("SELECT * 
                                                        FROM administrateur 
                                                        WHERE Identifiant = ? 
                                                        AND MotDePasse = ?");
            $requeteform->execute(array($formidentifiant, $formmotdepasse));
            $userexist = $requeteform->rowCount();
            if ($userexist == 1) {
                $userinfo = $requeteform->fetch();
                $_SESSION['id'] = $userinfo['Identifiant'];
                $_SESSION['mdp'] = $userinfo['MotDePasse'];
                unset($userinfo);
                unset($erreur);
                require 'bdd/fermeture.php';
                header("Location: menu.php");
                exit();
            } else {
                $erreur = "Mauvais identifiant ou mot de passe.";
                require 'bdd/fermeture.php';
            }
        }
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
	   	<meta charset="utf-8">
	   	<title>Cabinet Médical</title>
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
          		<a href="index.php"><img src="images/logo2.png" alt="#"></a>
         	</div>
        </div>
        <div class="header-bottom wow fadeIn">
        	<div class="container">
          		<div class="navbar-header">
            		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"><i class="fa fa-bars" aria-hidden="true"></i></button>
          		</div>
        	</div>
        </div>
    </header>

    <body class="clinic_version">

        <!-- LOADER -->
      	<div id="preloader">
        	<img class="preloader" src="images/loaders/heart-loading2.gif" alt="">
      	</div>
      	<!-- END LOADER -->

        
      	<div id="login" class="services wow fadeIn">
         	<div class="container">
            	<div class="container">
            		<div class="row">
               			<div class="col-md-12 col-sm-12">
                  			<div class="text-contant">
                     			<h2>
                        			<span class="center"><span class="icon"><img src="images/icon-logo.png" alt="#" /></span></span>
                        			<span class="typewrite" data-period="2000" data-type='[ "Cabinet Médical", "Bienvenue !", "Identifiez-vous!" ]'>
                        			<span class="wrap"></span>
                     			</h2>
                  			</div>
               			</div>
            		</div>
         	</div>
            <div class="row">
               	<div class="center">
                  	<div class="appointment-form">
                     	<h3><span>+</span> Veuillez vous identifier</h3>
                     	<div class="form">
                            <form method = "post" action = "" >
                                Identifiant : <input type = "text" maxlength="5" name = "formidentifiant" placeholder = "Indiquez votre identifiant" required autocomplete="off" autofocus><br/>
                                Mot de passe : <input type = "password" maxlength="10" name = "formmotdepasse" placeholder = "Indiquez votre mot de passe" required autocomplete="off"><br/>
                                <input type = "submit" value = "Se connecter"> 
                            </form>
                     	</div>
                     	<?php 
        				if(isset($erreur)) {
            				echo '<font color = "red">'.$erreur."</font>";
        				}
      					?>
                  	</div>
               	</div>
            </div>
        </div>

        <!-- all js files -->
        <script src="js/all.js"></script>
        <!-- all plugins -->
        <script src="js/custom.js"></script>
        <!-- map -->
    </body>
</html>