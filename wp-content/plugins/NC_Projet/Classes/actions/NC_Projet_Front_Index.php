<?php

add_action('wp_ajax_formulaireutilisateur', array('NC_Projet_Front_Index','Inscription_Utilisateur'));
add_action('wp_ajax_nopriv_formulaireutilisateur', array('NC_Projet_Front_Index','Inscription_Utilisateur'));

add_action('wp_ajax_formulairelistepays', array('NC_Projet_Front_Index','Inscription_ListePays'));
add_action('wp_ajax_nopriv_formulairelistepays', array('NC_Projet_Front_Index','Inscription_ListePays'));

add_action('wp_ajax_assets', array('NC_Projet_Front_Index','assets'));
add_action('wp_ajax_nopriv_assets', array('NC_Projet_Front_Index','assets'));

add_action('wp_ajax_getvalue', array('NC_Projet_Front_Index','GetValue'));
add_action('wp_ajax_nopriv_getvalue', array('NC_Projet_Front_Index','GetValue'));

class NC_Projet_Front_Index{

    // Page Utilisateur //
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
    //-----------------//

    // Page Liste Pays //
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
    //----------------//


    // Page Résultat Final //
    public static function assets(){
        
        global $wpdb;
        check_ajax_referer('ajax_nonce_security', 'security');
        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1){
            return "0";
        };

        $json = $_REQUEST['data'];
        $json = stripslashes($json);
        $json = json_decode($json, true);

        $utilisateur_formulaire = "Prenom : ".$json['utilisateur']['prenom']." <br> Nom : ".$json['utilisateur']['nom']." <br> Civilite : ".$json['utilisateur']['civilite']." <br> Email : ".$json['utilisateur']['email']."";
        
        for($boucle = 0 ; $boucle < sizeof($json['pays']); $boucle++){
            $etoiles = "";
            for($nb_etoiles = 0; $nb_etoiles < 5 ; $nb_etoiles++){
                if($nb_etoiles < $json['pays'][$boucle]['note']){
                    $etoiles .= "&#9733;";
                }
                else{
                    $etoiles .= "&#10025;";
                }
            }

            $pays_formulaire .= "Note : ".$etoiles." | Pays : ".$json['pays'][$boucle]['pays']."<br>";
        }

        print "             
        <style>
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
          }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        </style>
        <script id=\"Script_Modal\" type=\"text/x-handlebars-template\" src=\"".plugins_url(NC_PROJET_PLUGIN_NAME."/Assets/HandleBar/NC_Projet_Resultat_Modal.hbs")."\"></script>

        <form id=\"formulaire_resultat\" class=\"formulaire_resultat\" method=\"POST\" >
            <fieldset>

                <div id=\"Modal\" class=\"modal\">
                </div>

                <legend> <?php_e('Your coords')?> </legend>
                    <fieldset>
                        ".$utilisateur_formulaire."
                    </fieldset>
                    <fieldset>
                        ".$pays_formulaire."
                    </fieldset>
                <input type=\"button\" id=\"submit_resultat\" value=\"Envoyez\">
            </fieldset>
        </form>";
        exit;
    }

    public static function GetValue(){
        global $wpdb;
        check_ajax_referer('ajax_nonce_security', 'security');
        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1){
            exit;
        };

        $NC_Projet_CRUD = new NC_Projet_CRUD();
        
        $result_voyages_effectuer = $NC_Projet_CRUD->result("*", $wpdb->prefix.NC_PROJET_BASENAME."_voyages_effectuer", "`utilisateur`=\"".$_REQUEST['Id_Utilisateur']."\"");
    
        $result_utilisateur = $NC_Projet_CRUD->result("`prenom`,`nom`,`civilite`,`email`", $wpdb->prefix.NC_PROJET_BASENAME."_utilisateurs", "`id`=\"".$result_voyages_effectuer[0]['utilisateur']."\"");
        
        $result_all['utilisateur']['prenom'] = $result_utilisateur[0]['prenom'];
        $result_all['utilisateur']['nom'] = $result_utilisateur[0]['nom'];
        $result_all['utilisateur']['civilite'] = $result_utilisateur[0]['civilite'];
        $result_all['utilisateur']['email'] = $result_utilisateur[0]['email'];

        for($boucle = 0 ; $boucle < sizeof($result_voyages_effectuer); $boucle++){
            $result_voyages[$boucle] = $NC_Projet_CRUD->result("`pays`,`note`", $wpdb->prefix.NC_PROJET_BASENAME."_voyages", "`id`=\"".$result_voyages_effectuer[$boucle]['voyages']."\"");
        }

        $boucle = 0;
        foreach($result_voyages as $p){
            $result_all['pays'][$boucle]['note'] = $p[0]['note'];
            $result_all['pays'][$boucle]['pays'] = $p[0]['pays'];
            $boucle++;
        }

        print json_encode($result_all);
        exit;
    }
}


?>