<?php

add_action('wp_ajax_affichageinscription', array('NC_Projet_Front_Index','Affichage_Inscription'));
add_action('wp_ajax_nopriv_affichageinscription', array('NC_Projet_Front_Index','Affichage_Inscription'));

add_action('wp_ajax_affichagecarte', array('NC_Projet_Front_Index','Affichage_Carte'));
add_action('wp_ajax_nopriv_affichagecarte', array('NC_Projet_Front_Index','Affichage_Carte'));

add_action('wp_ajax_formulaireutilisateur', array('NC_Projet_Front_Index','Inscription_Utilisateur'));
add_action('wp_ajax_nopriv_formulaireutilisateur', array('NC_Projet_Front_Index','Inscription_Utilisateur'));

add_action('wp_ajax_affichagelistepays', array('NC_Projet_Front_Index','Affichage_Liste_Pays'));
add_action('wp_ajax_nopriv_affichagelistepays', array('NC_Projet_Front_Index','Affichage_Liste_Pays'));

add_action('wp_ajax_formulairelistepays', array('NC_Projet_Front_Index','Inscription_ListePays'));
add_action('wp_ajax_nopriv_formulairelistepays', array('NC_Projet_Front_Index','Inscription_ListePays'));

add_action('wp_ajax_affichageresultat', array('NC_Projet_Front_Index','Affichage_Resultat'));
add_action('wp_ajax_nopriv_affichageresultat', array('NC_Projet_Front_Index','Affichage_Resultat'));

add_action('wp_ajax_getvalue', array('NC_Projet_Front_Index','GetValue'));
add_action('wp_ajax_nopriv_getvalue', array('NC_Projet_Front_Index','GetValue'));

class NC_Projet_Front_Index{

    // Page Utilisateur //
    public static function Affichage_Inscription(){
        $date_actuel = date('Y-m-d');

        print "
        <form id=\"formulaire_utilisateur\" class=\"formulaire_utilisateur\" method=\"POST\" >
            <fieldset>
                <legend> <?php_e('Your coords')?> </legend>
                    Nom :
                    <input type=\"text\" id=\"nom\" name=\"nom\" placeholder=\"Saisir votre Nom\">

                    Prenom :
                    <input type=\"text\" id=\"prenom\" name=\"prenom\" placeholder=\"Saisir votre Prénom\">

                    Email :
                    <input type=\"text\" id=\"email\" name=\"email\" placeholder=\"Saisir votre Email\">

                    Sexe : 
                    <select id=\"sexe\" name=\"sexe\">
                        <option value=\"Homme\"> Homme </option>
                        <option value=\"Femme\"> Femme </option>
                    </select>

                    Saisir votre Date de naissance :
                    <input type=\"date\" id=\"date-naissance\" value=\"$date_actuel\" max=\"$date_actuel\"> 
                    <input type=\"button\" id=\"submit_utilisateur\" class=\"submit_utilisateur\" value=\"Envoyez\">
            </fieldset>
        </form>
        ";
        exit;
    }

    public static function Affichage_Carte(){
        global $wpdb;
        check_ajax_referer('ajax_nonce_security', 'security');
        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1){
            exit;
        }

        $JSON = $_REQUEST['JSON'];
        $JSON = stripslashes($JSON);
        $JSON = json_decode($JSON, true);

        $PaysSelectionner = "['Country'],";
        foreach($JSON['pays'] as $TousPays){
            $PaysSelectionner .= "['".Locale::getDisplayRegion("-".$TousPays['ISO alpha-3'], 'en')."'],";
        }

        print"
        <script type=\"text/javascript\">
          google.charts.load('current', {
            'packages':['geochart'],
          });
          google.charts.setOnLoadCallback(drawRegionsMap);
    
          function drawRegionsMap() {
            var data = google.visualization.arrayToDataTable([
                ".$PaysSelectionner."
            ]);
    
            var options = {};
    
            var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));
    
            chart.draw(data, options);
          }
        </script>
        <div id=\"regions_div\" style=\"width: 900px; height: 500px;\"></div>
        ";
      exit;
    }

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
    public static function Affichage_Liste_Pays(){
        global $wpdb;
        check_ajax_referer('ajax_nonce_security', 'security');
        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1){
            exit;
        }

        $id_user = $_REQUEST['Id_User'];
        $NC_Projet_Helper = new NC_Projet_Helper();
        $NC_Projet_CRUD = new NC_Projet_CRUD();

        $date_naissance = $NC_Projet_CRUD->result("*", $wpdb->prefix.NC_PROJET_BASENAME."_utilisateurs", "`id`=".$id_user);
        $age = $NC_Projet_Helper->CalculAge($date_naissance[0]['date-naissance']);
    
        if($age >= 16){
            $liste_pays = $NC_Projet_CRUD->result("`id`,`pays`", $wpdb->prefix.NC_PROJET_BASENAME."_voyages","`actif-inactif`=1");

            foreach($liste_pays as $pays){
                $lp .= "<option value=\"".$pays['id']."\">".$pays['pays']."</option>";
             }
     

        }
        else{
            $liste_pays = $NC_Projet_CRUD->result("`id`,`pays`", $wpdb->prefix.NC_PROJET_BASENAME."_voyages","`actif-inactif`=1 AND `dispo-majeur`=0");

            foreach($liste_pays as $pays){
                $lp .= "<option value=\"".$pays['id']."\">".$pays['pays']."</option>";
             }
     
        }

        print "
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
        exit;

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
    //----------------//


    // Page Résultat Final //
    public static function Affichage_Resultat(){
        
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
            $result_voyages[$boucle] = $NC_Projet_CRUD->result("`pays`,`ISO alpha-3`,`note`", $wpdb->prefix.NC_PROJET_BASENAME."_voyages", "`id`=\"".$result_voyages_effectuer[$boucle]['voyages']."\"");
        }

        $boucle = 0;
        foreach($result_voyages as $p){
            $result_all['pays'][$boucle]['note'] = $p[0]['note'];
            $result_all['pays'][$boucle]['pays'] = $p[0]['pays'];
            $result_all['pays'][$boucle]['ISO alpha-3'] = $p[0]['ISO alpha-3'];
            $boucle++;
        }

        print json_encode($result_all);
        exit;
    }
    //--------------------//
}


?>