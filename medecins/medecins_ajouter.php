<?php
    require '../securite/identification.php';

    if(isset($_POST['formEnvoyer'])) {
        require '../bdd/ouverture.php';

        $reqAjout = $GLOBALS['bdd']->prepare("INSERT INTO medecin(Prenom, Nom, Civilite) VALUES(Concat(UPPER(LEFT(?,1)),LOWER(SUBSTRING(?,2))), ucase(?), ?)");
        
        $formPrenom = htmlspecialchars($_POST['prenom']);
        $formNom = htmlspecialchars($_POST['nom']);
        $formCivilite = htmlspecialchars($_POST['civilite']);

        $reqAjout->execute(array($formPrenom, $formPrenom, $formNom, $formCivilite));

        $succes = "Ajout effectué avec succès !";
        echo '<font color = "green">'.$succes."</font>";

        require '../bdd/fermeture.php';

        sleep(2);

        echo '<script type="text/javascript">';
        echo 'window.location.href = "../medecins.php";';
        echo '</script>';
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Médecins</title>
        <!-- Site Icons -->
        <link rel="shortcut icon" href="images/fevicon.ico.png" type="image/x-icon" />
        <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
        <!-- Bootstrap CSS -->
	   	<link rel="stylesheet" href="../css/bootstrap.min.css">
	   	<!-- Site CSS -->
	   	<link rel="stylesheet" href="../style.css">
	   	<!-- Colors CSS -->
	   	<link rel="stylesheet" href="../css/colors.css">
	   	<!-- ALL VERSION CSS -->
	   	<link rel="stylesheet" href="../css/versions.css">
	   	<!-- Responsive CSS -->
	   	<link rel="stylesheet" href="../css/responsive.css">
	   	<!-- Custom CSS -->
	   	<link rel="stylesheet" href="../css/custom.css">
	</head>

	<header>
        <div class="header-top wow fadeIn">
            <div class="container">
                <a href="../menu.php"><img src="../images/logo2.png" alt="#"></a>
           </div>
		</div>
	
        <div class="header-bottom wow fadeIn">
           <div class="container">
                <nav class="main-menu">
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                        <li><a data-scroll href="../menu.php">Menu</a></li>
                            <li><a data-scroll href="../usagers.php">Patients</a></li>
                            <li><a class="active" href="../medecins.php">Médecins</a></li>
                            <li><a data-scroll href="../consultations.php">Consultations</a></li>
                            <li><a data-scroll href="../statistiques.php">Statistiques</a></li>
                            <li><a data-scroll href="../securite/deconnexion.php">Déconnexion</a></li>
						</ul>
                    </div>
                </nav>
            </div>
        </div>
	</header>

    </br></br></br></br>

    <body class="clinic_version">
            <!-- LOADER -->
            <div id="preloader">
            <img class="preloader" src="../images/loaders/heart-loading2.gif" alt="">
        </div>
        <!-- END LOADER -->

        <h3>Saisie d'un nouveau medecin</h3>
        <div class="services wow fadeIn">
            <div class="container">
                <div class="center">
                    <div class="appointment-form">
                        <h3><span>+</span> Ajouter un médecin</h3>
                        <div class="form">
                            <form method = "post" action = "" >
                                <p>Prénom : </br>
                                <input type="text" maxlength="20" name="prenom" required autocomplete="off" autofocus/>
                                <p>Nom : </br>
                                <input type="text" maxlength="20"name="nom" required autocomplete="off"/>
                                <p>Civilité : </br>
                                <div class="center">
                                    <label for="choix1">Madame</label>
                                    <input type="radio" id="choix1" name="civilite" value="Madame" required>
                                    <label for="choix2">Monsieur</label> </br></br>
                                    <input type="radio" id="choix2" name="civilite" value="Monsieur" required>
                                </div>
                                <input type ="submit" name="formEnvoyer" value="Valider">
                                <input type ="reset" value="Effacer">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="copyright-area wow fadeIn">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="footer-text">
                            <p>© 2020 Cabinet Médical. Thomas LY, Hugo SAINT-SAËNS.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- all js files -->
        <script src="../js/all.js"></script>
        <!-- all plugins -->
        <script src="../js/custom.js"></script>
        <!-- map -->
    </body>
</html>