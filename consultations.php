<?php 
    require 'securite/identification.php';
    require 'bdd/ouverture.php';

    if (isset($_GET['btn_filtrage'])) {
		$medecinNomPrenom = explode(" ", $_GET['btn_filtrage']);
		$reqMedecinID = $GLOBALS['bdd']->prepare("SELECT ID_Medecin FROM medecin WHERE Nom = ? AND Prenom = ?");
		$reqMedecinID->execute(array($medecinNomPrenom[0],$medecinNomPrenom[1]));
		$ID_Medecin = $reqMedecinID->fetch();
		$reqTAB = $GLOBALS['bdd']->prepare("SELECT DateRDV, HeureRDV, DureeRDV, medecin.Nom as mNom, medecin.Prenom as mPrenom, patient.Nom as pNom, patient.Prenom as pPrenom, medecin.ID_Medecin as mID, patient.ID_Patient as pID
                                            FROM prendrerdv, medecin, patient
                                            WHERE prendrerdv.ID_Medecin = medecin.ID_Medecin
                                            AND prendrerdv.ID_Patient = patient.ID_Patient
											AND medecin.ID_Medecin = ?
                                            ORDER BY DateRDV DESC, HeureRDV DESC");
		$reqTAB->execute(array($ID_Medecin['ID_Medecin']));
		$filtrage_active = true;
	} else {
		$reqTAB = $GLOBALS['bdd']->prepare("SELECT DateRDV, HeureRDV, DureeRDV, medecin.Nom as mNom, medecin.Prenom as mPrenom, patient.Nom as pNom, patient.Prenom as pPrenom, medecin.ID_Medecin as mID, patient.ID_Patient as pID
                                            FROM prendrerdv, medecin, patient
                                            WHERE prendrerdv.ID_Medecin = medecin.ID_Medecin
                                            AND prendrerdv.ID_Patient = patient.ID_Patient
                                            ORDER BY DateRDV DESC, HeureRDV DESC");
		$reqTAB->execute();
		$filtrage_active = false;
	}
    
    require 'bdd/fermeture.php';
?>

<!DOCTYPE HTML>
<html>
	<head>
        <meta charset="utf-8">
        <title>Consultations</title>
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
							<li><a data-scroll href="menu.php">Menu</a></li>
                            <li><a data-scroll href="usagers.php">Patients</a></li>
                            <li><a data-scroll href="medecins.php">Médecins</a></li>
                            <li><a class="active" href="consultations.php">Consultations</a></li>
                            <li><a data-scroll href="statistiques.php">Statistiques</a></li>
							<li><a data-scroll href="securite/deconnexion.php">Déconnexion</a></li>
						</ul>
                    </div>
                </nav>
            </div>
        </div>
    </header>

	</br></br></br></br></br>

    <body class="clinic_version">

		<!-- LOADER -->
		<div id="preloader">
            <img class="preloader" src="images/loaders/heart-loading2.gif" alt="">
        </div>
        <!-- END LOADER -->

		<div class="section wow fadeIn">
			<div class="container">
				<div class="heading">
					<span class="icon-logo"><img src="images/calendar.png" alt="#"></span>
					<h2>Consultation</h2>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="message-box">
							<a href="consultations/consultations_ajouter.php" data-scroll class="btn btn-brd effect-1">Ajouter</a></br>
							</br>
							<form action="" method="get">
								<input type="submit" name="btn_reinitialiser" value="Réinitialiser">
							</form> </br>
						</div>
					</div>
				</div>
				<?php 
				if($reqTAB->rowCount() != 0) { ?>
					<table id="customers">
					<thead>
						<tr>
							<td>Date</td>
							<td>Heure</td>
							<td>Durée</td>
							<td>Medecin</td>
							<td>Patient</td>
							<td>Modifier</td>
							<td>Supprimer</td>
						</tr>
					</thead>
					<tbody>
						<?php 
						while ($row = $reqTAB->fetch()) { ?>
							<tr>
								<td><?php echo date_format(date_create($row['DateRDV']),'d/m/Y') ?></td>
								<td><?php echo $row['HeureRDV'] ?></td>
								<td><?php echo $row['DureeRDV'] ?></td>
								<td> <form action="" method="get">
										<input type="submit" name="btn_filtrage" value="<?php echo $row['mNom'].' '.$row['mPrenom']; ?>">
									</form>
								</td>
								<td><?php echo $row['pNom'].' '.$row['pPrenom'] ?></td>
								<td><a href="consultations/consultations_modifier.php?date=<?php echo $row['DateRDV']?>&heure=<?php echo $row['HeureRDV']?>&duree=<?php echo $row['DureeRDV']?>&Mid=<?php echo $row['mID']?>&Pid=<?php echo $row['pID']?>"><span class="icon-logo"><img src="images/modif.png"></span></a></td>
								<td><div class="center"><a href="consultations/consultations_supprimer.php?date=<?php echo $row['DateRDV']?>&heure=<?php echo $row['HeureRDV']?>&duree=<?php echo $row['DureeRDV']?>&Mid=<?php echo $row['mID']?>&Pid=<?php echo $row['pID']?>"><span class="icon-logo"><img src="images/cross.png"></span></a></div></td>
							</tr>
						<?php
						} ?>
					</thead>
					</table>
				<?php
                } else {
                    echo "Votre cabinet ne contient aucune consultation.";
                } ?>
			</div>
		</div>


    	</br></br></br></br></br>
    
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
		<script src="js/all.js"></script>
		<!-- all plugins -->
		<script src="js/custom.js"></script>
		<!-- map -->
		
    </body>
</html>

<?php
    if(isset($_GET['btn_reinitialiser'])) {
		unset($_GET['btn_filtrage']);
		$filtrage_active = false;
	}
?>