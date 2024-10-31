<?php
/**
 * Plugin Name: PullQuote
 * Plugin URI: https://github.com/DivineDominion/wp-pullquote
 * Description: Create shareable pullquotes with the <code>[pullquote]</code> shortcode.
 * Version: 1.0
 * Author: Christian Tietze
 * Author URI: http://christiantietze.de
 * License: GPL2
 */

// TODO currently, $pullquoteOptions contains 'active' only but never uses it

define("PULLQUOTE_VER", "20131025", false);

if (!defined('PULLQUOTE_PLUGIN_BASENAME')) {
    define('PULLQUOTE_PLUGIN_BASENAME', plugin_basename(__FILE__));
}

global $pullquoteOptions;
$pullquoteOptions = get_option('pullquote_options');

require_once(dirname(__FILE__) . '/functions.php');
require_once(dirname(__FILE__) . '/includes/core.php');


function install_pullquote() {
    $default_settings = array(
        'active' => false
    );
        
    delete_option('pullquote_options');      
    update_option('pullquote_options', $default_settings);
}

function uninstall_pullquote() {
    global $wpdb;
    delete_option('pullquote_options'); 
}

/*
 * MU Options
 */
register_activation_hook( __FILE__, 'checkMU_install_pullquote' );
register_uninstall_hook( __FILE__, 'checkMU_uninstall_pullquote' );
add_action('wpmu_new_blog', 'newBlog_pullquote', 10, 6);

function checkMU_install_pullquote($network_wide) {
    global $wpdb;
    if ( $network_wide ) {
        $blog_list = get_blog_list( 0, 'all' );
        foreach ($blog_list as $blog) {
            switch_to_blog($blog['blog_id']);
            install_pullquote();
        }
        switch_to_blog($wpdb->blogid);
    } else {
        install_pullquote();
    }
}

function checkMU_uninstall_pullquote($network_wide) {
    global $wpdb;
    if ( $network_wide ) {
        $blog_list = get_blog_list( 0, 'all' );
        foreach ($blog_list as $blog) {
            switch_to_blog($blog['blog_id']);
            uninstall_pullquote();
        }
        switch_to_blog($wpdb->blogid);
    } else {
        uninstall_pullquote();
    }
}

function newBlog_pullquote($blog_id, $user_id, $domain, $path, $site_id, $meta ) {
    global $wpdb;
 
    if (is_plugin_active_for_network('pullquote/pullquote.php')) {
        $old_blog = $wpdb->blogid;
        switch_to_blog($blog_id);
        install_pullquote();
        switch_to_blog($old_blog);
    }
}
