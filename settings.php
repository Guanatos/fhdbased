<?php
/*
settings.php

This is a generic process to list settings

- Departments
- Priorities

*/

include("includes/session.php");
include("includes/checksession.php");
include("includes/checksessionadmin.php");
include("fhd_config.php");
include("includes/header.php");
include("includes/all-nav.php");
include("includes/functions.php");
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");
$actionstatus = "";
$label = "";
$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
$action = $db->escape( $_GET['action'] );
$type = $db->escape( $_GET['type'] );
$type_id = $db->escape( $_GET['type_id'] );
switch ($type) {
    case 1:
      $label = 'Departments';
      break;
    case 2:
      $label = 'Priorities';
      break;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $label; ?></title>
<?php
if ($action == 'delete'){
   $db->query("DELETE FROM site_types WHERE type_id = $type_id;");
}
$myquery = "SELECT type_id, type, type_name FROM site_types WHERE type LIKE $type ORDER BY type_name;";
$site_calls = $db->get_results($myquery);
//$db->debug();
$num = $db->num_rows;
echo "<h4>$num $title $label</h4>";
if ($num >= 0){ // if there are records, show them
?>
	<table class="<?php echo $table_style_2;?>" style='width: auto;'>
	<tr>
		<th>Name</th>
<!-- <th>Description</th>  -->
		<th>Edit</th>
		<th>Delete</th>
	</tr>
<?php
	foreach ( $site_calls as $call ) {
		$type_id = $call->type_id;
		$type_name = $call->type_name;
//		$type_desc = $call->type_desc;
		echo "<tr>\n";
		echo "<td>$type_name</td>\n";
//		echo "<td>$type_desc</td>\n";
		echo "<td align='center'><a href='mod_settings.php?type=$type&type_id=$type_id&action=edit'>";
    echo "<i class='glyphicon glyphicon-edit' title='edit'></i></a></td>\n";
       	$deletelink = "<a href='settings.php?type_id=$type_id&action=delete&nacl=$nacl' onclick=\"return confirm('Are you sure you want to delete?')\"><i class='glyphicon glyphicon-remove-circle' title='delete'></i></a>";
		echo "<td align='center'>$deletelink</td>\n";
		echo "</tr>\n";
		} // foreach
?>
<h5><i class="fa fa-plus"></i> <a href="dnr_add_departments.php">Add New</a></h5>
<?php } ?>
</table>
<h5><i class="fa fa-arrow-left"></i><a href="fhd_settings.php" class="button next"> Back to Settings</a></h5>
<?php
if(isset($_SESSION['user_name'])){
	echo "<h5>Current User: " . $_SESSION['user_name'] . "</h5>";
}
include("includes/footer.php");
?>
