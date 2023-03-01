<?php

add_shortcode('FORMULAIRE_LISTE_PAYS', array('NC_Projet_ShortCodes_Formulaires_Liste_Pays', 'display'));

class NC_Projet_ShortCodes_Formulaires_Liste_Pays{
    
    function display($attr){
        global $wpdb;
        $NC_Projet_CRUD = new NC_Projet_CRUD;
        $liste_pays = $NC_Projet_CRUD->result("`id`,`pays`", $wpdb->prefix.NC_PROJET_BASENAME."_voyages","`actif-inactif`=1");
 
        foreach($liste_pays as $pays){
           $lp .= "<option value=\"".$pays['id']."\">".$pays['pays']."</option>";
        }

        return "
        <form id=\"formulaire_liste_pays\" class=\"formulaire_liste_pays\" method=\"POST\" >
            <fieldset>
                <legend> <?php_e('Your coords')?> </legend>
                    Veuillez choisir un ou plusieurs pays :
                    <select class=\"ListePays\">
                        <option value=\"Rien\">Veuillez choisir votre premier pays</option>
                        $lp     
                    </select>
                    <select class=\"ListePays\" hidden>
                        <option value=\"Rien\">Veuillez choisir votre deuxième pays</option>
                        $lp     
                    </select>                    
                    <select class=\"ListePays\" hidden>
                        <option value=\"Rien\">Veuillez choisir votre troisième pays</option>
                        $lp     
                    </select>                    
                    <select class=\"ListePays\" hidden>
                        <option value=\"Rien\">Veuillez choisir votre quartième pays</option>
                        $lp     
                    </select>                    
                    <select class=\"ListePays\" hidden>
                        <option value=\"Rien\">Veuillez choisir votre cinquième pays</option>
                        $lp     
                    </select>
                    <input type=\"button\" id=\"submit_liste_pays\" class=\"submit_liste_pays\" value=\"Envoyez\">
            </fieldset>
        </form>
        ";
    }
}
?>