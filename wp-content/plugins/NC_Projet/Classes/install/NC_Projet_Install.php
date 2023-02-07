<?php

class NC_Projet_Install {

    public function __construct(){

        add_action('admin_init', array($this, 'setup'));
        return;

    }

    public function setup(){
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        require_once(ABSPATH .'wp-admin/includes/upgrade.php');

        if(!$this->TableExistant('_voyages')){
            $sql_voyages ='
            CREATE TABLE IF NOT EXISTS `'. $wpdb->prefix . NC_PROJET_BASENAME . '_voyages' .'` (
                `id` INT(11) AUTO_INCREMENT NOT NULL,
                `pays` VARCHAR(255) NOT NULL,
                `ISO alpha-3` VARCHAR(3) NOT NULL,
                `note` INT(5) NOT NULL,
                `dispo-majeur` BOOLEAN,
                `actif-inactif` BOOLEAN,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB '. $charset_collate;
            dbDelta($sql_voyages);
        }

        if(!$this->TableExistant('_utilisateurs')){
            $sql_utilisateur ='
            CREATE TABLE IF NOT EXISTS `'. $wpdb->prefix . NC_PROJET_BASENAME . '_utilisateurs' .'` (
                `id` INT(11) AUTO_INCREMENT NOT NULL,
                `prenom` VARCHAR(255) NOT NULL,
                `nom` VARCHAR(255) NOT NULL,
                `civilite` VARCHAR(255) NOT NULL,
                `email` VARCHAR(255) NOT NULL,
                `date-naissance` DATETIME DEFAULT now() NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB '. $charset_collate;
            dbDelta($sql_utilisateur);
        }

        if(!$this->TableExistant('_voyages_effectuer')){
            $sql_voyages_effectuer ='
            CREATE TABLE IF NOT EXISTS `'. $wpdb->prefix . NC_PROJET_BASENAME . '_voyages_effectuer' .'` (
                `id` INT(11) AUTO_INCREMENT NOT NULL,
                `utilisateur` INT(11) NOT NULL,
                `voyages` INT(11) NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (`utilisateur`) REFERENCES `'.$wpdb->prefix.NC_PROJET_BASENAME.'_utilisateurs`(id),
                FOREIGN KEY (`voyages`) REFERENCES `'.$wpdb->prefix.NC_PROJET_BASENAME.'_voyages`(id)
            ) ENGINE=InnoDB '. $charset_collate;
            dbDelta($sql_voyages_effectuer);
        }
 
    }

    public function TableExistant($table) {

        global $wpdb;
        $sql = 'SHOW TABLES LIKE \'%'. $wpdb->prefix . NC_PROJET_BASENAME . $table .'%\'';
        return $wpdb->get_var($sql);

    }
}

?>