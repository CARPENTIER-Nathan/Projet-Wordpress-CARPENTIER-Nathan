<?php

class NC_Projet_Helper{
    
    function CalculAge($date_naissance){
        $date_actuel = date('Y-m-d');

        $année_actuel = intval(substr($date_actuel,0,4));
        $mois_actuel = intval(substr($date_actuel,5,2));
        $jour_actuel = intval(substr($date_actuel,8,2));

        $année_naissance = intval(substr($date_naissance,0,4));
        $mois_naissance = intval(substr($date_naissance,5,2));
        $jour_naissance = intval(substr($date_naissance,8,2));

        if($année_naissance <= $année_actuel){
            $age = $année_actuel - $année_naissance;

            if($mois_naissance > $mois_actuel){
                return $age-1;
            }
            else if($mois_naissance == $mois_actuel){
                if($jour_naissance > $jour_actuel){
                    return $age-1;
                }
                else{
                    return $age;
                }
            }
            else{
                return $age;
            }
        }
        else{
            return "Il n'est pas encore de ce monde";
        }

    }
}
?>