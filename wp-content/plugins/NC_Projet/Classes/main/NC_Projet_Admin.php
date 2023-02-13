<?php

class NC_Projet_Admin{

    public function __construct() {
        
        add_action('admin_menu', array($this, 'add_menu'), -1);
        return;

    }

    public function add_menu(){
        add_menu_page(
            __('Menu'),
            __('Paramètres Voyages'),
            'administrator',
            'voyages',
            array($this, 'page_config'),
        );

        add_submenu_page(
            'voyages',
            __('Configuration'),
            __('Configuration'),
            'administrator',
            'page_config',
            array($this, 'page_config')
        );

        add_submenu_page(
            'voyages',
            __('Liste Pays'),
            __('Liste Pays'),
            'administrator',
            'page_pays',
            array($this, 'page_pays')
        );

        add_submenu_page(
            'voyages',
            __('Prospects'),
            __('Prospects'),
            'administrator',
            'page_prospects',
            array($this, 'page_prospects')
        );

        add_action('admin_enqueue_scripts', array($this, 'assets'), 999);
    }

    public function assets() {

        wp_enqueue_style('admin-style', plugins_url(NC_PROJET_PLUGIN_NAME).'/assets/css/NC_PROJET_Admin.css');
        
        wp_register_script('admin-js', plugins_url(NC_PROJET_PLUGIN_NAME .'/assets/js/NC_PROJET_Admin.js',NC_PROJET_VERSION, true));
        wp_enqueue_script('admin-js');        
        wp_localize_script('admin-js', 'adminscript', array(
            'ajax_url' => admin_url('admin-ajax.php'), 
            'security' => wp_create_nonce('ajax_nonce_security')
        ));        
        return;
    }

    public function page_config(){
        $NC_Projet_Config = new NC_Projet_View_Config();
        $NC_Projet_Config->affichage();
    }

    public function page_pays(){

    }

    public function page_prospects(){

    }
}

?>