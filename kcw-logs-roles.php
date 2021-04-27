<?php

include_once "wp-user-helpers.php";
include_once "kcw-logs-staff.php";

function kcw_log_get_user_roles() {
    global $kcw_logs_default_staff;
    return $kcw_logs_default_staff;
}

//Get the current users privilege
function kcw_logs_wp_current_privilege() {
    //Must be: Admin or Editor AND keymaster or moderator of the site
    //I.E. Both a trusted forum member and KCW  => being paid, but must also be on the list
    if ((kcw_logs_wp_current_is_admin() || kcw_logs_wp_current_is_editor())
     && (kcw_logs_current_is_keymaster() || kcw_logs_current_is_moderator())){
        //Name must be white listed
        global $kcw_logs_default_staff;
        $cemail = kcw_logs_wp_current_user_email();
        foreach ($kcw_logs_default_staff as $ename=>$eval) {
            //On the list
            if ($ename == $cemail) return $eval;
        }

    }
    //Not on the list
    return "none";
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
    return $priv == "shop-manager" || kcw_logs_current_can_manage_all();
}
//Owner
function kcw_logs_current_can_manage_all() {
    $priv = kcw_logs_wp_current_privilege();
    return $priv == "owner" || $priv == "web-developer";
}

?>