<?php

    $path = __DIR__;
    preg_match('/(.*)wp\-content/i', $path, $dir);
    require_once(end($dir). 'wp-load.php');

    global $wpdb;

    $db = $wpdb->prefix . NC_PROJET_BASENAME .'_voyages';
    $sql = "SELECT * FROM $db WHERE 1";

    $inscrits = $wpdb->get_results($sql,'ARRAY_A');
    
    ob_start();

    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Controle: must-revalidate, post-check=0, precheck=0');
    header('Cache-Control: private', false);

    $xml = new SimpleXMLElement('<Liste_Pays/>');
    foreach ($inscrits as $inscrit) :
        $event = $xml->addChild('Pays');

        foreach ($inscrit as $key => $value) :
            if($key != "ISO alpha-3"){
                $event->addChild($key, $value);
            }   
            else{
                $event->addChild("ISO_alpha-3", $value);
            } 
        endforeach;
    
    endforeach;
    
    print $xml->asXML();

    $filename = sprintf('NC_Projet_Export_XML_%s.xml', date('d-m-Y_His'));
    header('Content-Disposition: attachment; filename="'. $filename. '";');
    header('Content-Transfer-Encoding: binary');
    ob_end_flush();

?>