<?php 

class Insset_Admin{
    
    public function __construct() {

        add_action('admin_menu', array($this, 'menu'), -1);
        // wp_enqueue_script( 'fontawesome', plugins_url( 'assets/js/fontawesome.js',INSSET_FILE));
        add_action('wp_enqueue_scripts', array($this, 'ajout_js'), 0);
        return;

    }

    public function ajout_js(){
        wp_register_script('insset', plugins_url(INSSET_PLUGIN_NAME .'/assets/js/Insset_Admin.js'), array('jquery-new'), INSSET_VERSION, true);
        wp_enqueue_script('insset');

        wp_localize_script('insset', 'inssetscript', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'security' => wp_create_nonce('ajax_nonce_security')
        ));
    }

    public function menu(){
        add_menu_page(
            __('Menu'),
            __('Page des menus'),
            'administrator',
            'yeptrackchoicesfall_settings',
            array($this, 'yeptrackchoicesfall_settings'),
            // 'images/marker.png',
            // 1000
        );

        add_submenu_page(
            'yeptrackchoicesfall_settings',
            __('Suivis'),
            __('Suivis'),
            'administrator',
            'yeptrackchoicesfall_settings',
            array($this, 'yeptrackchoicesfall_settings')
        );

        add_submenu_page(
            'yeptrackchoicesfall_settings',
            __('Settings'),
            __('Parametres'),
            'administrator',
            'yeptrackchoicesfall_import_form',
            array($this, 'yeptrackchoicesfall_import_form')
        );

        add_action('admin_enqueue_scripts', array($this, 'assets'), 999);
    }

    public function assets() {

        wp_enqueue_style('admin-style', plugins_url(INSSET_PLUGIN_NAME).'/assets/css/Insset_Admin.css');

        wp_register_script('inssetB', plugins_url(INSSET_PLUGIN_NAME .'/assets/js/Insset_Admin.js', INSSET_VERSION, true));
        wp_enqueue_script('inssetB');        
        
        wp_localize_script('inssetB', 'inssetscript', array(
            'ajax_url' => admin_url('admin-ajax.php'), 
            'security' => wp_create_nonce('ajax_nonce_security')
        ));        
        return;

    }


    public function yeptrackchoicesfall_settings() {

        $Insset_List = new insset_view();
        $Insset_List->display();
    }

    public function yeptrackchoicesfall_import_form() {

        $Insset_Config = new insset_view_config();
        $Insset_Config->display();
    }

}

?>