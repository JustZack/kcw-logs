<?php

include_once "wp-user-helpers.php";
include_once "kcw-logs-staff.php";

/*
function kcw_log_employee_wp_level($role) {
    switch($role) {
        case "subscriber":
        case "contributor":
        case "author": return 5;
        case "editor":
        case "administrator": return 10;
        default: return 1;
    }
}

function kcw_log_employee_bbp_level($role) {
    switch($role) {
        case "bbp_blocked": return 0;
        case "bbp_subscriber":
        case "bbp_participant": return 5;
        case "bbp_moderator":
        case "bbp_keymaster": return 10;
        default: return 1;
    }
}*/

function kcw_log_get_user_roles() {
    global $staff;
    return $staff;
}

//Get the current users privilege
function kcw_logs_wp_current_privilege() {
    //Must be: Admin or Editor AND keymaster or moderator of the site
    //I.E. Both a trusted forum member and KCW  => being paid, but must also be on the list
    if ((kcw_logs_wp_current_is_admin() || kcw_logs_wp_current_is_editor())
     && (kcw_logs_current_is_keymaster() || kcw_logs_current_is_moderator())){
        //Name must be white listed
        global $staff;
        $cemail = kcw_logs_wp_current_user_email();
        foreach ($staff as $ename=>$eval) {
            //On the list
            if ($ename == $cemail) return $eval;
        }

    }
    //Not on the list
    return false;
}
//Check if the current user can use kcw logs
function kcw_logs_wp_current_is_priviledged() {
    $priv = kcw_logs_wp_current_privilege();
    if ($priv) {
        return true;
    } else {
        return false;
    }
}

//Employee
function kcw_logs_current_can_manage_own() {
    $priv = kcw_logs_wp_current_privilege();
    return $priv != false;
}
//Manager
function kcw_logs_current_can_manage_shop() {
    $priv = kcw_logs_wp_current_privilege();
    return $priv == "shop-manager" || $priv == "owner";
}
//Owner
function kcw_logs_current_can_manage_all() {
    $priv = kcw_logs_wp_current_privilege();
    return $priv == "owner";
}

?>