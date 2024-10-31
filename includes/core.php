<?php
add_shortcode('pullquote', 'pullquote_simple_shortcode');
add_action('init', 'pullquote_enqueue_scripts');
add_action('wp', 'pullquote_enqueue_styles');

function pullquote_simple_shortcode($atts, $content) {
    extract(shortcode_atts(array(
        'position' => 'left',
        'hidden' => 'false'
    ), $atts));
    
    return "<span class='pullquote-source' data-float='".$position."' data-hidden='".$hidden."'>".$content."</span>";
}

function pullquote_enqueue_scripts() {
    global $pullquoteOptions;
    if ( !is_admin() ){ 
        wp_enqueue_script('jquery' );
        wp_enqueue_script('pullquote', pullquote_plugin_url('js/pullquote.js'),
            array('jquery'), PULLQUOTE_VER, false); 
    }
}

function pullquote_enqueue_styles() {
  global $pullquoteOptions;
  wp_enqueue_style('pullquote_headcss', pullquote_plugin_url('css/pullquote.css'),
    false, PULLQUOTE_VER, 'all');
}
