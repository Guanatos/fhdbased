<?php
/*

All queries

*/

// encrypted_passwords
define("query_encrypted","SELECT option_value FROM site_options WHERE option_name = 'encrypted_passwords';");

// settings
//$sel_query = "SELECT type, type_id, type_name FROM site_types WHERE type LIKE " . $type . " ORDER BY type_name;";
define('select_setting','SELECT type, type_id, type_name FROM site_types WHERE type = $type ORDER BY type_name');
//$del_query = "DELETE FROM site_types WHERE type_id = " . $type_id;
define("delete_setting",'\"DELETE FROM site_types WHERE type_id = \" . $type_id;');
