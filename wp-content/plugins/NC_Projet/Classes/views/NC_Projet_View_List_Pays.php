<?php

class NC_Projet_View_List_Pays{
    
    public function __construct() {

        return;

    }

    public function affichage(){

        global $wpdb;

        $NC_Projet_CRUD = new NC_PROJET_CRUD();
        $liste_pays = $NC_Projet_CRUD->result("`id`,`pays`,`ISO alpha-3`,`note`,`dispo-majeur`", $wpdb->prefix.NC_PROJET_BASENAME."_voyages");

        $tempscreen = get_current_screen();
        $this->_screen = $tempscreen->base;

        $tool_bar = $this->toolbar(); 
        ?>  
        <div class="wrap">
            <h1 class="wp-heading-inline"><?php print get_admin_page_title(); ?></h1>
            <hr class="wp-header-end" />
            <div class="wrap" id="list-table">
            Les pays où la checkbox sera valide/coché ne pourront pas être disponible au mineur.
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
                                Pays
                            </td>
                            <td>
                                ISO alpha-3
                            </td>
                            <td>
                                Note de 0 à 5
                            </td>
                            <td>
                                Réserver aux majeurs
                            </td>
                        </tr>
                        <?php 
                        
                        foreach($liste_pays as $pays){
                            print("<tr>");
                                print("<td>".$pays["pays"]."</td>");
                                print("<td>".$pays["ISO alpha-3"]."</td>");
                                print("<td> <select class=\"PaysNote\">");
                                for($i = 0; $i <= 5; $i++){
                                    if($i == $pays["note"]){
                                        printf("<option value=\"%d:%d\" selected> %d </option>",$pays["id"],$i,$i);
                                    }
                                    else{
                                        printf("<option value=\"%d:%d\"> %d </option>",$pays["id"],$i,$i);
                                    }
                                }
                                print("</select> </td>");

                                if($pays["dispo-majeur"] == 1){
                                    printf("<td> <input type=\"checkbox\" class=\"DispoMajeur\" value=\"%d\" checked> </td>",$pays["id"]);
                                }
                                else{
                                    printf("<td> <input type=\"checkbox\" class=\"DispoMajeur\" value=\"%d\"> </td>",$pays["id"]);
                                }
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
                                <a class="button button-secondary" href="<?php print plugins_url(NC_PROJET_PLUGIN_NAME.'/classes/export/NC_Projet_Export_XML.php'); ?>">
                                        <i class="fas fa-save"></i>&nbsp;XML 
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