<?php

add_action('wp_ajax_voyagesactif', array('NC_Projet_Admin_Index', 'Voyages_Actif'));


class NC_Projet_Admin_Index {

    public static function Voyages_Actif(){

        global $wpdb;
        check_ajax_referer('ajax_nonce_security', 'security');
        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1){
            exit;
        }

        $taille_tableau = $_REQUEST['taille_tableau'];
        $valeur_selected = explode(",",$_REQUEST['tableau_selected']);
        $NC_Projet_CRUD = new NC_PROJET_CRUD();

        for($tab = 0 ; $tab < $taille_tableau; $tab++){
            for($boucle = 0; $boucle < sizeof($valeur_selected) ; $boucle++){
                if($tab == $valeur_selected[$boucle]){
                    $NC_Projet_CRUD->update("actif-inactif","0",$wpdb->prefix.NC_PROJET_BASENAME."_voyages",$valeur_selected[$boucle]);
                    $boucle = sizeof($valeur_selected);
                }
                else{
                    $NC_Projet_CRUD->update("actif-inactif","1",$wpdb->prefix.NC_PROJET_BASENAME."_voyages",$tab);
                }
            }
        }
        print "Mise à jour faite !";
    }


}


?>