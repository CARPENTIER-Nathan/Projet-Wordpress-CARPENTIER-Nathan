<?php

add_shortcode('FORMULAIRE', array('Insset_shortcode_formulaire', 'display'));

class Insset_shortcode_formulaire {

    static function display($atts) {
        $Insset_Helper_Index = new Insset_Helper_Index();
        $isOpen = $Insset_Helper_Index->isOpen();

        if(!$isOpen){
            return __("Module Ferme");
        }

        return "
        <form id=\"formulaire\" method=\"POST\">
            <fieldset>
                <legend> <?php_e('Your coords')?> </legend>
                    <input type=\"text\" id=\"firstname\" name=\"firstname\" placeholder=\"First Name\">
                    <input type=\"text\" id=\"lastname\" name=\"lastname\" placeholder=\"Last Name\">
                    <input type=\"text\" id=\"email\" name=\"email\" placeholder=\"Email\">
                    <input type=\"text\" id=\"code_postal\" name=\"code_postal\" placeholder=\"Code Postal\">
                </fieldset>
            <button id=\"submit\" type=\"submit\">Submit</button>
        </form>
        ";
    }
}

?>