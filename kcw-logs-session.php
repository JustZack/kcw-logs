<?php

include_once "kcw-logs-wpdb-util.php";
include_once "wp-user-helpers.php";

function kcw_logs_build_session($staffid) {
    $session = array();

    $session["staffid"] = $staffid;
    $session["created"] = time();
    $session["expires"] = time() + (1 * 60 * 60);
    $session["token"] = substr(wp_get_session_token(), 5, 10);

    return $session;
}

//Returns the session
function kcw_logs_get_session($token) {
    $session = kcw_logs_wpdb_util_get_row("logs_sessions", "token = '$token'");
    if (count($session) == 0) return false;
    else return $session;
}

//Build and add a session to the database, returns the session token
function kcw_logs_add_session($staffid) {
    $session == kcw_logs_build_session($staffid);//Generate the session data
    return kcw_logs_wpdb_util_insert_row("logs_sessions", $session);
}

//Check if the given session is valid
function kcw_logs_is_session_valid($token, $staffid) {
    //First get the row for this given session
    $session = kcw_logs_wpdb_util_get_row("logs_sessions", ["token = '$token'", "staffid = '$staffid'"]);
    //Check if the session has expired (or exists)
    return $session["expires"] < time();
}

//Iterate over every session and check if any are expired
function kcw_logs_delete_expired_sessions() {
    //Get all expired sessions
    $sessions = kcw_logs_wpdb_util_get_row("logs_sessions", "expires < '".time()."'");
    //Delete expired sessions
    foreach ($sessions as $session)
        kcw_logs_wpdb_util_delete_row("logs_sessions", $session["sessionid"]);

    return true;
}

?>