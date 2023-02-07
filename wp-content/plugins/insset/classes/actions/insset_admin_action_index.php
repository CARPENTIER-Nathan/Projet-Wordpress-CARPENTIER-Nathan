<?php

add_action('wp_ajax_remove', array('insset_admin_action_index', 'RemoveJob'));
add_action('wp_ajax_update', array('insset_admin_action_index', 'Update'));

class insset_admin_action_index{

    public static function RemoveJob(){

        check_ajax_referer('ajax_nonce_security', 'security');

        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1){
            exit;
        }

        $crud = new insset_crud_index();
        $crud->supp($_REQUEST['id']);

        exit;
    }

    static public function Update(){
        check_ajax_referer('ajax_nonce_security', 'security');
        $crud = new insset_crud_index();

        if ((!isset($_REQUEST)) || sizeof(@$_REQUEST) < 1){
            exit;
        }

        foreach($_REQUEST as $key => $valeur){
            if(!in_array($key, ['security','action'])){
                $$key = (string) trim($valeur);
                $crud->setConfig($key, $valeur);
            }
        }


        exit;
    }

}

?>