<?php

    $path = __DIR__;
    preg_match('/(.*)wp\-content/i', $path, $dir);
    require_once(end($dir). 'wp-load.php');

    global $wpdb;

    $db_first = $wpdb->prefix . INSSET_BASENAME .'_subscribers';
    $db_second = $wpdb->prefix . INSSET_BASENAME .'_subscribersdata';
    $sql = "SELECT A.*, 
    (SELECT B.`valeur` FROM `$db_second` B WHERE B.`id`=A.`id` AND B.`cle`='firstname' LIMIT 1) AS 'firstname', 
    (SELECT B.`valeur` FROM `$db_second` B WHERE B.`id`=A.`id` AND B.`cle`='email' LIMIT 1) AS 'email',
    (SELECT B.`valeur` FROM `$db_second` B WHERE B.`id`=A.`id` AND B.`cle`='lastname' LIMIT 1) AS 'lastname',
    (SELECT B.`valeur` FROM `$db_second` B WHERE B.`id`=A.`id` AND B.`cle`='code_postal' LIMIT 1) AS 'code_postal'
    FROM `$db_first` A ";

    $inscrits = $wpdb->get_results($sql,'ARRAY_A');
    
    ob_start();

    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Controle: must-revalidate, post-check=0, precheck=0');
    header('Cache-Control: private', false);

    $xml = new SimpleXMLElement('<Inscript/>');
    foreach ($inscrits as $inscrit) :
        $event = $xml->addChild('sign');
    
        foreach ($inscrit as $key => $value) :
            $event->addChild($key, $value);
        endforeach;
    
    endforeach;
    
    print $xml->asXML();

    $filename = sprintf('Insset_Export_XML_%s.xml', date('d-m-Y_His'));
    header('Content-Disposition: attachment; filename="'. $filename. '";');
    header('Content-Transfer-Encoding: binary');
    ob_end_flush();

?>