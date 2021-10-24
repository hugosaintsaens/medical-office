<?php 
    require '../securite/identification.php';
    require '../bdd/ouverture.php';

    $reqPatient = $GLOBALS['bdd']->prepare("SELECT * FROM patient WHERE ID_Patient = ?");
    $reqPatient->execute(array($_GET['id']));
    $reqPatientResult = $reqPatient->fetch();

    $reqMedecin = $GLOBALS['bdd']->prepare("SELECT Nom, Prenom FROM medecin ORDER BY Nom, Prenom ASC");
    $reqMedecin->execute();

    $reqMedecinNomPrenom = $GLOBALS['bdd']->prepare("SELECT medecin.Nom as n, medecin.Prenom as p FROM medecin, patient WHERE patient.ID_Medecin = medecin.ID_Medecin AND patient.ID_Patient = ?");
	$reqMedecinNomPrenom->execute(array($_GET['id']));
    $resultMedecinNomPrenom = $reqMedecinNomPrenom->fetch();
    
    require '../bdd/fermeture.php';

    if(isset($_POST['formModification'])) {
        require '../bdd/ouverture.php';
        
        if ($_POST['IDMedecin'] === 'Aucun') {
            $ID_Medecin = 'NULL';
        } else {
            $medecinNomPrenom = explode(" ", $_POST['IDMedecin']);
            $reqMedecinID = $GLOBALS['bdd']->prepare("SELECT ID_Medecin FROM medecin WHERE Nom = ? AND Prenom = ?");
            $reqMedecinID->execute(array($medecinNomPrenom[0],$medecinNomPrenom[1]));
            $ID_Medecin = $reqMedecinID->fetch();
        }

        $formPrenom = htmlspecialchars($_POST['prenom']);
        $formNom = htmlspecialchars($_POST['nom']);
        $formCivilite = htmlspecialchars($_POST['civilite']);
        $formAdresse = htmlspecialchars($_POST['adresse']);
        $formCP = htmlspecialchars($_POST['cp']);
        $formVille = htmlspecialchars($_POST['ville']);
        $formDateNaissance = htmlspecialchars($_POST['dateNaissance']);
        $formLieuNaissance = htmlspecialchars($_POST['lieuNaissance']);
        $formNumSecu = htmlspecialchars($_POST['numSecu']);

        if($ID_Medecin === 'NULL') {
            $reqModif = $GLOBALS['bdd']->prepare("UPDATE patient SET Prenom = Concat(UPPER(LEFT(?,1)),LOWER(SUBSTRING(?,2))), Nom = ucase(?), Civilite = ?, Adresse = ?, CodePostal = ?, Ville = Concat(UPPER(LEFT(?,1)),LOWER(SUBSTRING(?,2))), DateNaissance = ?, LieuNaissance = Concat(UPPER(LEFT(?,1)),LOWER(SUBSTRING(?,2))), NumSecu = ?, ID_Medecin = NULL WHERE ID_Patient = ?");
            $reqModif->execute(array($formPrenom, $formPrenom, $formNom, $formCivilite, $formAdresse, $formCP, $formVille, $formVille, $formDateNaissance, $formLieuNaissance, $formLieuNaissance, $formNumSecu, $_GET['id']));
        } else {
            $formIDMedecin = htmlspecialchars($ID_Medecin['ID_Medecin']);
            $reqModif = $GLOBALS['bdd']->prepare("UPDATE patient SET Prenom = Concat(UPPER(LEFT(?,1)),LOWER(SUBSTRING(?,2))), Nom = ucase(?), Civilite = ?, Adresse = ?, CodePostal = ?, Ville = Concat(UPPER(LEFT(?,1)),LOWER(SUBSTRING(?,2))), DateNaissance = ?, LieuNaissance = Concat(UPPER(LEFT(?,1)),LOWER(SUBSTRING(?,2))), NumSecu = ?, ID_Medecin = ? WHERE ID_Patient = ?");
            $reqModif->execute(array($formPrenom, $formPrenom, $formNom, $formCivilite, $formAdresse, $formCP, $formVille, $formVille, $formDateNaissance, $formLieuNaissance, $formLieuNaissance, $formNumSecu, $formIDMedecin, $_GET['id']));
        }

        $succes = "Modification effectuée avec succès !";
        echo '<font color = "green">'.$succes."</font>";

        require '../bdd/fermeture.php';

        sleep(2);

        echo '<script type="text/javascript">';
        echo 'window.location.href = "../usagers.php";';
        echo '</script>';
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Patient</title>
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
                            <li><a data-scoll href="../menu.php">Menu</a></li>
                            <li><a class="active" href="../usagers.php">Patients</a></li>
                            <li><a data-scroll href="../medecins.php">Médecins</a></li>
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

        <div class="services wow fadeIn">
            <div class="container">
                <div class="center">
                    <div class="appointment-form">
                        <h3><span>+</span> Modification des données d'un patient</h3>
                        <div class="form">
                            <form method = "post" action = "" >
                                <p>Prénom : </br>
                                <input type="text" maxlength="20" name="prenom" value="<?php echo $reqPatientResult['Prenom'] ?>" required autocomplete="off"/>
                                <p>Nom : </br>
                                <input type="text" maxlength="20"name="nom" value="<?php echo $reqPatientResult['Nom'] ?>" required autocomplete="off"/>
                                <p>Civilité : </br>
                                <div class="center">
                                    <label for="choix1">Madame</label>
                                    <input type="radio" id="choix1" name="civilite" <?php if ($reqPatientResult['Civilite'] === "Madame") { echo 'checked = "checked"'; } ?> value="Madame" required>
                                    <label for="choix2">Monsieur</label>
                                    <input type="radio" id="choix2" name="civilite" <?php if ($reqPatientResult['Civilite'] === "Monsieur") { echo 'checked = "checked"'; } ?> value="Monsieur" required>
                                </div>
                                <p>Adresse : </br>
                                <input type="text" maxlength="50" name="adresse" value="<?php echo $reqPatientResult['Adresse'] ?>" required autocomplete="off"/>
                                <p>Code postal : </br>
                                <input type="text" maxlength="5" name="cp" value="<?php echo $reqPatientResult['CodePostal'] ?>" required autocomplete="off"/>
                                <p>Ville : </br>
                                <input type="text" maxlength="50" name="ville" value="<?php echo $reqPatientResult['Ville'] ?>" required autocomplete="off"/>
                                <p>Date de naissance : </br>
                                <input type="date" name="dateNaissance" value="<?php echo $reqPatientResult['DateNaissance'] ?>" required/>
                                <p>Lieu de naissance : </br>
                                <input type="text" maxlength="30" name="lieuNaissance" value="<?php echo $reqPatientResult['LieuNaissance'] ?>" required autocomplete="off"/>
                                <p>Numéro de sécurité sociale : </br>
                                <input type="text" maxlength="13" name="numSecu" value="<?php echo $reqPatientResult['NumSecu'] ?>"required autocomplete="off" />
                                <p>Medecin référant : </br>
                                <select name="IDMedecin">
                                    <?php   if($reqMedecin->rowCount() != 0) {
                                                if(empty($reqPatientResult['ID_Medecin'])) { ?>
                                                    <option selected="selected">Aucun</option> <?php
                                                    while ($rowMedecin = $reqMedecin->fetch()) { ?>
                                                        <option><?php echo $rowMedecin['Nom'].' '.$rowMedecin['Prenom'] ?></option> <?php
                                                    }
                                                } else { ?>
                                                    <option>Aucun</option> <?php
                                                    while ($rowMedecin = $reqMedecin->fetch()) { 
                                                        if (($rowMedecin['Nom'].' '.$rowMedecin['Prenom']) === ($resultMedecinNomPrenom['n'].' '.$resultMedecinNomPrenom['p'])) { ?>
                                                            <option selected="selected"><?php echo $rowMedecin['Nom'].' '.$rowMedecin['Prenom'] ?></option>
                                                        <?php } else { ?>
                                                            <option><?php echo $rowMedecin['Nom'].' '.$rowMedecin['Prenom'] ?></option>
                                                        <?php }
                                                    }
                                                }
                                            } else { ?>
                                                <option>Aucun</option>
                                            <?php }
                                    ?>
                                </select> </br> </br>
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