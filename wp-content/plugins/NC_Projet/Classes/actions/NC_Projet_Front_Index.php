<?php

add_action('wp_ajax_formulaireutilisateur', array('NC_Projet_Front_Index','Inscription_Utilisateur'));
add_action('wp_ajax_nopriv_formulaireutilisateur', array('NC_Projet_Front_Index','Inscription_Utilisateur'));

class NC_Projet_Front_Index{

    public static function Inscription_Utilisateur(){

        global $wpdb;
        check_ajax_referer('ajax_nonce_security', 'security');
        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1){
            exit;
        }

        $erreur = $_REQUEST['error'];
    
        if($erreur == null){

            $tableau_utilisateur[0] = $_REQUEST['prenom'];
            $tableau_utilisateur[1] = $_REQUEST['nom'];

            if($_REQUEST['civilite'] == "Homme"){
                $tableau_utilisateur[2] = "M";
            }
            else{
                $tableau_utilisateur[2] = "Mme";
            }
            $tableau_utilisateur[3] = $_REQUEST['email'];
            $tableau_utilisateur[4] = $_REQUEST['date-naissance'];

            $NC_Projet_CRUD = new NC_PROJET_CRUD();
            $NC_Projet_CRUD->insert($wpdb->prefix.NC_PROJET_BASENAME."_utilisateurs", $tableau_utilisateur);
            print "Ajoute de l'utilisateur : ".$tableau_utilisateur[2].". ".$tableau_utilisateur[1];
        }
        else{
            print $erreur; 
        }

    }

}


?>