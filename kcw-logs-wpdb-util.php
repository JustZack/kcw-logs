<?php

function kcw_logs_wpdb_util_query($sql) {
    global $wpdb;
    $selection = $wpdb->get_results($sql, 'ARRAY_A');
    return $selection;
}

//Creates the nessesary datastructure for adding rows to tables
function kcw_logs_wpdb_utils_create_column($varname, $vartype, $NOTNULL = true, $primary_key = false) {
    $column = array();
    $column["name"] = $varname;
    $column["type"] = $vartype;
    $column["options"] = ($NOTNULL?" not null ":"");
    $column["options"] .= ($primary_key?" auto_increment, primary key ($varname) ":" ");
    return $column;
}
//Creates a table in wordpress;
//Returns the wp_prefix_table_name
function kcw_logs_wpdb_utils_create_table($table_name, $columns) {
    global $wpdb;
    $create = "create table {$wpdb->prefix}$table_name ";

    $cols = "( ";
    for ($i = 0;$i < count($columns);$i++) {
        $col = $columns[$i];
        $cols .= "{$col["name"]} {$col["type"]} {$col["options"]}";
        if ($i < count($columns)-1) $cols .= ", ";
    }
    $cols .= " );";
    $sql = $create . $cols;
    return kcw_logs_wpdb_util_query($sql);
}

function kcw_logs_wpdb_utils_drop_table($table_name) {
    global $wpdb;
    $drop = "drop table {$wpdb->prefix}$table_name;";
    return kcw_logs_wpdb_util_query($drop);
}

function kcw_logs_wpdb_util_data_type_pair($column, $value) {
    $row_item = array($column=>$value);
    return $row_item;
}

function kcw_logs_structure_insert_list($data, $surround_with = '') {
    $list = " ( ";
    $i = 0;
    foreach($data as $key) {
        $list .= $surround_with . "$key" . $surround_with;
        if (++$i < count($data)) $list .= ", ";
        else $list .= " ";
    }
    $list .= " ) ";
    return $list;
}

//Inserts a new* $row into the $table_name
function kcw_logs_wpdb_util_insert_row($table_name, $row) {
    global $wpdb;
    $columns = kcw_logs_structure_insert_list(array_keys($row));
    $values = kcw_logs_structure_insert_list(array_values($row), "'");
    $insert = "insert into {$wpdb->prefix}$table_name $columns values $values;";
    return kcw_logs_wpdb_util_query($insert);
}

//Updates the given row in the table with the row_id
function kcw_logs_wpdb_util_update_row($table_name, $row, $conditionals) {
    global $wpdb;
    $update = "update {$wpdb->prefix}$table_name";
    $set = kcw_logs_wpdb_utils_structure_set($row);
    $where = kcw_logs_wpdb_utils_structure_where($conditionals, "and");
    $sql = "$update $set $where";
    return kcw_logs_wpdb_util_query($sql);
}

function kcw_logs_wpdb_utils_structure_list($items, $separator) {
    $list = "";
    foreach($items as $item) {
        $list .= "$item";
        //Only add commas for non-last items
        if ($item != $items[count($items) - 1])
            $list .= " $separator ";
        $list .= " ";
    }
    return $list;
}
//Structure columns for selections
function kcw_logs_wpdb_utils_structure_columns($columns) {
    $col_sql = "";
    
    if ($columns == "*" || is_string($columns)) {
        $col_sql = "$columns";
    } else {
        $col_sql = kcw_logs_wpdb_utils_structure_list($columns, ",");
    }

    return $col_sql;
}
//Structure where conditionals
function kcw_logs_wpdb_utils_structure_where($conditionals, $conditional_operator) {
    $where_sql = "where ";

    if (!isset($conditionals) || $conditionals == "") {
        $where_sql = "";
    } else {
        if (is_string($conditionals)) {
            $where_sql .= $conditionals;
        } else {
            $where_sql .= kcw_logs_wpdb_utils_structure_list($conditionals, $conditional_operator);
        }
    }

    return $where_sql;
}
//Structure update sets
function kcw_logs_wpdb_utils_structure_set($row) {
    $set_sql = "set ";

    if (!isset($row) || $row == "") {
        $set_sql = "";
    } else {
        if (is_string($row)) {
            $set_sql .= $row;
        } else {
            $items = array();
            foreach ($row as $key=>$val) $items[] = "$key = $val";
            $set_sql .= kcw_logs_wpdb_utils_structure_list($items, ',');
        }
    }

    return $set_sql;
}
//Returns the entire row for the given table and $row_id
function kcw_logs_wpdb_util_get_row($table_name, $conditionals = "", $columns = "*", $default_conditional = "and") {
    global $wpdb;
    $columns = kcw_logs_wpdb_utils_structure_columns($columns);
    $where = kcw_logs_wpdb_utils_structure_where($conditionals, $default_conditional);
    $select = "select $columns from {$wpdb->prefix}$table_name";
    $sql = "$select $where;";
    return kcw_logs_wpdb_util_query($sql);
}

//Deletes the row in the given table with the given $row_id
function kcw_logs_wpdb_util_delete_row($table_name, $condition) {
    global $wpdb;
    $delete = "delete from {$wpdb->prefix}$table_name";
    $where = kcw_logs_wpdb_utils_structure_where($condition, "and");
    $sql = "$delete $where;";
    return kcw_logs_wpdb_util_query($sql);
}

//Determine if a table exists
function kcw_logs_wpdb_util_table_exists($table_name) {
    global $wpdb;
    $name = $wpdb->prefix . $table_name;
    return ($wpdb->get_var("SHOW TABLES LIKE '$name'") == $name);
}

?>