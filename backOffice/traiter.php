<?php 
	session_start();
    require("../fonctions.php");
    // Connexion à la BD
    $link = connexionMySQL();
	
	//Variable du technicien
	$matricule = "12345";
	$codeT = "11111";
	$nomT = "BARBÉ"; 
	$prenomT = "Sophie";

	// Récupération des données du dossier en cours de traitement
	if(isset($_GET["codeD"])) {
		$_SESSION["codeDossier"] = $_GET["codeD"];
		$_SESSION["refDossier"] = ChercherREFAvecCodeD($_GET["codeD"], $link)["RefD"];
		RedirigerVers("traiter.php");
	}

	//Changement de statut si un statut est indiqué dans l'URL
	if(isset($_GET["statut"])) {
		TraiterDossier($codeT, $_SESSION["codeDossier"], $_GET["statut"], $link);
		RedirigerVers("traiter.php");
	}

	//S'il n'y a pas de référence dossier en session
	if(!isset($_SESSION["refDossier"])){
		RedirigerVers("accueil.php");
	}

	//Variables du dossier et de l'assuré
	$dossier = ChercherDossierAvecREF($_SESSION["refDossier"], $link);
	$refDossier = $dossier["RefD"];
	$codeDossier = $dossier["CodeD"];
	$dateReception = $dossier["DateD"];
	$statutDossier = utf8_encode($dossier["StatutD"]);
	$nirAssure = $dossier["NirA"];
	$nomAssure = $dossier["NomA"];
	$prenomAssure = $dossier["PrenomA"];
	$dateArretMaladie = $dossier["DateAM"];
	
    // Passage automatique du statut à "En cours"
	if($statutDossier == "À traiter") {
		TraiterDossier($codeT, $codeDossier, "En cours", $link);
		$statutDossier = "En cours";
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="style.css">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
		<script src="script.js"></script>
		
		<script>
			$(document).ready(function(){
			  $("#research").on("keyup", function() {
				var value = $(this).val().toLowerCase();
				$("#data-list tr").filter(function() {
				  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
				});
			  });
			});
		</script>

        <title>PJPE - Réception des documents</title>
	</head>
	<body>
		<nav class="navbar navbar-default header">
			<div class="container">
				<div class="navbar-header">
					<h1>PJPE</h1>
				</div>
			</div>
		</nav>

		<nav class="navbar navbar-inverse navbar-static-top police">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar2">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>                        
					</button>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar2">
					<ul class="nav navbar-nav" id="menu">
						<li><a href="accueil.php"><span class="glyphicon glyphicon-home"></span> Accueil</a></li>
						<li><a href="corbeille_generale.php"><span class="glyphicon glyphicon-list-alt"></span> Corbeille générale</a></li>
						<li><a href="ma_corbeille.php"><span class="glyphicon glyphicon-folder-open"></span> Ma Corbeille</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right dropdown">
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<?php echo("$prenomT $nomT "); ?><span class="glyphicon glyphicon-user"></span><span class="glyphicon glyphicon-menu-down"></span>
							</a>
							<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
								<li role="presentation"><a role="menuitem" href="#">Profil</a></li>
								<li role="presentation" class="divider"></li>
								<li role="presentation"><a role="menuitem" href="#">Se déconnecter</a></li>
							</ul>
						</li>						
					</ul>
				</div>
			</div>
		</nav>
		
		<div class="container">
			<div class="row">
				<div id="panel-dossier" class="col-sm-6">
					<div class="container-fluid panel panel-default">
						<div class="panel-body">
							<h3>DOSSIER No <?php echo $refDossier;?></h3>
							<h4>Date de réception :  <?php echo $dateReception;?></h4>
						</div>
					</div>
				</div>
				<div id="panel-assure" class="col-sm-6">
					<div class="container-fluid panel panel-default">
						<div class="panel-body">
							<h3>NIR : <?php echo $nirAssure;?></h3>
							<h4><?php echo "$nomAssure $prenomAssure";?></h4>
							<h4>En arrêt de travail depuis le : <?php echo $dateArretMaladie;?></h4>
						</div>
					</div>
				</div>
			<div>
			<div class="row">
				<div id="panel-statut" class="col-sm-12">
					<div class= "panel panel-default">	
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-3 text-center">
									<span class="titre">Statut</span>
								</div>
								<div class="col-sm-9">
									<div class="btn-group btn-group-justified">
										<a href="traiter.php?statut=En cours"
											class="<?php ClassBoutonTraiter($statutDossier, "En cours");?>"
											role="button">En cours</a>
										<a href="traiter.php?statut=Classé sans suite"
											class="<?php ClassBoutonTraiter($statutDossier, "Classé sans suite");?>" 
											role="button">Classé sans suite</a>
										<a href="traiter.php?statut=Terminé"
											class="<?php ClassBoutonTraiter($statutDossier, "Terminé");?>"
											role="button">Terminé</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div id="panel-pjs" class="col-sm-4">
					<div class= "panel panel-primary">
						<div class="panel-heading titre text-center">Liste des pièces justificatives</div>
						<ul class="panel-body list-group">
						<?php
                            $result = RecupererPJ($link, $codeDossier);
                            $rows = mysqli_num_rows($result);
                            for ($i = 0; $i < $rows; $i++){
                                $justificatif = mysqli_fetch_array($result);
								$cheminFichier = $justificatif["CheminJ"];
                                $nomFichier = strrchr($cheminFichier, '/');
                                $nomFichier = substr($nomFichier, 1);
                                $extension = strrchr($cheminFichier, '.');
                                $extension = substr($extension, 1);
                                //$mnemonique = $justificatif["Mnemonique"];
                                echo("<li class='list-group-item' onClick='changePathViewer(\"$cheminFichier\")'><h5><img class='icon icon-$extension'>$nomFichier</h5></li>");
                            }
                        ?>
                        </ul>
					</div>
				</div>
				<div id="panel-apercu" class="col-sm-8">
					<div class= "panel panel-default">
						<div class="panel-heading titre text-center">Aperçu</div>
						<div class="panel-body">
							<embed id="apercu" class="panel-body">
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>	
</html>