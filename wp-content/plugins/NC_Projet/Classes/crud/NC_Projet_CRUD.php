<?php

class NC_Projet_CRUD{

    public function insert(){}
    public function delete(){}
    
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