<?php

    $path = __DIR__;
    preg_match('/(.*)wp\-content/i', $path, $dir);
    require_once(end($dir). 'wp-load.php');

    global $wpdb;

    $db_utilisateurs = $wpdb->prefix . NC_PROJET_BASENAME .'_utilisateurs';
    $db_voyages_effectuer = $wpdb->prefix . NC_PROJET_BASENAME .'_voyages_effectuer';
    $db_voyages = $wpdb->prefix . NC_PROJET_BASENAME .'_voyages';

    $sql = "SELECT * FROM $db_utilisateurs";
    $inscrits = $wpdb->get_results($sql,'ARRAY_A');

    $boucle = 0;
    $listes_pays[] = null;

    foreach($inscrits as $liste_utilisateurs){
        $sql = "SELECT DISTINCT `voyages` FROM $db_voyages_effectuer WHERE `utilisateur`=".$liste_utilisateurs['id'];
        $voyages_effectuer = $wpdb->get_results($sql,'ARRAY_A');

        if(sizeof($voyages_effectuer) != 0){
            foreach($voyages_effectuer as $v_e){
                $sql = "SELECT `ISO alpha-3` FROM $db_voyages WHERE `id` = ".$v_e['voyages'];
                $voyages = $wpdb->get_results($sql,'ARRAY_A');
                foreach($voyages as $v){
                    if($listes_pays[$liste_utilisateurs['id']] == null){
                        $listes_pays[$liste_utilisateurs['id']] = $v['ISO alpha-3'];
                    }
                    else{
                        $listes_pays[$liste_utilisateurs['id']] = $listes_pays[$liste_utilisateurs['id']]." - ".$v['ISO alpha-3'];
                    }
                }
            }
        }
        else{
            $listes_pays[$liste_utilisateurs['id']] = "Aucun Pays n'a été selectionner par cette personne";
        }
    }

    ob_start();

    $heads = array(
        "Genre",
        "Nom",
        "Prenom",
        "Mail",
        "Age",
        "Pays"
    );
    print '"'.implode('"; "', $heads)."\"\n";

    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Controle: must-revalidate, post-check=0, precheck=0');
    header('Cache-Control: private', false);
    header('Content-Type: text/csv; charset=UTF-8');

    foreach($inscrits as $sign){
        $sign = array_map('trimming', $sign);
        $age = CalculAge($sign['date-naissance']);

        $fields = array(
            (string) $sign['civilite'],
            (string) $sign['nom'],
            (string) $sign['prenom'],
            (string) $sign['email'],
            (string) $age,
            (string) $listes_pays[$sign['id']]
        );

        print '"'.implode('"; "', $fields)."\"\n";
    }

    $filename = sprintf('NC_Projet_Export_CSV_%s.csv', date('d-m-Y_His'));
    header('Content-Disposition: attachment; filename="'. $filename. '";');
    header('Content-Transfer-Encoding: binary');
    ob_end_flush();

    function trimming($val){
        return trim($val);
    }

    function CalculAge($date_naissance){
        $date_actuel = date('Y-m-d');

        $année_actuel = intval(substr($date_actuel,0,4));
        $mois_actuel = intval(substr($date_actuel,5,2));
        $jour_actuel = intval(substr($date_actuel,8,2));

        $année_naissance = intval(substr($date_naissance,0,4));
        $mois_naissance = intval(substr($date_naissance,5,2));
        $jour_naissance = intval(substr($date_naissance,8,2));

        if($année_naissance <= $année_actuel){
            $age = $année_actuel - $année_naissance;

            if($mois_naissance > $mois_actuel){
                return $age-1;
            }
            else if($mois_naissance == $mois_actuel){
                if($jour_naissance > $jour_actuel){
                    return $age-1;
                }
                else{
                    return $age;
                }
            }
            else{
                return $age;
            }
        }
        else{
            return "Il n'est pas encore de ce monde";
        }

    }

?>