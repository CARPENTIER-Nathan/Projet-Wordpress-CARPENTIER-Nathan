<?php

class Insset_Install {

    public function __construct() {

        add_action( 'admin_init', array( $this, 'setup' ) );
        return;

    }

    public function setup() {
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();
    require_once(ABSPATH .'wp-admin/includes/upgrade.php');

    if(!$this->isTableBaseAlreadyCreated('_subscribers')){
        $sql_subscribers = '
            CREATE TABLE IF NOT EXISTS `'. $wpdb->prefix . INSSET_BASENAME . '_subscribers' .'` (
                `id` INT(11) AUTO_INCREMENT NOT NULL,
                `date` DATETIME DEFAULT now() NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB '. $charset_collate;
            dbDelta($sql_subscribers);
    }

    if(!$this->isTableBaseAlreadyCreated('_subscribersdata')){
        $sql_subscribersdata = '
        CREATE TABLE IF NOT EXISTS `'. $wpdb->prefix . INSSET_BASENAME . '_subscribersdata` (
            `index` INT(11) AUTO_INCREMENT NOT NULL,
            `valeur` VARCHAR(255) NOT NULL,
            `cle` VARCHAR(255) NOT NULL,
            `id` INT(11) NOT NULL,
            PRIMARY KEY (`index`),
            FOREIGN KEY (`id`) REFERENCES `'. $wpdb->prefix . INSSET_BASENAME . '_subscribers`(id)
        ) ENGINE=InnoDB '. $charset_collate;

        dbDelta($sql_subscribersdata);
    }

    if(!$this->isTableBaseAlreadyCreated('_config')){
        $sql_config = '
            CREATE TABLE IF NOT EXISTS `'. $wpdb->prefix . INSSET_BASENAME . '_config' .'` (
                `id` VARCHAR(255) NOT NULL,
                `valeur` VARCHAR(255) NULL,
                `description` VARCHAR(255) NULL,
                `rank` INT(11) NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB '. $charset_collate;
            dbDelta($sql_config);
    }

    if(dbDelta($sql_config)){
        $wpdb->insert($wpdb->prefix.INSSET_BASENAME.'_config', array('id'=> 'DateOuverture', 'valeur'=> '01/01/2023', 'description'=> 'Date Ouverture', 'rank'=>10));            
        $wpdb->insert($wpdb->prefix.INSSET_BASENAME.'_config', array('id'=> 'DateFermeture','valeur'=> '30/12/2023', 'description'=> 'Date Fermeture', 'rank'=>20));
        $wpdb->insert($wpdb->prefix.INSSET_BASENAME.'_config', array('id'=> 'MaximumInscrits','valeur'=> '5', 'description'=> 'Maximums Inscription', 'rank'=>30));
        return "L'installation s'est bien effectué !";
    }
    else{
        return "L'installation était déjà faite !";
    }

}

    public function isTableBaseAlreadyCreated($table) {

        global $wpdb;

        $sql = 'SHOW TABLES LIKE \'%'. $wpdb->prefix . INSSET_BASENAME . $table .'%\'';
        return $wpdb->get_var($sql);

    }
}

?>