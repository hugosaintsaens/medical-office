<?php
    require '../securite/identification.php';
    require '../bdd/ouverture.php';

    $reqPatient = $GLOBALS['bdd']->prepare("SELECT Nom, Prenom FROM patient");
    $reqPatient->execute();

    $reqMedecin = $GLOBALS['bdd']->prepare("SELECT Nom, Prenom FROM medecin");
    $reqMedecin->execute();

    require '../bdd/fermeture.php';

    if(isset($_POST['formEnvoyer'])) {
        require '../bdd/ouverture.php';

        $patientNomPrenom = explode(" ", $_POST['patient']);
        $reqPatientID = $GLOBALS['bdd']->prepare("SELECT ID_Patient FROM patient WHERE Nom = ? AND Prenom = ?");
        $reqPatientID->execute(array($patientNomPrenom[0],$patientNomPrenom[1]));
        $IDPatient = $reqPatientID->fetch();

        $medecinNomPrenom = explode(" ", $_POST['medecin']);
        $reqMedecinID = $GLOBALS['bdd']->prepare("SELECT ID_Medecin FROM medecin WHERE Nom = ? AND Prenom = ?");
        $reqMedecinID->execute(array($medecinNomPrenom[0],$medecinNomPrenom[1]));
        $IDMedecin = $reqMedecinID->fetch();
        
        $formDateRDV = htmlspecialchars($_POST['daterdv']);
        $formHeureRDV = htmlspecialchars($_POST['heurerdv']);
        $formDureeRDV = htmlspecialchars($_POST['dureerdv']);
        $formIDP = htmlspecialchars($IDPatient['ID_Patient']);
        $formIDM = htmlspecialchars($IDMedecin['ID_Medecin']);

        $reqNonChevauchementMedecinTest1 = $GLOBALS['bdd']->prepare("SELECT count(*) as cMedecin
                                                        	FROM prendrerdv 
                                                        	WHERE ID_Medecin = ? 
                                                        	AND DateRDV = ?
                                                            AND (? BETWEEN HeureRDV AND ADDTIME(HeureRDV,DureeRDV))");
        $reqNonChevauchementMedecinTest1->execute(array($formIDM, $formDateRDV, $formHeureRDV));
        $resultNonChevauchementMedecinTest1 = $reqNonChevauchementMedecinTest1->fetch();

        if($resultNonChevauchementMedecinTest1['cMedecin'] == 0) {
            $reqNonChevauchementMedecinTest2 = $GLOBALS['bdd']->prepare("SELECT count(*) as cMedecin
                                                        	                FROM prendrerdv 
                                                        	                WHERE ID_Medecin = ? 
                                                        	                AND DateRDV = ?
                                                        	                AND ADDTIME(?,?) BETWEEN HeureRDV AND ADDTIME(HeureRDV,DureeRDV)");
            $reqNonChevauchementMedecinTest2->execute(array($formIDM, $formDateRDV, $formHeureRDV, $formDureeRDV));
            $resultNonChevauchementMedecinTest2 = $reqNonChevauchementMedecinTest2->fetch();
        }

        if (($resultNonChevauchementMedecinTest1['cMedecin'] == 0) && ($resultNonChevauchementMedecinTest2['cMedecin'] == 0)) {

            $reqAjout = $GLOBALS['bdd']->prepare("INSERT INTO prendrerdv(DateRDV, HeureRDV, DureeRDV, ID_Patient, ID_Medecin) VALUES(?,?,?,?,?)");
            $reqAjout->execute(array($formDateRDV, $formHeureRDV, $formDureeRDV, $formIDP, $formIDM));

            require '../bdd/fermeture.php';

            sleep(2);
            
            echo '<script type="text/javascript">';
            echo 'window.location.href = "../consultations.php";';
            echo '</script>';

        } else if (($resultNonChevauchementMedecinTest1['cMedecin'] != 0) || ($resultNonChevauchementMedecinTest2['cMedecin'] != 0)) {

            $echec = "Le medecin a deja un creneau prevu !";
            echo '<font color = "red">'.$echec."</font>";

            require '../bdd/fermeture.php';

        } else {

            $echec = "L'ajout de la consultation a echoue !";
            echo '<font color = "red">'.$echec."</font>";

            require '../bdd/fermeture.php';

        }
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

        <h3>Saisie d'un nouveau medecin</h3>
        <div class="services wow fadeIn">
            <div class="container">
                <div class="center">
                    <div class="appointment-form">
                        <h3><span>+</span>Saisie d'une nouvelle consultation</h3>
                        <div class="form">
                            <form method = "post" action = "" >
                                <p>Date : </br>
                                <input type="date" name="daterdv" min="<?php echo DATE("Y-m-d"); ?>" value="<?php if(isset($_POST['daterdv'])) { echo $_POST['daterdv']; } else { echo DATE("Y-m-d"); }?>" required/>
                                <p>Heure : </br>
                                <input type="time" min="08:00" max="17:00" name="heurerdv" value="<?php if(isset($_POST['heurerdv'])) echo $_POST['heurerdv'] ?>" required/>
                                <p>Duree (heure/minute) : </br>
                                <input type="time" name="dureerdv" value="<?php if(isset($_POST['dureerdv'])) { echo $_POST['dureerdv']; } else { echo "00:30"; }?>" required/>
                                <p>Patient pris en charge : </br>
                                <select name="patient" required>
                                    <?php   if($reqPatient->rowCount() != 0) {
                                                if(isset($_POST['patient'])) {
                                                    while($resultPatient = $reqPatient->fetch()) {
                                                        if($resultPatient['Nom'].' '.$resultPatient['Prenom'] === $_POST['patient']) { ?>
                                                            <option selected="selected"><?php echo $resultPatient['Nom'].' '.$resultPatient['Prenom'] ?></option> <?php
                                                        } else { ?>
                                                            <option onclick="this.form.submit();"><?php echo $resultPatient['Nom'].' '.$resultPatient['Prenom'] ?></option> <?php
                                                        }
                                                    }
                                                } else { ?>
                                                    <option value="" selected disabled hidden>Selectionner le patient</option> <?php
                                                    while ($resultPatient = $reqPatient->fetch()) { ?>
                                                        <option onclick="this.form.submit();"><?php echo $resultPatient['Nom'].' '.$resultPatient['Prenom'] ?></option> <?php
                                                    }
                                                }
                                            } else { ?>
                                                <p> Aucun patient n'est disponible. </p> <?php
                                            }
                                    ?>
                                </select>
                                <p>Medecin en charge de la consultation : </br>
                                <select name="medecin" required>
                                    <?php   if($reqMedecin->rowCount() != 0) { 
                                                if(isset($_POST['patient'])) {
                                                    $patientNomPrenom = explode(" ", $_POST['patient']);
                                                    require '../bdd/ouverture.php';
                                                    $reqMedecinReferantExiste = $GLOBALS['bdd']->prepare("SELECT ID_Medecin FROM patient WHERE Nom = ? AND Prenom = ?");
                                                    $reqMedecinReferantExiste->execute(array($patientNomPrenom[0],$patientNomPrenom[1]));
                                                    require '../bdd/fermeture.php';
                                                    $resultMedecinReferantExiste = $reqMedecinReferantExiste->fetch();
                                                    if(!(empty($resultMedecinReferantExiste['ID_Medecin']))) {
                                                        require '../bdd/ouverture.php';
                                                        $reqMedecinReferant = $GLOBALS['bdd']->prepare("SELECT Nom, Prenom FROM medecin WHERE ID_Medecin = ?");
                                                        $reqMedecinReferant->execute(array($resultMedecinReferantExiste['ID_Medecin']));
                                                        require '../bdd/fermeture.php';
                                                        $resultMedecinReferant = $reqMedecinReferant->fetch();
                                                        while($resultMedecin = $reqMedecin->fetch()) { 
                                                            if($resultMedecin['Nom'].' '.$resultMedecin['Prenom'] === $resultMedecinReferant['Nom'].' '.$resultMedecinReferant['Prenom']) { ?>
                                                                <option selected="selected"><?php echo $resultMedecin['Nom'].' '.$resultMedecin['Prenom'] ?></option> <?php
                                                            } else { ?>
                                                                <option><?php echo $resultMedecin['Nom'].' '.$resultMedecin['Prenom'] ?></option> <?php
                                                            }
                                                        }
                                                    } else { ?>
                                                        <option value="" selected disabled hidden>Selectionner le medecin</option> <?php
                                                        while ($resultMedecin = $reqMedecin->fetch()) { ?>
                                                            <option><?php echo $resultMedecin['Nom'].' '.$resultMedecin['Prenom'] ?></option> <?php
                                                        }
                                                    }
                                                } else { ?>
                                                    <option value="" selected disabled hidden>Selectionner le medecin</option> <?php
                                                    while ($resultMedecin = $reqMedecin->fetch()) { ?>
                                                        <option><?php echo $resultMedecin['Nom'].' '.$resultMedecin['Prenom'] ?></option> <?php
                                                    }
                                                }
                                            } ?>
                                </select> </br></br>
                                <input type ="submit" name="formEnvoyer" value="Valider" <?php if(($reqPatient->rowCount() == 0) || ($reqMedecin->rowCount() == 0)) { ?> disabled <?php } ?> >
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
