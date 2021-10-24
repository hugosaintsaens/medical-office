<?php 
    require 'securite/identification.php';
	require 'bdd/ouverture.php';

	if(isset($_GET['formRechercher'])) {
		$reqTAB = $GLOBALS['bdd']->prepare("SELECT * 
											FROM patient 
											WHERE ID_Patient = ? 
											OR Prenom = ? 
											OR Nom = ? 
											OR Civilite = ? 
											OR Adresse = ? 
											OR CodePostal = ? 
											OR Ville = ? 
											OR DateNaissance = ? 
											OR LieuNaissance = ? 
											OR NumSecu = ?");
		$reqTAB->execute(array($_GET['barre'],$_GET['barre'],$_GET['barre'],$_GET['barre'],$_GET['barre'],$_GET['barre'],$_GET['barre'],$_GET['barre'],$_GET['barre'],$_GET['barre']));
		$recherche_active = true;
	} else {
		$reqTAB = $GLOBALS['bdd']->prepare("SELECT * FROM patient");
		$reqTAB->execute();
		$recherche_active = false;
	}

	require 'bdd/fermeture.php'
?>


<!DOCTYPE HTML>
<html>
	<head>
        <meta charset="utf-8">
        <title>Patients</title>
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
                            <li><a class="active" href="usagers.php">Patients</a></li>
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

    <body class="clinic_version">

	    <!-- LOADER -->
		<div id="preloader">
            <img class="preloader" src="images/loaders/heart-loading2.gif" alt="">
        </div>
        <!-- END LOADER -->

        </br></br></br></br></br>

		<div id="about" class="section wow fadeIn">
			<div class="container">
				<div class="heading">
    					<span class="icon-logo"><img src="images/patient.png" alt="#"></span>
    					<h2>Liste des patients</h2>
    				</div>
    				<div class="row">
    					<div class="col-md-6">
    						<div class="message-box">
    							<a href="usagers/usagers_ajouter.php" data-scroll class="btn btn-brd effect-1">Ajouter un patient</a></br>
    							</br>
    							<h4>Rechercher un patient :</h4>
    							<form action="" method="get">
    								<input type="text" name="barre" placeholder="Entrez un mot-clé" />
    								<input type="submit" name="formRechercher" value="Rechercher" />
    							</form> </br>
    
    							<form action="" method="get">
    								<input type="submit" name="btn_reinitialiser" value="Réinitialiser">
    							</form> </br> </br>
    						</div>
    					</div>
    				</div>
    				<div class="center">
    				<?php 
    				if($reqTAB->rowCount() != 0) { ?>
    					<table id="customers">
    					<thead>
    						<tr>
    							<td>Prénom</td>
    							<td>Nom</td>
    							<td>Civilité</td>
    							<td>Adresse</td>
    							<td>Code postal</td>
    							<td>Ville</td>
    							<td>Date de naissance</td>
    							<td>Lieu de naissance</td>
    							<td>Numéro de sécurité sociale</td>
    							<td>Medecin référant</td>
    							<td>Modifier</td>
    							<td>Supprimer</td>
    						</tr>
    					</thead>
    					<tbody>
    						<?php require 'bdd/ouverture.php';
    						while ($row = $reqTAB->fetch()) { 
    							if(empty($row['ID_Medecin'])) {
    								$possede_medecin = false;
    							} else {
    								$possede_medecin = true;
    								$reqMedecinNomPrenom = $GLOBALS['bdd']->prepare("SELECT medecin.Nom as n, medecin.Prenom as p FROM medecin, patient WHERE medecin.ID_Medecin = patient.ID_Medecin AND patient.ID_Medecin = ?");
    								$reqMedecinNomPrenom->execute(array($row['ID_Medecin']));
    								$resultMedecinNomPrenom = $reqMedecinNomPrenom->fetch();
    							}
    							?>
    							<tr>
    								<td><?php echo $row['Prenom'] ?></td>
    								<td><?php echo $row['Nom'] ?></td>
    								<td><?php echo $row['Civilite'] ?></td>
    								<td><?php echo $row['Adresse'] ?></td>
    								<td><?php echo $row['CodePostal'] ?></td>
    								<td><?php echo $row['Ville'] ?></td>
    								<td><?php echo date_format(date_create($row['DateNaissance']),'d/m/Y') ?></td>
    								<td><?php echo $row['LieuNaissance'] ?></td>
    								<td><?php echo $row['NumSecu'] ?></td>
    								<td><?php if($possede_medecin) { 
    									echo $resultMedecinNomPrenom['n'].' '.$resultMedecinNomPrenom['p']; 
    									} else {
    									echo 'Aucun'; 
    									} ?></td>
    								<td><a href="usagers/usagers_modifier.php?id=<?php echo $row['ID_Patient']; ?>"><span class="icon-logo"><img src="images/modif.png"></span></a></td>
    								<td><div class="center"><a href="usagers/usagers_supprimer.php?id=<?php echo $row['ID_Patient']; ?>"><span class="icon-logo"><img src="images/cross.png"></span></a></div></td>
    							</tr>
    						<?php
    						} require 'bdd/fermeture.php'; ?>
    					</thead>
    					</table>
    				<?php 
    				} elseif (($reqTAB->rowCount() === 0) && (!$recherche_active)) {
    						echo 'Votre cabinet ne possede aucun patient.';
    				} elseif (($reqTAB->rowCount() === 0) && ($recherche_active)) {
    						echo 'Aucun patient ne correspond à votre recherche : '.$_GET['barre'].'.';
    				} else {
    					echo "L'affichage des patients a échoué.";
    				} ?>
    			</div>
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
		$recherche_active = false;
	}
?>