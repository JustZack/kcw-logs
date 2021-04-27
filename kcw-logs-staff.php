<?php

include_once "kcw-logs-wpdb-util.php";

/*$roleid = 0 -> 3
      0 = owner
      1 = shop-manager
      2 = shop-employee
      3 = gjaz-employee
      4 = web-developer
*/
function kcw_logs_build_staff($role_id, $full_name) {
    $data = array();
    $role = "";
    switch($role_id) {
        case 0: $role = "owner"; break;
        case 1: $role = "shop-manager"; break;
        case 2: $role = "shop-employee"; break;
        case 3: $role = "gjaz-employee"; break;
        case 4: $role = "web-developer"; break;
        default: $role = -1; break;
    }
    $data["role"] = $role;
    $data["name"] = $full_name;
    return $data;
}

$kcw_logs_default_staff = array(//Mapping relevent usernames to known roles
    "John@kustomcoachwerks.com" => kcw_logs_build_staff(0, "John Jones"),
    "gretchkcw@gmail.com" => kcw_logs_build_staff(0, "Gretchen Jones"),
    "Franzmuhr@gmail.com" => kcw_logs_build_staff(1, "Franz Muhr"),
    "rkendallp@gmail.com" => kcw_logs_build_staff(2, "Pat Kendall"),
    "audrey@kustomcoachwerks.com" => kcw_logs_build_staff(3, "Audrey Jones"),
    "zack@kustomcoachwerks.com" => kcw_logs_build_staff(4, "Zack Jones"), 
    "justzackj@gmail.com" => kcw_logs_build_staff(4, "Zack Jones")
);



function kcw_logs_any_staff_missing() {
    global $kcw_logs_default_staff;
    $db_staff = kcw_logs_wpdb_util_get_row("logs_staff");
    //Same number of staff, possibly different people
    if (count($db_staff) == count($kcw_logs_default_staff)) {
        foreach($db_staff as $dbs) {
            foreach($kcw_logs_default_staff as $kcws) {
                var_dump("TODO");
            }
            return true;
        }
    }
    //Different number of staff, definately missing (or have too many) staff
    else {
        return true;
    }
}

function kcw_logs_current_user_is_staff() {
    $email = kcw_logs_wp_current_user_email();
    $staff_row = kcw_logs_wpdb_util_get_row("logs_staff", "email = '$email'", "*");

    //If a row in the database doesnt exist, it may have not even been added yet.
    if (count($staff_row) == 0) {
        //Check if this user is in the staff object
        global $kcw_logs_default_staff;
        foreach ($kcw_logs_default_staff as $kcw_email=>$data) {
            if ($email == $kcw_email) return true;
        }
    } else {
        //Check if this user exists in the db table
        if ($email == $staff_row["email"]) return true;
    }

    return false;
}


function kcw_logs_insert_staff($staff_email, $staff_data) {
    //Get the WP user for this person
    $wp_user = kcw_logs_wpdb_util_get_row("users", "user_email = '$staff_email'", "*");

    //Structure for the staff row
    //staffid, created, name, phone, email, wp_user
    $staff_member = array();
    $staff_member["staffid"] = "increment";
    $staff_member["created"] =  strtotime($wp_user["user_registered"]);
    $staff_member["name"] = $staff_data["name"];
    $staff_member["email"] = $wp_user["user_email"];;
    $staff_member["role"] = -$staff_data["role"];
    $staff_member["wp_user_id"] = $wp_user["ID"];

    var_dump($wp_user);
    var_dump($staff_member);

    kcw_logs_wpdb_util_insert_row("logs_staff", $staff_member);
}

function kcw_logs_insert_default_staff() {
    global $kcw_logs_default_staff;

    //Ensure all default staff exist in the database
    foreach ($kcw_logs_default_staff as $kcw_user=>$data) {
        //See if this user exists in the wordpress table
        $logs_user = kcw_logs_wpdb_util_get_row("logs_staff", "email = '$kcw_user'");
        //No user in the database
        if (count($logs_user) == 0) {
            kcw_logs_insert_staff($kcw_user, $data);
        } else {
            //User exists in the database, skip
            continue;
        }
    }
}


?>