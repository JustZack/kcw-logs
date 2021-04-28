<?php

include_once "kcw-logs-session.php";

//Return a generic response
function kcw_logs_api_generic_return($data, $status) {
    $data["status"] = $status;
    $data["time"] = time();
    return $data;
}
//Return a generic success response
function kcw_logs_api_success($data) {
    return kcw_logs_api_generic_return($data, "Success");
}
//Return a generic error response
function kcw_logs_api_error($msg) {
    $data = array();
    $data["message"] = $msg;
    return kcw_logs_api_generic_return($data, "Error");
}
//Return an invalid session response
function kcw_logs_api_error_invalid_session($token) {
    return kcw_logs_api_error("Invalid Session Token: '$token'");
}
//Extend the life of the given session by the number of hours past the current time
function kcw_logs_api_extend_session($token, $hours = 2) {
    $staffid = kcw_logs_get_staffid_for_session($token);
    $session = kcw_logs_renew_session($staffid, $hours);
    return $session;
}
//Ensure the session is valid and continues being valid while being used
function kcw_logs_api_validate_session($token) {
    $valid = kcw_logs_is_session_valid($token);
    //If valid, extend the session and return true
    if ($valid) {
        kcw_logs_api_extend_session($token);
        return true;
    } else {
        return false;
    }
}
//Ensure the given token is allowed to perform the given action
function kcw_logs_api_validate_action($token, $action) {
    $staffid = kcw_logs_get_staffid_for_session($token);
    $staff_row = kcw_logs_wpdb_util_get_row("logs_staff", "staffid = '$staffid'");
    $role = $staff_row["role"];

    //Ensure the given role can perform the given action...
    return true;
}
//Ensure the given token is valid and can perform the given action
function kcw_logs_api_validate_request($token, $action) {
    $valid_session = kcw_logs_api_validate_session($token);
    if ($valid_session) {
        $valid_action = kcw_logs_api_validate_action($token, $action);
        if ($valid_action) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function kcw_logs_api_validate_request_data($data, $action) {
    $token = $data["token"];
    $allowed = kcw_logs_api_validate_request($token, $action);
    return $allowed;
}

?>