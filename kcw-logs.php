<?php
/*
* Plugin Name:       KCW Logs
* Description:       Provide a virtual means of inputing work information
* Version:           1..0.0
* Requires at least: 5.2
* Requires PHP:      7.2
* Author:            Zack Jones
*/

include_once "kcw-logs-roles.php";
include_once "wpdb-util.php";
include_once "kcw-logs-table.php";

function  kcw_logs_register__dependencies() {
    wp_register_style("kcw-logs.main", plugins_url("kcw-gallery.css", __FILE__), array(), "1.0.0");
    
    wp_register_script("google-apis", "https://apis.google.com/js/api.js", array(), "1.0.0");
    wp_register_script("kcw-logs", plugins_url("kcw-logs.js", __FILE__), array('google-apis'), "1.0.0");
    wp_register_script("kcw-logs.jquery", plugins_url("kcw-logs.jquery.js", __FILE__), array('google-apis', 'jquery', 'kcw-logs'), "1.0.0");
}
add_action("wp_enqueue_scripts", "kcw_logs_register__dependencies");

function kcw_logs_enqueue_dependencies() {
    wp_enqueue_style("kcw-logs.main");
    wp_enqueue_script("google-apis");
    wp_enqueue_script("kcw-logs");
    wp_enqueue_script("kcw-logs.jquery");
}


function kcw_logs_install() {

    global $kcw_logs_db_tables;
    global $kcw_logs_db_columns;
    for ($i = 0;$i < count($kcw_logs_db_tables);$i++) {
        kcw_logs_wpdb_utils_create_table($kcw_logs_db_tables[$i], $kcw_logs_db_columns[$i]);
    }
}
register_activation_hook( __FILE__, "kcw_logs_install" );
function kcw_logs_manager_init() {
    //Engueue nessesary stuff
    kcw_logs_enqueue_dependencies();

}

add_shortcode("kcw-logs-manager", "kcw_logs_manager_init");
?>