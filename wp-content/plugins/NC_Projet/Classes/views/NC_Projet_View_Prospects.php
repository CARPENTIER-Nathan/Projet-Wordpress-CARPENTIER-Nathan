<?php

class NC_Projet_View_Prospects{
    
    public function __construct() {

        return;

    }

    public function affichage(){

        global $wpdb;

        $NC_Projet_CRUD = new NC_PROJET_CRUD();
        $utilisateurs = $NC_Projet_CRUD->result("`id`,`prenom`,`nom`,`civilite`", $wpdb->prefix.NC_PROJET_BASENAME."_utilisateurs");

        $tempscreen = get_current_screen();
        $this->_screen = $tempscreen->base;

       $tool_bar = $this->toolbar(); 
        ?>  
        <div class="wrap">
            <h1 class="wp-heading-inline"><?php print get_admin_page_title(); ?></h1>
            <hr class="wp-header-end" />
            <div class="wrap" id="list-table">
                <form id="list-table-form" method="post">
                    <?php
                    $page  = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRIPPED );
                    $paged = filter_input( INPUT_GET, 'paged', FILTER_SANITIZE_NUMBER_INT );
                    printf('<input type="hidden" name="page" value="%s" />', $page);
                    printf('<input type="hidden" name="paged" value="%d" />', $paged);
                    ?>
                    <table class="wp-list-table widefat fixed striped table-view-list items">
                        <tr>
                            <td>
                                Civilité + Nom + Prénom
                            </td>
                            <td>
                                Nombre de Pays selectionner
                            </td>
                        </tr>
                        <?php 
                            foreach($utilisateurs as $prospects){
                                print("<tr>");
                                print("<td>".$prospects["civilite"].". ".$prospects["nom"]." ".$prospects["prenom"]."</td>");

                                $voyages_effectuer = $NC_Projet_CRUD->result("DISTINCT `voyages`", $wpdb->prefix.NC_PROJET_BASENAME."_voyages_effectuer", "`utilisateur`=".$prospects["id"]);

                                print("<td>".sizeof($voyages_effectuer)."</td>");
                                print("</tr>");
                            }
                        ?>
                    </table>
                </form>
            </div>
        </div>
        <?php
    }

    public function toolbar(){
        ?>
        <div>

        <form action="<?php print admin_url('admin-post.php'); ?>" method="post">
            <table>
                <tbody>
                    <tr>
                        <?php if(defined('NC_PROJET_PLUGIN_NAME')) ?>
                        <td>
                            <a class="button button-secondary" href="<?php print plugins_url(NC_PROJET_PLUGIN_NAME.'/classes/export/NC_Projet_Export_CSV.php'); ?>">
                                <i class="fas fa-save"></i>&nbsp;CSV 
                            </a>
                        </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>

        <hr class="wp-header-end">
        <?php
    }
}
?>