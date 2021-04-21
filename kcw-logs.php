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
    $tables = ["logs_project", "logs_customer", "logs_tasks", "logs_staff", "logs_expenses", "logs_sessions", "logs_status"];
    $columns = 
        [
            [
                0=>[kcw_logs_wpdb_utils_create_column("projectid","varchar(15)")],
                1=>[kcw_logs_wpdb_utils_create_column("start_date","datetime")],
                2=>[kcw_logs_wpdb_utils_create_column("end_date","datetime", false)],
                3=>[kcw_logs_wpdb_utils_create_column("name","varchar(255)")],
                4=>[kcw_logs_wpdb_utils_create_column("description","varchar(255)")],
                5=>[kcw_logs_wpdb_utils_create_column("customerid","varchar(15)")],
                6=>[kcw_logs_wpdb_utils_create_column("statusid","varchar(15)")]
            ],
            [
                0=>[kcw_logs_wpdb_utils_create_column("customerid","varchar(15)")],
                1=>[kcw_logs_wpdb_utils_create_column("created_date","datetime")],
                2=>[kcw_logs_wpdb_utils_create_column("name","varchar(100)")],
                3=>[kcw_logs_wpdb_utils_create_column("phone","varchar(25)")],
                4=>[kcw_logs_wpdb_utils_create_column("email","varchar(100)")],
                5=>[kcw_logs_wpdb_utils_create_column("address","varchar(255)")]
            ],
            [
                0=>[kcw_logs_wpdb_utils_create_column("taskid","varchar(15)")],
                1=>[kcw_logs_wpdb_utils_create_column("projectid","varchar(15)")],
                2=>[kcw_logs_wpdb_utils_create_column("staffid","varchar(15)")],
                3=>[kcw_logs_wpdb_utils_create_column("description","varchar(255)")],
                4=>[kcw_logs_wpdb_utils_create_column("hours","decimal(3, 3)")],
                5=>[kcw_logs_wpdb_utils_create_column("date_performed","datetime")],
                6=>[kcw_logs_wpdb_utils_create_column("date_submited","datetime")],
            ],
            [
                0=>[kcw_logs_wpdb_utils_create_column("staffid","varchar(15)")],
                1=>[kcw_logs_wpdb_utils_create_column("created_date","datetime")],
                2=>[kcw_logs_wpdb_utils_create_column("name","varchar(100)")],
                3=>[kcw_logs_wpdb_utils_create_column("phone","varchar(25)")],
                4=>[kcw_logs_wpdb_utils_create_column("email","varchar(100)")],
            ],
            [
                0=>[kcw_logs_wpdb_utils_create_column("expenseid","varchar(15)")],
                1=>[kcw_logs_wpdb_utils_create_column("projectid","varchar(255)")],
                2=>[kcw_logs_wpdb_utils_create_column("staffid","varchar(255)")],
                3=>[kcw_logs_wpdb_utils_create_column("added_date","datetime")],
                4=>[kcw_logs_wpdb_utils_create_column("description","varchar(255)")],
                5=>[kcw_logs_wpdb_utils_create_column("cost","decimal(6, 3)")],

            ],
            [
                0=>[kcw_logs_wpdb_utils_create_column("sessionid","varchar(15)")],
                1=>[kcw_logs_wpdb_utils_create_column("started_date","datetime")],
                2=>[kcw_logs_wpdb_utils_create_column("staffid","varchar(15)")],
            ],
            [
                0=>[kcw_logs_wpdb_utils_create_column("statusid","varchar(15)")],
                1=>[kcw_logs_wpdb_utils_create_column("name","varchar(50)")],
                2=>[kcw_logs_wpdb_utils_create_column("description","varchar(255)")],
            ],
        ];

    for ($i = 0;$i < count($tables);$i++) {
        kcw_logs_wpdb_utils_create_table($tables[$i], $columns[$i]);
    }
}
register_activation_hook( __FILE__, "kcw_logs_install" );
function kcw_logs_manager_init() {
    kcw_logs_install();
    //Engueue nessesary stuff
    kcw_logs_enqueue_dependencies();

}

add_shortcode("kcw-logs-manager", "kcw_logs_manager_init");
?>