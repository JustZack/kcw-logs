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

function kcw_log_employee_permissions() {
    
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