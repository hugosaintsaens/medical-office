<?php 
    require '../securite/identification.php';
    require '../bdd/ouverture.php';

    $reqPatient = $GLOBALS['bdd']->prepare("SELECT Nom, Prenom FROM patient");
    $reqPatient->execute();

    $reqMedecin = $GLOBALS['bdd']->prepare("SELECT Nom, Prenom FROM medecin");
    $reqMedecin->execute();

    $reqMedecinNomPrenom = $GLOBALS['bdd']->prepare("SELECT Nom, Prenom FROM medecin WHERE ID_Medecin = ?");
    $reqMedecinNomPrenom->execute(array($_GET['Mid']));
    $resultMedecinNomPrenom = $reqMedecinNomPrenom->fetch();
    
    $reqPatientNomPrenom = $GLOBALS['bdd']->prepare("SELECT Nom, Prenom FROM patient WHERE ID_Patient = ?");
    $reqPatientNomPrenom->execute(array($_GET['Pid']));
    $resultPatientNomPrenom = $reqPatientNomPrenom->fetch();
    
    require '../bdd/fermeture.php';

    if(isset($_POST['formModification'])) {
        require '../bdd/ouverture.php';

        $medecinNomPrenom = explode(" ", $_POST['medecin']);
        $reqMedecinID = $GLOBALS['bdd']->prepare("SELECT ID_Medecin FROM medecin WHERE Nom = ? AND Prenom = ?");
        $reqMedecinID->execute(array($medecinNomPrenom[0],$medecinNomPrenom[1]));
        $ID_Medecin = $reqMedecinID->fetch();

        $patientNomPrenom = explode(" ", $_POST['patient']);
        $reqPatientID = $GLOBALS['bdd']->prepare("SELECT ID_Patient FROM patient WHERE Nom = ? AND Prenom = ?");
        $reqPatientID->execute(array($patientNomPrenom[0],$patientNomPrenom[1]));
        $ID_Patient = $reqPatientID->fetch();
        
        $formDateRDV = htmlspecialchars($_POST['daterdv']);
        $formHeureRDV = htmlspecialchars($_POST['heurerdv']);
        $formDureeRDV = htmlspecialchars($_POST['dureerdv']);
        $formIDP = htmlspecialchars($ID_Patient['ID_Patient']);
        $formIDM = htmlspecialchars($ID_Medecin['ID_Medecin']);

        $reqModif = $GLOBALS['bdd']->prepare("UPDATE prendrerdv SET DateRDV = ?, HeureRDV = ?, DureeRDV = ?, ID_Patient = ?, ID_Medecin = ? WHERE DateRDV = ? AND HeureRDV = ? AND DureeRDV = ? AND ID_Patient = ? AND ID_Medecin = ?");
        $reqModif->execute(array($formDateRDV, $formHeureRDV, $formDureeRDV, $formIDP, $formIDM, htmlspecialchars($_GET['date']), htmlspecialchars($_GET['heure']), htmlspecialchars($_GET['duree']), htmlspecialchars($_GET['Pid']), htmlspecialchars($_GET['Mid'])));
        
        require '../bdd/fermeture.php';

        echo '<script type="text/javascript">';
        echo 'window.location.href = "../consultations.php";';
        echo '</script>';
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Consultation</title>
        <!-- Site Icons -->
        <link rel="shortcut icon" href="../images/fevicon.ico.png" type="../image/x-icon" />
        <link rel="apple-touch-icon" href="../images/apple-touch-icon.png">
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
                            <li><a data-scroll href="../medecins.php">Médecins</a></li>
                            <li><a class="active" href="../consultations.php">Consultations</a></li>
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

        <h3>Saisie d'une nouvelle consultation</h3>
        <div class="services wow fadeIn">
            <div class="container">
                <div class="center">
                    <div class="appointment-form">
                        <h3><span>+</span>Modification d'une consultation</h3>
                        <div class="form">
                            <form method = "post" action = "" >
                                <p>Date : </br>
                                <input type="date" name="daterdv" min="<?php echo DATE("Y-m-d"); ?>" value="<?php echo $_GET['date'] ?>" required/>
                                <p>Heure : </br>
                                <input type="time" name="heurerdv" min="08:00" max="17:00" value="<?php echo $_GET['heure'] ?>" required/>
                                <p>Duree : </br>
                                <input type="time" name="dureerdv" value="<?php echo $_GET['duree'] ?>" required/>
                                <p>Patient pris en charge : </br>
                                <select name="patient" required>
                                    <?php   if($reqPatient->rowCount() != 0) {
                                                while ($resultPatient = $reqPatient->fetch()) {
                                                    if (($resultPatient['Nom'].' '.$resultPatient['Prenom']) === ($resultPatientNomPrenom['Nom'].' '.$resultPatientNomPrenom['Prenom'])) { ?>
                                                        <option selected="selected"><?php echo $resultPatient['Nom'].' '.$resultPatient['Prenom'] ?></option>
                                                <?php } else { ?>
                                                        <option><?php echo $resultPatient['Nom'].' '.$resultPatient['Prenom'] ?></option>
                                    <?php           }
                                                }
                                                } else { ?>
                                                <p> Aucun patient n'est disponible. </p>
                                            <?php }
                                    ?>
                                </select>
                                <p>Medecin en charge de la consultation : </br>
                                <select name="medecin" required>
                                    <?php   if($reqMedecin->rowCount() != 0) {
                                                while ($resultMedecin = $reqMedecin->fetch()) { 
                                                    if (($resultMedecin['Nom'].' '.$resultMedecin['Prenom']) === ($resultMedecinNomPrenom['Nom'].' '.$resultMedecinNomPrenom['Prenom'])) { ?>
                                                        <option selected="selected"><?php echo $resultMedecin['Nom'].' '.$resultMedecin['Prenom'] ?></option>
                                                <?php } else { ?>
                                                        <option><?php echo $resultMedecin['Nom'].' '.$resultMedecin['Prenom'] ?></option>
                                    <?php           }
                                                }
                                                } else { ?>
                                                <p> Aucun medecin n'est disponible. </p>
                                            <?php }
                                    ?>
                                </select> </br></br>
                                <input type ="submit" name="formModification" value="Modifier">
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