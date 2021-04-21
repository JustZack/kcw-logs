<?php 

    $kcw_logs_db_tables = ["logs_project", "logs_customer", "logs_tasks", "logs_staff", "logs_expenses", "logs_sessions", "logs_status"];
    $kcw_logs_db_columns = 
        [
            [
                0=>[kcw_logs_wpdb_utils_create_column("projectid","varchar(15)")],
                1=>[kcw_logs_wpdb_utils_create_column("start_date","datetime")],
                2=>[kcw_logs_wpdb_utils_create_column("end_date","datetime", false)],
                3=>[kcw_logs_wpdb_utils_create_column("name","varchar(255)")],
                4=>[kcw_logs_wpdb_utils_create_column("description","varchar(255)")],
                5=>[kcw_logs_wpdb_utils_create_column("customerid","varchar(15)")],
                6=>[kcw_logs_wpdb_utils_create_column("statusid","varchar(15)")]
            ],
            [
                0=>[kcw_logs_wpdb_utils_create_column("customerid","varchar(15)")],
                1=>[kcw_logs_wpdb_utils_create_column("created_date","datetime")],
                2=>[kcw_logs_wpdb_utils_create_column("name","varchar(100)")],
                3=>[kcw_logs_wpdb_utils_create_column("phone","varchar(25)")],
                4=>[kcw_logs_wpdb_utils_create_column("email","varchar(100)")],
                5=>[kcw_logs_wpdb_utils_create_column("address","varchar(255)")]
            ],
            [
                0=>[kcw_logs_wpdb_utils_create_column("taskid","varchar(15)")],
                1=>[kcw_logs_wpdb_utils_create_column("projectid","varchar(15)")],
                2=>[kcw_logs_wpdb_utils_create_column("staffid","varchar(15)")],
                3=>[kcw_logs_wpdb_utils_create_column("description","varchar(255)")],
                4=>[kcw_logs_wpdb_utils_create_column("hours","decimal(3, 3)")],
                5=>[kcw_logs_wpdb_utils_create_column("date_performed","datetime")],
                6=>[kcw_logs_wpdb_utils_create_column("date_submited","datetime")],
            ],
            [
                0=>[kcw_logs_wpdb_utils_create_column("staffid","varchar(15)")],
                1=>[kcw_logs_wpdb_utils_create_column("created_date","datetime")],
                2=>[kcw_logs_wpdb_utils_create_column("name","varchar(100)")],
                3=>[kcw_logs_wpdb_utils_create_column("phone","varchar(25)")],
                4=>[kcw_logs_wpdb_utils_create_column("email","varchar(100)")],
            ],
            [
                0=>[kcw_logs_wpdb_utils_create_column("expenseid","varchar(15)")],
                1=>[kcw_logs_wpdb_utils_create_column("projectid","varchar(255)")],
                2=>[kcw_logs_wpdb_utils_create_column("staffid","varchar(255)")],
                3=>[kcw_logs_wpdb_utils_create_column("added_date","datetime")],
                4=>[kcw_logs_wpdb_utils_create_column("description","varchar(255)")],
                5=>[kcw_logs_wpdb_utils_create_column("cost","decimal(6, 3)")],

            ],
            [
                0=>[kcw_logs_wpdb_utils_create_column("sessionid","varchar(15)")],
                1=>[kcw_logs_wpdb_utils_create_column("started_date","datetime")],
                2=>[kcw_logs_wpdb_utils_create_column("staffid","varchar(15)")],
            ],
            [
                0=>[kcw_logs_wpdb_utils_create_column("statusid","varchar(15)")],
                1=>[kcw_logs_wpdb_utils_create_column("name","varchar(50)")],
                2=>[kcw_logs_wpdb_utils_create_column("description","varchar(255)")],
            ],
        ];

?>