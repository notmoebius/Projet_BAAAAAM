/******************************************************************/

/*   SCRIPT JS POUR LA GESTION DES PAGES CÔTÉ ASSURÉ          */

/******************************************************************/


/*------------------------------------------------------------------
 	FONCTIONS GÉNÉRALES
------------------------------------------------------------------*/

//À modifier si l'on souhaite modifier le formalisme de NIR et de la référence dossier
var formatNIR = "# ## ## ## ### ###";
var nbCharRefD = 8;
var pj = [];
//Fonction pour gérer les messages des statuts
function showInfo_function(currentPJ) {
    $("#info-status").show();
}

function hideInfo() {
    $("#info-status").hide();
}

//Affiche un message détaillant un statut lors du survol d'un bouton
function showInfo() {
    for (i = 0; i < pj.length; i++) {
        $("#" + pj[i]).hover(showInfo_function(pj[i]), hideInfo());
    }
}

//Scroll vers le div d'identifiants "id"
function goToByScroll(id, duration, margin_top) {
    // Remove "link" from the ID
    id = id.replace("link", "");

    // Scroll
    $('html,body').animate({
        scrollTop: $("#" + id).offset().top + margin_top
    }, duration);
}

//Rafraichissement du formulaire
function refreshForm() {
    //Si les éléments de l'état civil n'est pas affiché
    if ($("#form_panel > div.container:first-child").is(":visible") == false) {
        $("#form_panel").hide(); //On affiche le formulaire
        $("#form_panel").show(500); //On affiche le formulaire
    }
    goToByScroll('form_panel', 1000, 50); //On scroll sur le formulaire
}

//Désactivation de l'évènement clic pour un objet dont le
//sélecteur est entré en paramètre
function isUnselected(selector) {
    var classList = $(selector).attr('class').split(/\s+/);

    for (i = 0; i < classList.length; i++) {
        if (classList[i] == "unselected") return true;
    }

    return false;
}

//Cache tous les justificatifs
function hideAllPJ() {
    for (i = 0; i < pj.length; i++) {
        $("." + pj[i]).hide();
    }
}

// Cache le formulaire (pour le cas du travailleur indépendant)
function hideForm() {
    $("#etat-civil").hide();
    $("#pj").hide();
}

// Affiche le formulaire (pour les cas autres que le travailleur indépendant)
function showForm() {
    $("#etat-civil").show();
    $("#pj").show();
}

//Création d'une fonction événementielle déclenchée au clic
//sur l'un des bouton $("#" + pj[i])
function click_function(event) {
    var currentPJ = event.data.arg1;

    if (isUnselected("#" + currentPJ)) {
        refreshForm();

        hideAllPJ();
        $("#form_panel > div.panel-heading").text($("#" + currentPJ).text());
        $("." + currentPJ).show(1000);
        $(".selected").toggleClass("unselected selected");
        $("#" + currentPJ).toggleClass("unselected selected");
        $("#" + currentPJ).toggleClass("unselected selected");

        // Toggle sur le required
        for (i = 0; i < pj.length; i++) {
            $("." + pj[i] + " input[type='file']").prop('required', false);
        }
        $("." + currentPJ + " input[type='file']").prop('required', true);

        if ((currentPJ == "interim") |
            (currentPJ == "art-aut") |
            (currentPJ == "cesu") |
            (currentPJ == "independant")
        ) {
            //Changement de texte
            $("#nb_BS").text("12"); //12 Bulletins de salaire
            $("#seuil_BS").text("l'arrêt de travail"); //Autres cas que celui de Pôle Emploi
        } else if (currentPJ == "pole-emploi") {
            //Changement de texte
            $("#nb_BS").text("4"); //4 Bulletins de salaire
            $("#max_BS").text("l'inscription à Pôle Emploi"); //Cas à Pôle Emploi
        } else if (currentPJ == "pole-emploiC") {
            //Changement de texte
            $("#nb_BS").text("3"); //4 Bulletins de salaire
            $("#max_BS").text("l'inscription à Pôle Emploi"); //Cas à Pôle Emploi
        }
    }
}

