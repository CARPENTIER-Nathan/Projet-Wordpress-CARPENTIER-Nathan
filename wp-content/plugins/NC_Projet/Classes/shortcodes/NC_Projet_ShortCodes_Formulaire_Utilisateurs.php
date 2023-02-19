<?php

add_shortcode('FORMULAIRE_UTILISATEUR', array('NC_Projet_ShortCodes_Formulaires_Utilisateurs', 'display'));

class NC_Projet_ShortCodes_Formulaires_Utilisateurs{
    
    function display($attr){

        $date_actuel = date('Y-m-d');
        return "
        <form id=\"formulaire_utilisateur\" method=\"POST\">
            <fieldset>
                <legend> <?php_e('Your coords')?> </legend>
                    <input type=\"text\" id=\"nom\" name=\"nom\" placeholder=\"Saisir votre Nom\">
                    <input type=\"text\" id=\"prenom\" name=\"prenom\" placeholder=\"Saisir votre Prénom\">
                    <input type=\"text\" id=\"email\" name=\"email\" placeholder=\"Saisir votre Email\">
                    <select id=\"sexe\" name=\"sexe\">
                        <option value=\"Homme\"> Homme </option>
                        <option value=\"Femme\"> Femme </option>
                    </select>
                    Saisir votre Date de naissance :
                    <input type=\"date\" value=\"$date_actuel\" max=\"$date_actuel\"> 
            </fieldset>
            <button id=\"submit\" type=\"submit\">Submit</button>
        </form>
        ";
    }
}
?>