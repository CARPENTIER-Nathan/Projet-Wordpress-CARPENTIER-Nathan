<?php

class NC_Projet_CRUD{

    public function insert($table, $tab_valeur){
        global $wpdb;

        if($table == $wpdb->prefix.NC_PROJET_BASENAME."_utilisateurs"){
            $wpdb->insert(  $table, 
                            array(
                                'id' => NULL,
                                'prenom' => $tab_valeur[0], 
                                'nom' => $tab_valeur[1], 
                                'civilite' => $tab_valeur[2], 
                                'email' => $tab_valeur[3], 
                                'date-naissance' => $tab_valeur[4]
                            ) 
                        );
            return "Insertion de l'utilisateur : OK ";
        }

        if($table == $wpdb->prefix.NC_PROJET_BASENAME."_voyages_effectuer"){
            $wpdb->insert(  $table, 
                            array(
                                'id' => NULL,
                                'utilisateur' => $tab_valeur[0], 
                                'voyages' => $tab_valeur[1]
                            ) 
                        );
            return "Insertion des voyages effectuer par l'utilisateur : OK ";
        }
        return "Erreur sur l'écriture du nom de la table ciblé";

    }
    
    public function result($element_souhaiter, $table, $params = 1){
        
        global $wpdb;
        
        $sql = "SELECT ".$element_souhaiter." FROM `". $table ."` WHERE ".$params;
        $result = $wpdb->get_results($sql,'ARRAY_A');

        return $result;

    }

    public function update($element_souhaiter, $data , $table, $id){

        global $wpdb;

        if($wpdb->update($table, [$element_souhaiter => $data],['id' => $id])){
            return "Mise à jour faite !";
        }
        
        return "Erreur sur l'update.";

    }

}

?>