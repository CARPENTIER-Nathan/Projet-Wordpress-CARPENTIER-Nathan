<?php

/*
Plugin Name: NC_Projet
Author: Nat
Version: 1.0.0
*/

if (!defined('ABSPATH')){
    exit;
}

define('NC_PROJET_VERSION', '1.0.0');
define('NC_PROJET_FILE', __FILE__);
define('NC_PROJET_DIR', dirname(NC_PROJET_FILE));
define('NC_PROJET_BASENAME', pathinfo((NC_PROJET_FILE))['filename']);
define('NC_PROJET_PLUGIN_NAME', NC_PROJET_BASENAME);

foreach (glob(NC_PROJET_DIR .'/Classes/*/*.php') as $filename){
    if (!preg_match('/export|cron/i', $filename)){
        if (!@require_once $filename){
            throw new Exception(sprintf(__('Failed to include %s'), $filename));
        }
    }
}

register_activation_hook(NC_PROJET_FILE, function() {
    $NC_PROJET_Install = new NC_PROJET_Install();
    $NC_PROJET_Install->setup();
});

if (is_admin()){
    new NC_PROJET_Admin();
}
else{
    new NC_PROJET_Front();
}
?>