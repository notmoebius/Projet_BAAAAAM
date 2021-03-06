<?php
    session_start();
    require("../fonctions.php");

    // Connexion à la BD
    $link = connecterBD();

    $query_categorie = "SELECT * FROM categorie WHERE CodeC=".$_GET['id'];

    $result = mysqli_query($link, $query_categorie);

    if ($result != NULL) {
        $rows = mysqli_num_rows($result);
        for ($i = 0; $i < $rows; $i++) {
            $categorie = mysqli_fetch_array($result);
        }
    }
    
    $_SESSION['id'] = $categorie['CodeC'];

    if(isset($_GET['statutA']) and $_GET['statutA'] == "Actif"){
        $query = "UPDATE categorie SET StatutC = 'Inactif' WHERE CodeC=".$_GET['id'];
        mysqli_query($link, $query);  
        header('Location: accueil_categorie.php');
    }
        
    if(isset($_GET['statutI']) and $_GET['statutI'] == "Inactif"){
        $query = "UPDATE categorie SET StatutC = 'Actif' WHERE CodeC=".$_GET['id'];
        mysqli_query($link, $query);
        header('Location:accueil_categorie.php');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <!-- ENCODAGE DE LA PAGE EN UTF-8 ET GESTION DE L'AFFICHAGE SUR MOBILE -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- FEUILLE DE STYLE CSS (BOOTSTRAP 3.4.1 / CSS LOCAL) -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css">

        <!-- SCRIPT JAVASCRIPT (JQUERY / BOOTSTRAP 3.4.1 / SCRIPT LOCAL) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        
        <script>
            $(function(){
                $( "form input:checkbox" ).click(function(event){
                    var checked = event.target.checked;
                    var index = event.target.value;
                    if(checked) {
                        $(`#${index}`).show()
                    } else { 
                        $(`#${index}`).hide()
                    }
                })                
            })
        </script>

        <title>PJPE - Administrateur</title>
    </head>
    <body>
        <nav class="navbar navbar-default header">
            <div class="container">
                <div class="navbar-header">
                    <h1>PJPE - Administrateur</h1>
                </div>
            </div>
        </nav>      
       
        <nav class="navbar navbar-inverse navbar-static-top navbar-menu-police" data-spy="affix" data-offset-top="90">
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
                        <li class="active"><a href="accueil_categorie.php"><span class="glyphicon glyphicon-home"></span> Gestion Catégorie </a></li>
                        <li><a href="accueil_mnemonique.php"><span class="glyphicon glyphicon-list-alt"></span>Gestion Mnémonique</a></li>
                        <li><a href="export_csv.php"><span class="glyphicon glyphicon-list-alt"></span>Export CSV</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        
         <div class="container">
			<?php
				if(isset($_GET['msg']) && $_GET['msg'] == "Failure") {
                    genererMessage(
                        "Modification de catégorie",
                        "Échec lors de la modification !",
                        "remove",
                        "danger"
                    );
				}
            ?> 
            <div>
                <a href='accueil_categorie.php' class="btn btn-default" role="button">
                    <i class='glyphicon glyphicon-arrow-left'></i> Retour
                </a>
            </div>
            <h1>Modification Catégorie : <?php echo $categorie['NomC'] ?></h1>
            <form method="Post" action="enregistrer_categorie.php?modifier">
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Nom catégorie</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo $categorie['NomC'] ?>" name="nomC" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Désignation catégorie</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo $categorie['DesignationC'] ?>" name="designationC" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Choisir mnémonique</label>
                    <div class='col-sm-10'>
                    <?php
                        $result = listeMnemoniqueAvecCodeC($link, $categorie['CodeC']);

                        if ($result != NULL)
                            $rows = mysqli_num_rows($result);
                        else
                            $rows = 0;

                        for ($i = 0; $i < $rows; $i++) {
                            $donnees = mysqli_fetch_array($result);
                            if($donnees['Label'] != Null) {
                                echo "
                                    <div class='row' style='height:34px'>
                                        <div class='col-sm-3'>
                                            <input class='form-check-input' type='checkbox' value='".$donnees['CodeM']."'
                                                name='mnemonique[]' checked>
                                            <label class='form-check-label'>".$donnees['Mnemonique']."</label>
                                        </div>
                                        <div class='col-sm-9'>
                                            <input type='text' class='form-control' placeholder=\"Indiquer l'intitulé exact des justificatifs demandés ...\"
                                                value=\"".$donnees['Label']."\" name='label[]' id='". $donnees['CodeM'].
                                            "'>
                                        </div>
                                    </div>"
                                ;                          
                            }
                            else {
                                echo "
                                    <div class='row' style='height:34px'>
                                        <div class='col-sm-3'>
                                            <input class='form-check-input' type='checkbox' value='".$donnees['CodeM']."'
                                                name='mnemonique[]'>
                                            <label class='form-check-label'>".$donnees['Mnemonique']."</label>
                                        </div>
                                        <div class='col-sm-9'>
                                            <input type='text' class='form-control' placeholder=\"Indiquer l'intitulé exact des justificatifs demandés ...\"
                                                name='label[]' id='". $donnees['CodeM']."' class='form-control' style='display: none'>
                                        </div>
                                    </div>"
                                ;     
                            }
                        }
                    ?>
                    </div>
                </div>
                <input type="hidden" name="idC" value="<?php echo $_GET["id"]?>">
                <input type="hidden" name="modif" value="ok">
                <button type="submit" class="btn btn-primary btn-lg">
                    <span class="glyphicon glyphicon-lock"></span> Valider
                </button>
            </form>
        </div>
    </body>
</html>