<?php

$kcw_logs_api_namespace = "kcwlogs";
//Allow WP Token format (alphanumber)
$kcw_logs_auth_token_rest_format = "(?P<token>[a-zA-Z0-9]+)";
//Allow only numbers
$kcw_logs_limit_rest_format = "(?P<limit>[0-9]?)";
//Allow alphanumberic and a DOT or DASH
$kcw_logs_search_rest_format = "(?P<search>[a-zA-Z0-9-\.]+)";


function kcw_logs_api_RegisterTimesheetRoutes() {
    global $kcw_logs_api_namespace;
    global $kcw_logs_auth_token_rest_format;
    global $kcw_logs_search_rest_format;
    $token = $kcw_logs_auth_token_rest_format;
    $search_str = $kcw_logs_search_rest_format;
    
    //Route for listing the current users timesheets
    //Returns auth error if the token cant view timesheets
    register_rest_route( "$kcw_logs_api_namespace/v1", "/$token/timesheets", array(
        'methods' => 'GET',
        'callback' => 'kcw_logs_api_list_Timesheets',
    ));

    //Route for search all timesheets owned by the current user
    //Retuns any timesheets visible to the current user, including their own
    register_rest_route( "$kcw_logs_api_namespace/v1", "/$token/timesheets/search/$search_str", array(
        'methods' => 'GET',
        'callback' => 'kcw_logs_api_search_Timesheets',
    ));

    //Route for listing all timesheets visible to the given user
    //Retuns any timesheets visible to the current user, including their own
    register_rest_route( "$kcw_logs_api_namespace/v1", "/$token/timesheets/all", array(
        'methods' => 'GET',
        'callback' => 'kcw_logs_',
    ));

    //Route for search through all timesheets visible to the given user
    //Retuns any timesheets visible to the current user, including their own
    register_rest_route( "$kcw_logs_api_namespace/v1", "/$token/timesheets/all/search", array(
        'methods' => 'GET',
        'callback' => 'kcw_logs_',
    ));

    //Route for getting a timesheet based on the given timesheet id
    //If the given token isnt authenticated to view that timesheet, returns does not exist error
    register_rest_route( "$kcw_logs_api_namespace/v1", "/$token/timesheet/(?P<timesheetid>[0-9]+)", array(
        'methods' => 'GET',
        'callback' => 'kcw_logs_',
    ));

    //Route for creating a new timesheet
    //If the given token isnt authenticated to create this timesheet, returns auth error
    register_rest_route( "$kcw_logs_api_namespace/v1", "/$token/timesheet/create", array(
        'methods' => 'POST',
        'callback' => 'kcw_logs_',
    ));
}

function kcw_logs_api_RegisterProjectRoutes() {
    global $kcw_logs_api_namespace;
    global $kcw_logs_auth_token_rest_format;
    global $kcw_logs_search_rest_format;
    $token = $kcw_logs_auth_token_rest_format;
    $search_str = $kcw_logs_search_rest_format;
    
    //Route for listing all projects
    //If the given token isnt authenticated to view projects, returns auth error
    register_rest_route( "$kcw_logs_api_namespace/v1", "/$token/projects", array(
        'methods' => 'GET',
        'callback' => 'kcw_logs_api_list_Projects',
    ));

    //Route for searching through all the customers in the customers table (limited based on to_show)
    //If the given token isnt authenticated to view customers, returns auth error
    register_rest_route( "$kcw_logs_api_namespace/v1", "/$token/projects/search/$search_str", array(
        'methods' => 'GET',
        'callback' => 'kcw_logs_api_search_Projects',
    ));

    //Route for getting a project based on the given project id
    //If the given token isnt authenticated to view that project, returns does not exist error
    register_rest_route( "$kcw_logs_api_namespace/v1", "/$token/project/(?P<projectid>[0-9]+)", array(
        'methods' => 'GET',
        'callback' => 'kcw_logs_',
    ));

    //Route for creating a project
    //If the given token isnt authenticated to create this project, returns auth error
    register_rest_route( "$kcw_logs_api_namespace/v1", "/$token/project/create", array(
        'methods' => 'POST',
        'callback' => 'kcw_logs_',
    ));
}

function kcw_logs_api_RegisterStaffRoutes() {
    global $kcw_logs_api_namespace;
    global $kcw_logs_auth_token_rest_format;
    global $kcw_logs_search_rest_format;
    $token = $kcw_logs_auth_token_rest_format;
    $search_str = $kcw_logs_search_rest_format;
    
    //Route for listing all staff
    //If the given token isnt authenticated to view staff, returns auth error
    register_rest_route( "$kcw_logs_api_namespace/v1", "/$token/staff", array(
        'methods' => 'GET',
        'callback' => 'kcw_logs_api_list_Staff',
    ));

    //Route for getting a staff member based on the given staff id
    //If the given token isnt authenticated to view staff members, returns does not exist error
    register_rest_route( "$kcw_logs_api_namespace/v1", "/$token/staff/(?P<staffid>[0-9]+)", array(
        'methods' => 'GET',
        'callback' => 'kcw_logs_',
    ));

    //Route for creating a staff member
    //If the given token isnt authenticated to create this project, returns auth error
    register_rest_route( "$kcw_logs_api_namespace/v1", "/$token/staff/create", array(
        'methods' => 'POST',
        'callback' => 'kcw_logs_',
    ));
}

function kcw_logs_api_RegisterCustomerRoutes() {
    global $kcw_logs_api_namespace;
    global $kcw_logs_auth_token_rest_format;
    global $kcw_logs_search_rest_format;
    $token = $kcw_logs_auth_token_rest_format;
    $search_str = $kcw_logs_search_rest_format;
    
    //Route for listing all customers
    //If the given token isnt authenticated to view customers, returns auth error
    register_rest_route( "$kcw_logs_api_namespace/v1", "/$token/customers", array(
        'methods' => 'GET',
        'callback' => 'kcw_logs_api_list_Customers',
    ));

    //Route for searching through all the customers in the customers table (limited based on to_show)
    //If the given token isnt authenticated to view customers, returns auth error
    register_rest_route( "$kcw_logs_api_namespace/v1", "/$token/customers/search/$search_str", array(
        'methods' => 'GET',
        'callback' => 'kcw_logs_api_search_Customers',
    ));

    //Route for getting a customer based on the given customer id
    //If the given token isnt authenticated to view customer, returns does not exist error
    register_rest_route( "$kcw_logs_api_namespace/v1", "/$token/customer/(?P<customerid>[0-9]+)", array(
        'methods' => 'GET',
        'callback' => 'kcw_logs_',
    ));

    //Route for creating a customer
    //If the given token isnt authenticated to create this customer, returns auth error
    register_rest_route( "$kcw_logs_api_namespace/v1", "/$token/customer/create", array(
        'methods' => 'POST',
        'callback' => 'kcw_logs_',
    ));
}

function kcw_logs_api_RegisterRestRoutes() {
    kcw_logs_api_RegisterTimesheetRoutes();
    kcw_logs_api_RegisterProjectRoutes();
    kcw_logs_api_RegisterStaffRoutes();
    kcw_logs_api_RegisterCustomerRoutes();

}

add_action( 'rest_api_init', "kcw_logs_api_RegisterRestRoutes");

?>