<?php

add_shortcode('FORMULAIRE_LISTE_PAYS', array('NC_Projet_ShortCodes_Formulaires_Liste_Pays', 'display'));

class NC_Projet_ShortCodes_Formulaires_Liste_Pays{
    
    function display($attr){

        return "
        <div id=\"affichage_liste_pays\">
        </div>
        ";
    }
}
?>