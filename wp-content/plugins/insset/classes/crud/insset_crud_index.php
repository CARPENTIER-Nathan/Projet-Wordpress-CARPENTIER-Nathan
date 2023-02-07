<?php

class insset_crud_index {

    public function ajout(){

        global $wpdb;
        
        $wpdb->insert($wpdb->prefix . INSSET_BASENAME . '_subscribers',['id'=>0]);
        $lastid = $wpdb->insert_id;
        
        return $lastid;

    }

    public function ajout_v2($refId, $key_of_value, $key_value){
        global $wpdb;
        $table_name_sub_newsletter = $wpdb->prefix . INSSET_BASENAME . '_subscribersdata';

        $wpdb->insert(
            $table_name_sub_newsletter,
            array(
                'id' => $refId,
                'cle' => $key_of_value,
                'valeur' => $key_value,
                'index' => NULL,
            )
        );

        return true;
    }


    public function supp($id){
        global $wpdb;

        if($id == null){
            return;
        }
        
        if($wpdb->delete($wpdb->prefix . INSSET_BASENAME . '_subscribersdata',['id'=>$id])){
            if($wpdb->delete($wpdb->prefix . INSSET_BASENAME . '_subscribers',['id'=>$id])){
                    return "La suppression s'est bien effectué !";
            }
        }
        else{
            return "Veuillez envoyez un 'id' étant dans la BDD.";
        }
    }

    static public function getConfig(){
        
        global $wpdb;

        $db = $wpdb->prefix . INSSET_BASENAME .'_config';

        $sql = "SELECT * FROM $db";

        $result = $wpdb->get_results($sql, 'ARRAY_A');

        return $result;
    }

    static public function setConfig($id, $valeur){

        global $wpdb;

        if($wpdb->update($wpdb->prefix .INSSET_BASENAME."_config", array('valeur' => $valeur), ['id' => $id])){

            return "Mise à jour faite !";

        }

        return "Error";
    }

}

?>