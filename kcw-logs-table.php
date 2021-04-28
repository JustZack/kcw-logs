<?php 
function kcw_logs_install_tables() {
    global $kcw_logs_db_table_data;
    foreach ($kcw_logs_db_table_data as $name=>$data) {
        //skip tables that already exist
        if (kcw_logs_wpdb_util_table_exists($name)) continue;
        //Create the table
        else kcw_logs_wpdb_utils_create_table($name, $data);
    }
}

function kcw_logs_uninstall_tables() {
    global $kcw_logs_db_table_data;
    foreach ($kcw_logs_db_table_data as $name=>$data) {
        //skip tables that already exist
        if (kcw_logs_wpdb_util_table_exists($name)) {
            kcw_logs_wpdb_utils_drop_table($name);
        }
    }
}

function kcw_logs_any_tables_missing() {
    global $kcw_logs_db_table_data;
    foreach ($kcw_logs_db_table_data as $name=>$data) {
        //If any one table doesnt exist then this check fails
        if (kcw_logs_wpdb_util_table_exists($name)) continue;
        else return true;
    }
    
    return false;
}

        $kcw_logs_db_table_data = array(
        "logs_project"=>[
            0=>kcw_logs_wpdb_utils_create_column("projectid","int(6)", true, true),
            1=>kcw_logs_wpdb_utils_create_column("start","int(10)"),
            2=>kcw_logs_wpdb_utils_create_column("end","int(10)", false),
            3=>kcw_logs_wpdb_utils_create_column("name","varchar(255)"),
            4=>kcw_logs_wpdb_utils_create_column("description","varchar(255)"),
            5=>kcw_logs_wpdb_utils_create_column("customerid","varchar(15)"),
            6=>kcw_logs_wpdb_utils_create_column("statusid","varchar(15)")
        ],
        "logs_customer"=>[
            0=>kcw_logs_wpdb_utils_create_column("customerid","int(6)", true, true),
            1=>kcw_logs_wpdb_utils_create_column("created_date","int(10)"),
            2=>kcw_logs_wpdb_utils_create_column("name","varchar(100)"),
            3=>kcw_logs_wpdb_utils_create_column("phone","varchar(25)"),
            4=>kcw_logs_wpdb_utils_create_column("email","varchar(100)"),
            5=>kcw_logs_wpdb_utils_create_column("address","varchar(255)")
        ],
        "logs_tasks"=>[
            0=>kcw_logs_wpdb_utils_create_column("taskid","int(6)"), true, true,
            1=>kcw_logs_wpdb_utils_create_column("projectid","int(6)"),
            2=>kcw_logs_wpdb_utils_create_column("staffid","int(6)"),
            3=>kcw_logs_wpdb_utils_create_column("description","varchar(255)"),
            4=>kcw_logs_wpdb_utils_create_column("hours","decimal(3, 3)"),
            5=>kcw_logs_wpdb_utils_create_column("performed","int(10)"),
            6=>kcw_logs_wpdb_utils_create_column("submited","int(10)")
        ],
        "logs_staff"=>[
            0=>kcw_logs_wpdb_utils_create_column("staffid","int(6)", true, true),
            1=>kcw_logs_wpdb_utils_create_column("created","int(10)"),
            2=>kcw_logs_wpdb_utils_create_column("name","varchar(100)"),
            3=>kcw_logs_wpdb_utils_create_column("email","varchar(100)"),
            4=>kcw_logs_wpdb_utils_create_column("role","varchar(20)"),
            5=>kcw_logs_wpdb_utils_create_column("wp_user","bigint(20)")
        ],
        "logs_expenses"=>[
            0=>kcw_logs_wpdb_utils_create_column("expenseid","int(6)", true, true),
            1=>kcw_logs_wpdb_utils_create_column("projectid","int(6)"),
            2=>kcw_logs_wpdb_utils_create_column("staffid","int(6)"),
            3=>kcw_logs_wpdb_utils_create_column("added","int(10)"),
            4=>kcw_logs_wpdb_utils_create_column("description","varchar(255)"),
            5=>kcw_logs_wpdb_utils_create_column("cost","decimal(6, 3)")

        ],
        "logs_sessions"=>[
            0=>kcw_logs_wpdb_utils_create_column("sessionid","int(6)", true, true),
            1=>kcw_logs_wpdb_utils_create_column("staffid","int(6)"),
            2=>kcw_logs_wpdb_utils_create_column("created","int(10)"),
            3=>kcw_logs_wpdb_utils_create_column("expires","int(10)"),
            4=>kcw_logs_wpdb_utils_create_column("token","varchar(50)")
        ],
        "logs_status"=>[
            0=>kcw_logs_wpdb_utils_create_column("statusid","int(6)", true, true),
            1=>kcw_logs_wpdb_utils_create_column("name","varchar(50)"),
            2=>kcw_logs_wpdb_utils_create_column("description","varchar(255)")
        ]
    );
?>