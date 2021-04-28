<?php

include_once "kcw-logs-rest-routes.php";
include_once "kcw-logs-api-helpers.php";

$kcw_logs_api_url = home_url('wp-json/' . $kcw_logs_api_namespace . '/v1/');

//Return a list of timesheets
function kcw_logs_api_list_Timesheets($data) {
    $allowed = kcw_logs_api_validate_request_data($data, "list-timesheets");
    return $allowed;
}
//Return a list of projects
function kcw_logs_api_list_Projects($data) {
    $allowed = kcw_logs_api_validate_request_data($data, "list-projects");
    return $allowed;
}
//Return a list of staff
function kcw_logs_api_list_Staff($data) {
    $allowed = kcw_logs_api_validate_request_data($data, "list-staff");
    return $allowed;
}
//Return a list of customers
function kcw_logs_api_list_Customers($data) {
    $allowed = kcw_logs_api_validate_request_data($data, "list-customers");
    return $allowed;
}

?>