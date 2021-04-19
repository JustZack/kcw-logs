<?php

function kcw_logs_wp_current_user_email() {
    return ((array) (wp_get_current_user()->user_email))[0];
}

function kcw_logs_wp_current_user_roles() {
    return (array) (wp_get_current_user()->roles);
}

function kcw_logs_wp_parse_user_roles($roles) {
    $data = array();
    $data["wp"] = $roles[0];
    $data["bbp"] = $roles[1];
    return $data;
}

function kcw_logs_wp_get_current_user_roles() {
    $roles = kcw_logs_wp_current_user_roles();
    $roles = kcw_logs_wp_parse_user_roles($roles);
    return $roles;
}

function kcw_logs_wp_is_admin($roles) {
    return $roles["wp"] == "administrator";
}

function kcw_logs_wp_is_editor($roles) {
    return $roles["wp"] == "editor";
}
function kcw_logs_wp_is_bbp_keymaster($roles) {
    return $roles["bbp"] = "bbp_keymaster";
}
function kcw_logs_wp_is_bbp_moderator($roles) {
    return $roles["bbp"] = "bbp_moderator";
}

function kcw_logs_wp_current_is_admin() {
    $roles = kcw_logs_wp_get_current_user_roles();
    return kcw_logs_wp_is_admin($roles);
}
function kcw_logs_wp_current_is_editor() {
    $roles = kcw_logs_wp_get_current_user_roles();
    return kcw_logs_wp_is_editor($roles);
}
function kcw_logs_current_is_keymaster() {
    $roles = kcw_logs_wp_get_current_user_roles();
    return kcw_logs_wp_is_bbp_keymaster($roles);
}
function kcw_logs_current_is_moderator() {
    $roles = kcw_logs_wp_get_current_user_roles();
    return kcw_logs_wp_is_bbp_moderator($roles);
}

function kcw_logs_wp_current_privilege() {
    //Must be: Admin or Editor AND keymaster or moderator of the site
    //I.E. Both a trusted forum member and KCW  => being paid, but must also be on the list
    if ((kcw_logs_wp_current_is_admin() || kcw_logs_wp_current_is_editor())
     && (kcw_logs_current_is_keymaster() || kcw_logs_current_is_moderator())){
        //Name must be white listed
        global $staff;
        kcw_logs_wp_current_user_email();
        foreach ($staff as $ename=>$eval) {
            //On the list
            if ($ename == kcw_logs_wp_current_user_email()) return $eval;
        }

    }
    //Not on the list
    return false;
}
function kcw_logs_wp_current_is_priviledged() {
    $priv = kcw_logs_wp_current_privilege();
    if ($priv) {
        return true;
    } else {
        return false;
    }
}


?>