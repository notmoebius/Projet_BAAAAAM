/******************************************************************/

/* GESTION DE L'AFFICHAGE DES MESSAGES LORS DU SURVOL DES BOUTONS */

/******************************************************************/


/*------------------------------------------------------------------
 	INITIALISATION
------------------------------------------------------------------*/

var hover_1 = false; // Vrai si le premier bouton est survolé, faux sinon
var hover_2 = false; // Vrai si le deuxième bouton est survolé, faux sinon

$(document).ready(function(){
    // Gestion de l'évènement de survol
    // Si le permier bouton est survolé
    $("#first_button").hover(function(event){
        hover_1 = true; // Alors, la variable 'hover_1' passe à vrai
    }, function(){
        hover_1 = false; // Elle passe à faux sinon
    });
    // Si le deuxième bouton est survolé
    $("#second_button").hover(function(event){
        hover_2 = true; // Alors, la variable 'hover_2' passe à vrai
    }, function(){
        hover_2 = false; // Elle passe à faux sinon
    });
    
    // Gestion de l'évènement de la souris en mouvement
    // Si le pointeur de la souris se déplace
    $("html").mousemove(function(){
        if (hover_1) { // Et qu'il survole le premier bouton
            // Alors le premier message s'affiche
            $("#msg_1").fadeIn(500);

            // Le message est légerment décalement pour éviter d'être sur le pointeur
            // à l'aide des variables x (position horizontale) et y (position verticale)
            // et selon la taille de l'écran
            if(window.innerWidth >= 768) var x =  20;
            else var x = -$(".msg").width() / 2 - 20;
            var y =  $(".msg").height();
            y += parseInt($(".msg").css("padding-bottom"), 10);
            y += parseInt($(".msg").css("padding-top"), 10);
            y += 10;

            // Le premier message suit le pointeur de la souris
            $("#msg_1").offset({top: event.pageY - y, left: event.pageX + x});
        }
        else {					
            // Sinon, il est caché
            $("#msg_1").fadeOut(300);
        }

        if (hover_2) { // Et qu'il survole le deuxième bouton
            // Alors le deuxième message s'affiche
            $("#msg_2").fadeIn(500);
            
            // Le message est légerment décalement pour éviter d'être sur le pointeur
            // à l'aide des variables x (position horizontale) et y (position verticale)
            // et selon la taille de l'écran
            if(window.innerWidth >= 768) var x =  20;
            else var x = -$(".msg").width() / 2 - 20;
            var y = parseInt($("#msg_2").css("padding-bottom"), 10);
            y += parseInt($("#msg_2").css("padding-top"), 10);
            y += 10;

        
            // Le deuxième message suit le pointeur de la souris
            $("#msg_2").offset({top: event.pageY + y, left: event.pageX + x});
        }
        else {						
            // Sinon, il est caché
            $("#msg_2").fadeOut(300);
        }
    });        
});