<?php

function kcw_logs_wp_current_user_roles() {
    return (array) (wp_get_current_user()-> roles);
}

function kcw_logs_wp_parse_user_roles($roles) {
    $data = array();
    $data["wp"] = $roles[0];
    $data["bbp"] = $roles[1];
    return $data;
}

?>