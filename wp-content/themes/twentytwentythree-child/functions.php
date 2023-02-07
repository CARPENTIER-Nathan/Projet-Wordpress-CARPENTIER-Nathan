<?php

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function theme_enqueue_styles() {

    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style', get_template_directory_uri() . '-child/style.css' );
    wp_enqueue_style( 'child-style_1', get_template_directory_uri() . '-child/assets/css/materialize.min.css' );
    wp_enqueue_style( 'child-style_2', get_template_directory_uri() . '-child/assets/css/ghpages-materialize.css' );

    wp_enqueue_script('jquery-new', get_template_directory_uri() .'-child/assets/js/jquery.min.js', array(), '3.6.3', true);
    wp_enqueue_script('jquery-loading', get_template_directory_uri() .'-child/assets/js/materialize.min.js', array(), '3.6.3', true);

}


add_action('wp_footer', 'loading_circle');
function loading_circle() {
    print '
        <div id="loading" class="row white">
            <div class="col s12">
                <div class="preloader-wrapper big active">
                    <div class="spinner-layer spinner-blue">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                    <div class="spinner-layer spinner-red">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                    <div class="spinner-layer spinner-yellow">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                    <div class="spinner-layer spinner-green">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
}