//Fonction qui retourne la date d'aujoud'hui en français
function dateAujoudhuiEnLettres() {
    // les noms de jours / mois
    var joursEnLettres = new Array("dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi");
    var moisEnLettres = new Array("janvier", "février", "mars", "avril", "mai", "juin", "juillet", "aout", "septembre", "octobre", "novembre", "décembre");
    var aujourdhui = new Date();

    var jour = joursEnLettres[aujourdhui.getDay()];
    var numJour = aujourdhui.getDate();
    var mois = moisEnLettres[aujourdhui.getMonth()];
    var annee = aujourdhui.getFullYear();

    return jour + " " + numJour + " " + mois + " " + annee;
}

//Fonction qui retourne l'heure actuelle
function heureActuelle() {
    var aujourdhui = new Date();

    var heures = (aujourdhui.getHours() < 10) ? "0" + aujourdhui.getHours() : aujourdhui.getHours();
    var minutes = (aujourdhui.getMinutes() < 10) ? "0" + aujourdhui.getMinutes() : aujourdhui.getMinutes();
    var secondes = (aujourdhui.getSeconds() < 10) ? "0" + aujourdhui.getSeconds() : aujourdhui.getSeconds();

    return heures + ":" + minutes + ":" + secondes;
}

//Retourne la date d'aujoud'hui au format "yyyy-mm-dd"
function aujourdhui() {
    var aujourdhui = new Date();
    var numoJour = aujourdhui.getDate();
    var mois = aujourdhui.getMonth() + 1;

    var texte = aujourdhui.getFullYear() + "-";
    texte += (mois < 10) ? "0" + mois + "-" : mois + "-";
    texte += (numoJour < 10) ? "0" + numoJour : numoJour;

    return texte;
}

//Fonction qui imprime le contenu d'un élément dont l'id est passé en paramètre
function imprimerPage() {
    $(".ignore").hide();

    var date = dateAujoudhuiEnLettres();
    var heure = heureActuelle();
    var infoImpression = "Effectuée le " + dateAujoudhuiEnLettres() + " à " + heureActuelle() + ".";

    var message = '<div id="message" class="alert alert-warning">' +
        '<strong><strong>&#128438;</strong> Impression : </strong> ' +
        infoImpression +
        '</div>';

    $("body").append(message);

    document.title = 'Confirmation d\'enregistrement sur PJPE [' + date + " à " + heure + ']';
    window.print();

    $("#message").remove();
    $(".ignore").show();
}

function enregistrerPage() {
    $(".ignore").hide();

    var infoImpression = "Effectuée le " + dateAujoudhuiEnLettres() + " à " + heureActuelle() + ".";

    var message = '<div id="message" class="alert alert-warning">' +
        '<strong><strong>&#128438;</strong> Impression : </strong> ' +
        infoImpression +
        '</div>';

    $("body").append(message);
    uriContent = "data:application/octet-stream," + encodeURIComponent(window.document.html);
    newWindow = window.open(uriContent, 'neuesDokument');

    $("#message").remove();
    $(".ignore").show();
}

