<?php 
    require 'securite/identification.php';
	require 'bdd/ouverture.php';
	
    $reqStatsHommesMoins25 = $GLOBALS['bdd']->prepare("SELECT COUNT(*) as req 
														FROM patient 
														WHERE Civilite = ? 
														AND DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),DateNaissance)), '%Y') < 25");
    $reqStatsHommesMoins25->execute(array('Monsieur'));
	$resultStatsHommesMoins25 = $reqStatsHommesMoins25->fetch();
	
	$reqStatsFemmesMoins25 = $GLOBALS['bdd']->prepare("SELECT COUNT(*) as req 
														FROM patient 
														WHERE Civilite = ? 
														AND DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),DateNaissance)), '%Y') < 25");
    $reqStatsFemmesMoins25->execute(array('Madame'));
	$resultStatsFemmesMoins25 = $reqStatsFemmesMoins25->fetch();
	
	$reqStatsHommesEntre25Et50 = $GLOBALS['bdd']->prepare("SELECT COUNT(*) as req 
															FROM patient 
															WHERE Civilite = ? 
															AND DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),DateNaissance)), '%Y') > 25 
															AND DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),DateNaissance)), '%Y') < 50");
    $reqStatsHommesEntre25Et50->execute(array('Monsieur'));
	$resultStatsHommesEntre25Et50 = $reqStatsHommesEntre25Et50->fetch();
	
	$reqStatsFemmesEntre25Et50 = $GLOBALS['bdd']->prepare("SELECT COUNT(*) as req 
															FROM patient 
															WHERE Civilite = ? 
															AND DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),DateNaissance)), '%Y') > 25 
															AND DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),DateNaissance)), '%Y') < 50");
    $reqStatsFemmesEntre25Et50->execute(array('Madame'));
	$resultStatsFemmesEntre25Et50 = $reqStatsFemmesEntre25Et50->fetch();
	
	$reqStatsHommesPlus50 = $GLOBALS['bdd']->prepare("SELECT COUNT(*) as req 
														FROM patient 
														WHERE Civilite = ? 
														AND DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),DateNaissance)), '%Y') > 50");
    $reqStatsHommesPlus50->execute(array('Monsieur'));
	$resultStatsHommesPlus50 = $reqStatsHommesPlus50->fetch();
	
	$reqStatsFemmesPlus50 = $GLOBALS['bdd']->prepare("SELECT COUNT(*) as req 
														FROM patient 
														WHERE Civilite = ? 
														AND DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),DateNaissance)), '%Y') > 50");
    $reqStatsFemmesPlus50->execute(array('Madame'));
	$resultStatsFemmesPlus50 = $reqStatsFemmesPlus50->fetch();

	$reqDureeTotaleMedecin = $GLOBALS['bdd']->prepare("SELECT Nom, Prenom, ROUND(((SUM(DureeRDV)/100)/60),2) as heure
														FROM medecin, prendrerdv
														WHERE medecin.ID_Medecin = prendrerdv.ID_Medecin
														GROUP BY Nom, Prenom
														ORDER BY Nom, Prenom ASC");
    $reqDureeTotaleMedecin->execute();
	
	require 'bdd/fermeture.php';
?>

<!DOCTYPE HTML>
<html>
	<head>
        <meta charset="utf-8">
        <title>Statistiques</title>
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
                            <li><a data-scroll href="consultations.php">Consultations</a></li>
                            <li><a class="active" href="statistiques.php">Statistiques</a></li>
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

		</br></br></br></br></br></br></br></br>

		<div class="heading">
		   <span class="icon-logo"><img src="images/stats.png" alt="#"></span>
      		<h2>Statistiques</h2>
        </div>

    		<div class="container">
    			<h3>Répartition des usagers selon leur sexe et leur âge</h3>
    			<table id="customers">
    				<thead>
    					<tr>
    						<td><b>Tranche d'âge</b></td>
    						<td><b>Nombre d'Hommes</b></td>
    						<td><b>Nombre de Femmes</b></td>
    					</tr>
    				</thead>
        				<tbody>
        					<tr>
        						<td>Moins de 25 ans</td>
        						<td> <?php echo $resultStatsHommesMoins25['req'] ?> </td>
        						<td> <?php echo $resultStatsFemmesMoins25['req'] ?> </td>
        					</tr>
        					<tr>
        						<td>Entre 25 et 50 ans</td>
        						<td> <?php echo $resultStatsHommesEntre25Et50['req'] ?> </td>
        						<td> <?php echo $resultStatsFemmesEntre25Et50['req'] ?> </td>
        					</tr>
        					<tr>
        						<td>Plus de 50 ans</td>
        						<td> <?php echo $resultStatsHommesPlus50['req'] ?> </td>
        						<td> <?php echo $resultStatsFemmesPlus50['req'] ?> </td>
        					</tr>
        				</thead>
    			</table> </br></br>
    			<?php 
    			if($reqDureeTotaleMedecin->rowCount() != 0) { ?>
    				<h3>Durée totale des consultations effectuées par chaque médecin</h3>
    				<table id="customers">
    				<thead>
    					<tr>
    						<td><b>Medecin</b></td>
    						<td><b>Duree totale de ses consultations</b></td>
    					</tr>
    				</thead>
    				<tbody>
    					<?php 
    					while ($resultDureeTotaleMedecin = $reqDureeTotaleMedecin->fetch()) { ?>
    						<tr>
    							<td><?php echo $resultDureeTotaleMedecin['Nom'].' '.$resultDureeTotaleMedecin['Prenom'] ?></td>
    							<td><?php if($resultDureeTotaleMedecin['heure'] < 1) { 
    											echo $resultDureeTotaleMedecin['heure'].' heure';
    										} else  {
    											echo $resultDureeTotaleMedecin['heure'].' heures';
    										}
    											?></td>
    						</tr>
    					<?php
    					} ?>
    				</thead>
    				</table>
    			<?php 
    			} else {
    				echo "Aucune consultation n'a été faite jusqu'à ce jour.";
    			} ?>
    		</div>

		</br></br></br></br>

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