<?php 
	session_start();
    require("../fonctions.php");
    // Connexion à la BD
    $link = connexionMySQL();
    if ($link == NULL){
        //Redirection
	}
	
	 // Récupération des données du dossier en cours de traitement
    $codeDossier = $_POST["codeD"];	
    $refDossier = $_POST["refD"];

	if(!ChangerStatutDossier($link, $codeDossier, "En cours")){
        echo "<div class='alert alert-danger'><strong>Alerte !</strong> Erreur dans le changement du statut du dossier !</div>";
    };

    $dossier = ChercherDossierAvecREF($refDossier, $link);
    $dateReception = $dossier["DateD"];
    $statutDossier = $dossier["StatutD"];
    $nirAssure = $dossier["NirA"];
    $nomAssure = $dossier["NomA"];
    $prenomAssure = $dossier["PrenomA"];
    $dateArretMaladie = $dossier["DateAM"];

    // test    
	$matricule = "12345";
	$codeT = "11111";
	$nomT = "Doe"; 
	$prenomT = "John";
	$codeDossier = "11111";
	$refDossier= "ABCD1111";
    $dateReception = "13/04/20";
    $statutDossier = "En cours";
    $nirAssure = "# ## ## ## ### ###";
    $nomAssure = "DUPONT";
    $prenomAssure = "Jean-Michel";
    $dateArretMaladie = "01/04/20";

    //Mise en session	    
	$_SESSION["codeDossier"] = $codeDossier;	
	$_SESSION["refDossier"] = $refDossier;

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
							<h3>DOSSIER No&#12296;<?php echo $refDossier;?>&#12297;</h3>
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
								<div class="col-sm-2">
									<span class="titre">Statut</span>
								</div>
								<div class="col-sm-2">
									<a href="#" class="btn btn-primary disabled" role="button">À traiter</a>
								</div>
								<div class="col-sm-2">
									<a href="#" class="btn btn-default" role="button">En Cours</a>
								</div>
								<div class="col-sm-2">
									<a href="#" class="btn btn-primary" role="button">Classé sans suite</a>
								</div>
								<div class="col-sm-2">
									<a href="#" class="btn btn-primary" role="button">Terminé</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div id="panel-pjs" class="col-sm-12 panel panel-default">
				</div>
				<div id="panel-apercu" class="col-sm-12 panel panel-default">
				</div>
			</div>
		</div>
	</body>	
</html>