//Vérifie et corrige le format du NIR
function checkFormatNir(format) {
    formatNIR = format;

    let caret = document.getElementById("nir").selectionStart;
    var str = $("#nir").val().toUpperCase();

    //Suppression des valeurs invalides
    var pattern = /[0-9]|(A)|(B)|\s/g; //Prendre en compte le cas de la Corse (2A ou 2B)	
    var match = str.match(pattern);
    if (match != null) {
        str = match.join("");
        var deb = str.substr(0, caret);
        var fin = str.substr(caret);

        for (i = 0; i < caret; i++) {
            if (format.charAt(i) == " " && str.charAt(i) != " ") {
                deb = deb.substr(0, i) + " " + deb.substr(i);
                caret++;
            }
        }

        //Si le curseur est dans la chaine de caractères
        if (caret < str.length - 1) {
            for (i = caret; i < format.length; i++) {
                if (format.charAt(i) == " " && fin.charAt(i - caret) != " ") {
                    fin = fin.substr(0, i - caret) + " " + fin.substr(i - caret);
                }
                if (format.charAt(i) == "#" && fin.charAt(i - caret) == " ") {
                    fin = fin.substr(0, i - caret) + fin.substr(i - caret + 1);
                }
            }
        }

        str = deb + fin;
        //Si le nombre de caractères courant dépasse celui du nombre autorisé
        if (str.length > format.length) str = str.substr(0, format.length);

        $("#nir").val(str);
        document.getElementById("nir").setSelectionRange(caret, caret);
    }
}

//Vérifie et corrige le format du NIR
function checkFormatRefD() {
    let caret = document.getElementById("refD").selectionStart;
    var str = $("#refD").val();

    //Suppression des valeurs invalides
    var pattern = /[a-zA-Z0-9]/g;
    var match = str.match(pattern);
    if (match != null) {
        str = match.join("");

        //Suppression des caractères en trop
        if (str.length > nbCharRefD) { str = str.substr(0, nbCharRefD); }

        $("#refD").val(str);
    }

    document.getElementById("refD").setSelectionRange(caret, caret);
}

//Mise à jour du mnémonique
function MajInputMnemo(id) {
    var select = $("#" + id);
    var input = select.parent().parent().find("input[type='file'");
    input.attr("name", select.val() + "[]");
}

//Supprimer la ligne de dépôt de document d'id 'id'
function supprimerInput(id) {
    $("#" + id).remove();
}

//Affichage des zones de dépot des PJ en fonction
//de la catégorie choisie via le nom des classes
$(document).ready(function() {
    showInfo();

    for (i = 0; i < pj.length; i++) {
        var currentPJ = pj[i];
        $("#" + currentPJ).addClass("unselected"); //Désélection de tous les boutons
        $("#" + currentPJ).click({ arg1: currentPJ }, click_function);

        if (currentPJ == "independant") {
            // Si on clique sur la case du travailleur indépendant
            $("#" + currentPJ).click(function() {
                $(this).toggleClass("unselected selected"); // On met la classe active sur le bouton
                hideForm(); // Le formulaire se ferme
                $("#lien_ameli").show(); // Le message vers AMELI s'ouvre
            });
        } else {
            // Si on clique mais pas sur la case du travailleur indépendant
            $("#" + currentPJ).click(function() {
                $(this).toggleClass("unselected selected"); // On met la classe active sur le bouton
                showForm(); // Le formulaire s'ouvre
                $("#lien_ameli").hide(); // Le message vers AMELI se ferme
            });
        }
    }

    $("#checkref").hide();

    //Met la date d'aujourdhui en maximum et comme valeur par défaut dans le champ calendrier
    $("#date_arret").attr("max", aujourdhui());

    // Gestion des messages
    $(".alert").hide();
    $(".alert").show(1500);

    // Affichage d'un bouton de suppression lors du survol
    $(".alert").hover(function() {
        //Création du bouton de suppression
        var elt = document.createElement("span");
        elt.id = "msg_close";
        elt.className = "glyphicon glyphicon-remove";
        $(this).find(".alert-title").append(elt);

        //Initialisation de l'évènement "clic"
        $("#msg_close").click(function() {
            // On cache le message parent le plus proche
            $(this).closest(".alert").hide(400, function() {
                $(this).remove();
            });
        });
    }, function() {
        // Sinon on le supprime
        $("#msg_close").remove();
    });

    // Désactivation de tous les boutons de classe disabled
    $(".disabled").attr("disabled", true);
});