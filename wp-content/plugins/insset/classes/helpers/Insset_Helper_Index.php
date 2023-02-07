<?php

class Insset_Helper_Index{
    
    public function isOpen(){

        $configs = insset_crud_index::getConfig();
        
        foreach ($configs as $config){
            if ($id = $config['id']){
                $$id = $config['valeur'];
            }
        }
        
        if (!isset($DateOuverture) || !isset($DateFermeture)){
            return false;
        }

		$start_at = strtotime($DateOuverture);
        $end_at = strtotime($DateFermeture);
        $now = strtotime(date('Y-m-d H:i'));

        return ($start_at <= $now) && ($now < $end_at);

    }
}

?>