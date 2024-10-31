<?php
function pullquote_plugin_url( $path = '' ) {
    global $wp_version;
    if ( version_compare( $wp_version, '2.8', '<' ) ) { // Using WordPress 2.7
        $folder = dirname( plugin_basename( __FILE__ ) );
        if ( '.' != $folder )
            $path = path_join( ltrim( $folder, '/' ), $path );

        return plugins_url( $path );
    }
    return plugins_url( $path, __FILE__ );
}


function pullquote_addbuttons() {
   // Don't bother doing this stuff if the current user lacks permissions
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
     return;
 
   // Add only in Rich Editor mode
   if ( get_user_option('rich_editing') == 'true') {
     add_filter("mce_external_plugins", "add_pullquote_tinymce_plugin");
     add_filter('mce_buttons', 'register_pullquote_button');
   }
}
 
function register_pullquote_button($buttons) {
   array_push($buttons, "pullquote");
   return $buttons;
}
 
// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
function add_pullquote_tinymce_plugin($plugin_array) {
   $plugin_array['pullquote'] = pullquote_plugin_url().'/tinymce/pullquote.js';
   return $plugin_array;
}
 
// init process for button control
add_action('init', 'pullquote_addbuttons');
