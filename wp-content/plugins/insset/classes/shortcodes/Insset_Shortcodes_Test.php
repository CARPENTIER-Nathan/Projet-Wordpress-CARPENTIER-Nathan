<?php

add_shortcode('INSSET_TEST', array('Insset_Shortcodes_Test', 'test'));
class Insset_Shortcodes_Test {
    static public function test() {
        var_dump(get_query_var('mavariabletest'));
    }
}

?>