<?php
/*
Plugin Name: TTT LoadMore
Plugin URI: http://www.33themes.com
Description: Load more content in your theme from AJAX event
Version: 1.1.1
Author: 33 Themes UG i.Gr.
Author URI: http://www.33themes.com
*/


define('TTTINC_LOADMORE', dirname(__FILE__) );
define('TTTVERSION_LOADMORE', 1.0 );


function ttt_autoload_loadmore( $class ) {
    if ( 0 !== strpos( $class, 'TTTLoadmore_' ) )
        return;
    
    $file = TTTINC_LOADMORE . '/class/' . $class . '.php';
    if (is_file($file)) {
        require_once $file;
        return true;
    }
    
    throw new Exception("Unable to load $class at ".$file);
}

if ( function_exists( 'spl_autoload_register' ) ) {
    spl_autoload_register( 'ttt_autoload_loadmore' );
} else {
    require_once TTTINC_LOADMORE . '/class/TTTLoadmore_Common.php';
}

function tttloadmore_init () {
    $s = load_plugin_textdomain( 'tttloadmore', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
    if ( !is_admin() ) {
        global $TTTLoadmore_Front;
        $TTTLoadmore_Front = new TTTLoadmore_Front();
        $TTTLoadmore_Front->init();
    }
    else {
        $TTTLoadmore_Admin = new TTTLoadmore_Admin();
        $TTTLoadmore_Admin->init();
    }
}

add_action('init', 'tttloadmore_init', 10);

register_activation_hook( __FILE__, array( 'TTTLoadmore_Admin', 'on_activation' ) );

