<?php
add_shortcode('FORMULAIRE_RESULTAT', array('NC_Projet_ShortCodes_Formulaires_Resultats', 'display'));

class NC_Projet_ShortCodes_Formulaires_Resultats{
    
    function display(){

        return "
        <script src=\"https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js\"></script>

        <div id=\"resultat_final\">

        </div>

        <input type=\"button\" id=\"test\">
        ";
    }
}
?>