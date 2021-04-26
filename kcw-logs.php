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
include_once "kcw-logs-wpdb-util.php";
include_once "kcw-logs-staff.php";
include_once "kcw-logs-table.php";
include_once "user-interface-functions.php";
include_once "kcw-logs-session.php";

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

function kcw_logs_manager_init() {
    //If current user is staff, show them the log interface
    if (kcw_logs_current_user_is_staff()) {
        //If any tables are missing, create them
        if (kcw_logs_any_tables_missing()) kcw_logs_install_tables();
        
        ///If any of the default staff are missing in the database, add them
        if (kcw_logs_any_staff_missing()) kcw_logs_insert_default_staff();

        var_dump("staff");

        if (false/*kcw_logs_current_session_exists*/); //Use the session
        else; //Build, store, and use the session

        //var_dump(kcw_logs_build_session());
        //kcw_logs_determine_interface_buttons();
        //Engueue nessesary stuff
        kcw_logs_enqueue_dependencies();
    } 
    //Else redirect to home page, this is a normal / logged out user
    else {
        
    }

}

add_shortcode("kcw-logs-manager", "kcw_logs_manager_init");
?>