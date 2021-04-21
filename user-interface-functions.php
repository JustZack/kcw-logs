<?php
include_once "kcw-logs-roles.php";

function kcw_logs_build_main_list_item_button_data($name, $action) {
    return array("name"=>"$name","action"=>"$action");
}

//Short hand for adding button to array with propper format
function kcw_logs_interface_append_button($name, $action) {
    return kcw_logs_build_main_list_item_button_data($name, $action);
}

function kcw_logs_add_basic_buttons($buttons) {
    $buttons[] = kcw_logs_interface_append_button("my-logs", "//");
    $buttons[] = kcw_logs_interface_append_button("projects", "//");
    $buttons[] = kcw_logs_interface_append_button("customers", "//"); 
    return $buttons;
}

function kcw_logs_add_manage_buttons($buttons) {
    $buttons[] = kcw_logs_interface_append_button("shop-logs", "//");
    $buttons[] = kcw_logs_interface_append_button("project-reports", "//"); 
    return $buttons;
}

function kcw_logs_determine_interface_buttons() {
    $buttons = array();

    if (kcw_logs_wp_current_is_priviledged()) {
        if (kcw_logs_current_can_manage_own()) $buttons = kcw_logs_add_basic_buttons($buttons);
        if (kcw_logs_current_can_manage_shop()) $buttons = kcw_logs_add_manage_buttons($buttons);
        if (kcw_logs_current_can_manage_all()) $buttons[] = kcw_logs_interface_append_button("manage-staff", "//");
    }

    return $buttons;
}
?>