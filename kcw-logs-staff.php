<?php

/*$roleid = 0 -> 3
      0 = owner
      1 = shop-manager
      2 = shop-employee
      3 = gjaz-employee
*/
function kcw_logs_build_staff($role_id) {
    $data = array();
    $role = "";
    switch($role_id) {
        case 0: $role = "owner"; break;
        case 1: $role = "shop-manager"; break;
        case 2: $role = "shop-employee"; break;
        default: $role = -1; break;
    }
    $data["role"] = $role;
    return $data;
}

$staff = array(//Mapping relevent usernames to known roles
    "john" => kcw_logs_build_staff(0),
    "gretchen" => kcw_logs_build_staff(0),
    "franz" => kcw_logs_build_staff(1),
    "pat" => kcw_logs_build_staff(2),
    "audrey" => kcw_logs_build_staff(2),
    "zack" => kcw_logs_build_staff(2)
);

?>