<?php

include_once "kcw-logs-wpdb-util.php";
include_once "wp-user-helpers.php";

function kcw_logs_build_session($staffid) {
    $session = array();

    //$session["sessionid"] = 0;
    $session["staffid"] = $staffid;
    $session["created"] = time();
    //Session is valid for 60 minutes
    $session["expires"] = time() + (60 * 60);
    $session["token"] = substr(wp_get_session_token(), 0, 50);

    return $session;
}

function kcw_logs_get_session($conditions) {
    $conditions[] = "expires > '".time()."'";
    $sessions = kcw_logs_wpdb_util_get_row("logs_sessions", $conditions);
    if (count($sessions) == 0) {
        return false;
    } else {
        $current = $sessions[0];
        //Get the most recently created session
        foreach ($sessions as $session) 
            if ($session["created"] > $current["created"]) 
                $current = $session;

                return $current;
    }
}

//Returns the session for the given staff member
function kcw_logs_get_staff_session($staffid) {
    return kcw_logs_get_session(["staffid = '$staffid'"]);
}

//Build and add a session to the database, returns the session token
function kcw_logs_start_session($staffid) {
    $session = kcw_logs_build_session($staffid);//Generate the session data
    kcw_logs_wpdb_util_insert_row("logs_sessions", $session);
    return kcw_logs_get_staff_session($staffid);
}

function kcw_logs_extend_session($staffid, $hours) {
    $session = kcw_logs_get_staff_session($staffid);

    $row = array();
    //Extend the session by $hours hours.
    $row["expires"] = time() + (60 * 60 * $hours);
    $conditions = array("token = '{$session["token"]}'", 
                        "created = '{$session["created"]}'",
                        "staffid = '$staffid'");
    //Update the row
    kcw_logs_wpdb_util_update_row("logs_sessions", $row, $conditions);
    //Return the updated session
    return kcw_logs_get_staff_session($staffid);
}

//Check if the given session is valid
function kcw_logs_is_session_valid($token, $staffid = -1) {
    $where = array("token = '$token'");
    if ($staffid > 0) $where[] = "staffid = '$staffid'";
    //First get the row for this given session
    $sessions = kcw_logs_wpdb_util_get_row("logs_sessions", $where);

    if (count($sessions) == 0) {
        return false;
    } else {
        $newest = 0; $newest_expires = 0;
        foreach ($sessions as $session) {
            if ($session["created"] > $newest)  {
                $newest = $session["created"];
                $newest_expires = $session["expires"];
            }
        }

        return $newest_expires > time();
    }
}

function kcw_logs_get_num_expired_sessions() {
    return count(kcw_logs_wpdb_util_get_row("logs_sessions", "expires < '".time()."'"));
}

//Iterate over every session and check if any are expired
function kcw_logs_delete_expired_sessions() {
    //Get all expired sessions
    $sessions = kcw_logs_wpdb_util_get_row("logs_sessions", "expires < '".time()."'");

    //Delete expired sessions
    foreach ($sessions as $session)
        kcw_logs_wpdb_util_delete_row("logs_sessions", "sessionid = '{$session['sessionid']}'");

    return true;
}

function kcw_logs_get_staffid_for_session($token) {
    $session = kcw_logs_get_session(["token = '$token'"]);
    return $session["staffid"];
}

?>