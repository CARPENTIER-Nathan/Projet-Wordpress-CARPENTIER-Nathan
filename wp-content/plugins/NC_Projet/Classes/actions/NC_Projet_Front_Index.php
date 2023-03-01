<?php

add_action('wp_ajax_formulaireutilisateur', array('NC_Projet_Front_Index','Inscription_Utilisateur'));
add_action('wp_ajax_nopriv_formulaireutilisateur', array('NC_Projet_Front_Index','Inscription_Utilisateur'));

add_action('wp_ajax_formulairelistepays', array('NC_Projet_Front_Index','Inscription_ListePays'));
add_action('wp_ajax_nopriv_formulairelistepays', array('NC_Projet_Front_Index','Inscription_ListePays'));

class NC_Projet_Front_Index{

    public static function Inscription_Utilisateur(){

        global $wpdb;
        check_ajax_referer('ajax_nonce_security', 'security');
        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1){
            exit;
        }

        if($_REQUEST['error'] == "Aucune Erreur"){
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
            $id_user = $NC_Projet_CRUD->result("`id`", $wpdb->prefix.NC_PROJET_BASENAME."_utilisateurs" ,
                                                                                                            "`prenom`=\"".$tableau_utilisateur[0]."\" AND 
                                                                                                            `nom`=\"".$tableau_utilisateur[1]."\" AND
                                                                                                            `civilite`=\"".$tableau_utilisateur[2]."\" AND
                                                                                                            `email`=\"".$tableau_utilisateur[3]."\" AND
                                                                                                            `date-naissance`=\"".$tableau_utilisateur[4]."\""
                                                                                                        );
            if($id_user[0]['id'] == ""){
                $NC_Projet_CRUD->insert($wpdb->prefix.NC_PROJET_BASENAME."_utilisateurs", $tableau_utilisateur);

                $id_user = $NC_Projet_CRUD->result("`id`", $wpdb->prefix.NC_PROJET_BASENAME."_utilisateurs" ,
                                                                                                            "`prenom`=\"".$tableau_utilisateur[0]."\" AND 
                                                                                                            `nom`=\"".$tableau_utilisateur[1]."\" AND
                                                                                                            `civilite`=\"".$tableau_utilisateur[2]."\" AND
                                                                                                            `email`=\"".$tableau_utilisateur[3]."\" AND
                                                                                                            `date-naissance`=\"".$tableau_utilisateur[4]."\""
                                                                                                            );
                print $id_user[0]['id'];
                exit;
            }else{
                print $id_user[0]['id'];
                exit;
            }            
        }
        else{
            print $_REQUEST['error']; 
            exit;
        }
    }

    public static function Inscription_ListePays(){
        global $wpdb;
        check_ajax_referer('ajax_nonce_security', 'security');
        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1){
            exit;
        }

        $NC_Projet_CRUD = new NC_Projet_CRUD();
        $erreur = $_REQUEST['Error'];
        
        if($erreur == "Aucune Erreur"){
            $ListePays[] = null;
            $ListePays[] = explode(",",$_REQUEST['Liste_Pays']);

            $data[0] = $_REQUEST['Id_User'];

            $result = $NC_Projet_CRUD->result("`id`",$wpdb->prefix.NC_PROJET_BASENAME."_voyages_effectuer","`utilisateur`=\"".$data[0]."\"");
            
            if($result[0]['id'] != null){
                foreach($result as $supp){
                    $NC_Projet_CRUD->delete($wpdb->prefix.NC_PROJET_BASENAME."_voyages_effectuer", $supp['id']);
                }
            }

            for($boucle = 0 ; $boucle < 5 ; $boucle++){
                $data[1] = $ListePays[1][$boucle];
                $NC_Projet_CRUD->insert($wpdb->prefix.NC_PROJET_BASENAME."_voyages_effectuer",$data);  
            }

            $result = $NC_Projet_CRUD->result("`id`",$wpdb->prefix.NC_PROJET_BASENAME."_voyages_effectuer","`utilisateur`=\"".$data[0]."\"");

            for($boucle = 0; $boucle < 5; $boucle++){
                if($all_result == null){
                    $all_result = $result[$boucle]['id'];
                }
                else{
                    $all_result = $all_result.",".$result[$boucle]['id'];
                }
            }
            print $all_result;
            exit;

        }
        else{
            print "Error :".$erreur;
            exit;
        }
        
    }
}


?>