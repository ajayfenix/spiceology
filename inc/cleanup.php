<?php

function ct_disable_default_dashboard_widgets() {
    remove_meta_box( 'dashboard_right_now', 'dashboard', 'core' );
    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'core' );
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'core' );
    remove_meta_box( 'dashboard_plugins', 'dashboard', 'core' );
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'core' );
    remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'core' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'core' );
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'core' );
}
add_action( 'admin_menu', 'ct_disable_default_dashboard_widgets', 990 );


function ct_remove_admin_bar_items( $wp_admin_bar ) {
    $wp_admin_bar->remove_node( 'wp-logo' );
    $wp_admin_bar->remove_node( 'comments' );
    $wp_admin_bar->remove_node( 'customize' );
}
add_action( 'admin_bar_menu', 'ct_remove_admin_bar_items', 99 );


/**
 * Remove RSD (Really Simple Discovery) Links from header
 *
 * RSD is only useful to keep if pingback is needed or
 * if a remote client is used to manage posts.
 */
remove_action( 'wp_head', 'rsd_link' );


/**
 * Disable Windows Live Writer
 */
remove_action( 'wp_head', 'wlwmanifest_link' );


/**
 * Disable Emoticons
 *
 * This remove extra code related to emojis from WordPress
 * which was added recently to support emoticons on older browsers.
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// (Optional) Completely remove Emoticons
add_filter( 'option_use_smilies', '__return_false' );


/**
 * Remove Shortlinks
 *
 * WordPress adds shorter links to the header.
 *
 * @since WP version 3.0
 */
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );


/**
 * Disable Embeds
 *
 * @see https://codex.wordpress.org/Embeds#oEmbed WordPress oEmbeds
 * @since WP version 4.4
 */
function ct_disable_embed() {
    wp_dequeue_script( 'wp-embed' );
}
add_action( 'wp_footer', 'ct_disable_embed' );


/**
 * Disable XML-RPC
 *
 * WordPress API (XML-RPC) allows to publish/edit/delete a post,
 * edit/list comments, upload file remotely.
 *
 * If XML-RPC is not properly secure it may
 * lead to DDoS & brute force attacks.
 *
 * Unless there's specific requirements for this.
 * It's better to disable XML-RPC.
 */
add_filter( 'xmlrpc_enabled', '__return_false' );


/**
 * Hide WordPress Version
 *
 * This doesn't improve the performance of WP at all
 * but is useful to hide from a security point of view.
 */
remove_action( 'wp_head', 'wp_generator' );


/**
 * Remove WLManifest Link
 *
 * Kind of pointless to have WLManifest unless
 * Windows Live Writer is used to write the posts.
 * (most likely not the case).
 */
remove_action( 'wp_head', 'wp_generator' );


/**
 * Disable Self Pingback
 *
 * If you link to a post or page within the site,
 * the self pingback feature will send a notification
 * (as though you were linking to an external source).
 */
function ct_disable_pingback( &$links ) {
    foreach ( $links as $l => $link ) {
        if ( 0 === strpos( $link, get_option( 'home' ) ) ) {
            unset( $links[ $l ] );
        }
    }
}
add_action( 'pre_ping', 'ct_disable_pingback' );


/**
 * To clean out customizer styles that bigcommerce prints.
 * @param  string $css the css that's to be printed.
 * @return string      returning empty to clean out.
 */
function ct_clean_bigcommerce( $css ) {
    return '';
}
add_filter( 'bigcommerce/css/customizer_styles', 'ct_clean_bigcommerce' );


/**
 * Disable Heartbeat API
 *
 * WordPress uses the heartbeat API to communicate with a browser
 * to the server by frequently calling admin-ajax.php.
 * This may slow down the overall page load time and
 * it increases CPU utilization even more-so if on a shared hosting.
 */
function ct_stop_heartbeat() {
    wp_deregister_script( 'heartbeat' );
}
add_action( 'init', 'ct_stop_heartbeat', 1 );


/**
 * Force all scripts to footer
 */
function ct_js_to_footer() {
    remove_action( 'wp_head', 'wp_print_scripts' );
    remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
    remove_action( 'wp_head', 'wp_enqueue_scripts', 1 );
}
add_action( 'wp_enqueue_scripts', 'ct_js_to_footer', 0 );


/**
 * Force remove assets deemed unnessary
 */
function ct_remove_assets() {
    wp_dequeue_style( 'bigcommerce-styles' );

    if ( ct_is_pagespeed() ) {
        wp_dequeue_script( 'bigcommerce-manifest' );
        wp_dequeue_script( 'bigcommerce-vendors' );
        wp_dequeue_script( 'bigcommerce-scripts' );
    } else {
        wp_enqueue_script( 'smile.io', 'https://cdn.sweettooth.io/assets/storefront.js', array(), '1.0', true );
    }
}
add_action( 'wp_enqueue_scripts', 'ct_remove_assets', 1000 );



if ( ct_is_pagespeed() ) {

    function ct_optimize( $buffer ) {
        
        $buffer = preg_replace( '/<!-- Segment Analytics Code -->([\S\s]*?)<!-- End Segment Analytics Code -->/', '', $buffer );
        $buffer = preg_replace( '/<!-- Start of Async HubSpot Analytics Code -->([\S\s]*?)<!-- End of Async HubSpot Analytics Code -->/', '', $buffer );
        
        return $buffer;
    }

    function ct_buffer_start() { 
        ob_start( 'ct_optimize' );
    }
    function ct_buffer_end() {
        if ( ob_get_length() ) ob_end_clean();
    }
    add_action( 'wp_loaded', 'ct_buffer_start' );
    add_action( 'shutdown', 'ct_buffer_end' );

}

