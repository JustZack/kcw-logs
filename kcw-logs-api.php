<?php

include_once "kcw-logs-rest-routes.php";
include_once "kcw-logs-api-helpers.php";

$kcw_logs_api_url = home_url('wp-json/' . $kcw_logs_api_namespace . '/v1/');

//Return a list of timesheets owned by the given user
function kcw_logs_api_list_Timesheets($data) {
    $allowed = kcw_logs_api_validate_request_data($data, "list-timesheets");
    return $allowed;
}
//Return a list of timesheets owned by the given user
function kcw_logs_api_list_all_Timesheets($data) {
    $allowed = kcw_logs_api_validate_request_data($data, "list-all-timesheets");
    return $allowed;
}
//Return a list of timesheets matching the search string
function kcw_logs_api_search_Timesheets($data) {
    $allowed = kcw_logs_api_validate_request_data($data, "search-timesheets");
    return $data["search"];
}
//Return a list of timesheets matching the search string
function kcw_logs_api_search_all_Timesheets($data) {
    $allowed = kcw_logs_api_validate_request_data($data, "search-all-timesheets");
    return $data["search"];
}
//Return data for the given timesheet
function kcw_logs_api_get_Timesheet($data) {
    $allowed = kcw_logs_api_validate_request_data($data, "get-timesheets");
    return $data["id"];
}

//Return a list of projects
function kcw_logs_api_list_Projects($data) {
    $allowed = kcw_logs_api_validate_request_data($data, "list-projects");
    return $allowed;
}
//Return a list of projects matching the search string
function kcw_logs_api_search_Projects($data) {
    $allowed = kcw_logs_api_validate_request_data($data, "search-projects");
    return $data["search"];
}
//Return data for the given project
function kcw_logs_api_get_Project($data) {
    $allowed = kcw_logs_api_validate_request_data($data, "get-projects");
    return $data["id"];
}

//Return a list of staff
function kcw_logs_api_list_Staff($data) {
    $allowed = kcw_logs_api_validate_request_data($data, "list-staff");
    return $allowed;
}
//Return data for the given project
function kcw_logs_api_get_Staff($data) {
    $allowed = kcw_logs_api_validate_request_data($data, "get-staff");
    return $data["id"];
}

//Return a list of customers
function kcw_logs_api_list_Customers($data) {
    $allowed = kcw_logs_api_validate_request_data($data, "list-customers");
    return $allowed;
}
//Return a list of customers matching the search string
function kcw_logs_api_search_Customers($data) {
    $allowed = kcw_logs_api_validate_request_data($data, "search-customers");
    return $data["search"];
}
//Return data for the given project
function kcw_logs_api_get_Customer($data) {
    $allowed = kcw_logs_api_validate_request_data($data, "get-projects");
    return $data["id"];
}

?>