<?php

include_once "kcw-logs-wpdb-util.php";
include_once "wp-user-helpers.php";

function kcw_logs_build_session() {
    $session = array();
    $tok = wp_get_session_token();
    $session["id"] = $tok;
    $session["email"] = kcw_logs_wp_current_user_email();
    $session["expires"] = ($tok?time() + (1 * 60 * 60):-1);

    return $session;
}

function kcw_logs_register_current_session($session) {
    
}

function kcw_logs_get_session($token) {
    $session = kcw_logs_wpdb_util_get_row("logs_sessions", "token = '$token'");
    //Get existing?
    //$session["exists"] = $match;
    return $session;
}

function kcw_logs_add_session($session) {
    $values = array();
    //kcw_logs_wpdb_util_data_type_pair();
    $session = kcw_logs_wpdb_util_insert_row("logs_sessions", );
    var_dump($session);
}

?>