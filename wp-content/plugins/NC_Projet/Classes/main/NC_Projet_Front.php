<?php 

class NC_Projet_Front{

    public function __construct() {

        add_action('wp_enqueue_scripts', array($this, 'assets'), 999);
        return;

    }

    public function assets() {

        wp_enqueue_style('front-style', plugins_url(NC_PROJET_PLUGIN_NAME).'/assets/css/NC_PROJET_Front.css');
        
        wp_register_script('jQuery', plugins_url(NC_PROJET_PLUGIN_NAME .'/assets/js/jquery.min.js',1, true));
        wp_enqueue_script('jQuery');    

        wp_register_script('front-js', plugins_url(NC_PROJET_PLUGIN_NAME .'/assets/js/NC_PROJET_Front.js',NC_PROJET_VERSION, true));
        wp_enqueue_script('front-js');        
        wp_localize_script('front-js', 'front_script', array(
            'ajax_url' => admin_url('admin-ajax.php'), 
            'security' => wp_create_nonce('ajax_nonce_security')
        ));        
        return;
    }

}

?>