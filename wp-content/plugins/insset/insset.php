<?php

/*
Plugin Name: Insset
Author: Nat
Version: 1.0.1
*/

if (!defined('ABSPATH')){
    exit;
}

define('INSSET_VERSION', '1.0.0');
define('INSSET_FILE', __FILE__);
define('INSSET_DIR', dirname(INSSET_FILE));
define('INSSET_BASENAME', pathinfo((INSSET_FILE))['filename']);
define('INSSET_PLUGIN_NAME', INSSET_BASENAME);
define('INSSET_URL', 'page-test');

foreach (glob(INSSET_DIR .'/classes/*/*.php') as $filename){
    if (!preg_match('/export|cron/i', $filename)){
        if (!@require_once $filename){
            throw new Exception(sprintf(__('Failed to include %s'), $filename));
        }
    }
}

register_activation_hook(INSSET_FILE, function() {
    $Insset_Install = new Insset_Install();
    $Insset_Install->setup();
});

if (is_admin()){
    new Insset_Admin();
}
else{
    new Insset_Front();
}
?>