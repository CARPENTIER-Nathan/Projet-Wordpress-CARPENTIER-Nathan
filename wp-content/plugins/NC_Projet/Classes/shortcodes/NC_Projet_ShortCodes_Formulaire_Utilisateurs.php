<?php

add_shortcode('FORMULAIRE_UTILISATEUR', array('NC_Projet_ShortCodes_Formulaires_Utilisateurs', 'display'));

class NC_Projet_ShortCodes_Formulaires_Utilisateurs{
    
    function display($attr){
        $date_actuel = date('Y-m-d');
        return "
        <script type=\"text/javascript\" src=\"https://www.gstatic.com/charts/loader.js\"></script>

        <div id=\"inscription_utilisateur\">
        </div>

        <div id=\"carte\">
        </div>
        ";
    }
}
?>