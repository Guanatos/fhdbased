<?php
/*
skills.php

This is a generic process to manage skills

*/
include("fhd_config.php");
include("includes/session.php");
include("includes/checksession.php");
include("includes/checksessionadmin.php");
include("includes/header.php");
include("includes/all-nav.php");
include("includes/functions.php");
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");
$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
$action = $db->escape( $_GET['action'] );
$skill_id = $db->escape( $_GET['skill_id'] );
$sel_query = "SELECT skill_id, skill_name, skill_desc FROM skills WHERE 1 ORDER BY skill_name;";
$del_query = "DELETE FROM skills WHERE skill_id = " . $skill_id;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Skills</title>
</head>
<body>
<?php
if ($action == 'delete'){
   $db->query($del_query);
}
$results = $db->get_results($sel_query);
//$db->debug();
$num = $db->num_rows;
echo "<h4>$num $title Skills</h4>";
if ($num >= 0) { // if there are records, show them
?>
	<table class="<?php echo $table_style_2;?>" style='width: auto;'>
	<tr>
		<th>Skill</th>
		<th>Description</th>
		<th>Edit</th>
		<th>Delete</th>
	</tr>
<?php
	foreach ( $results as $result ) {
		$skill_id   = $result->skill_id;
		$skill_name = $result->skill_name;
		$skill_desc = $result->skill_desc;
		echo "<tr>\n";
		echo "<td>$skill_name</td>\n";
		echo "<td>$skill_desc</td>\n";
		echo "<td align='center'><a href='mod_skills.php?skill_id=$skill_id&action=edit'>";
		echo "<i class='glyphicon glyphicon-edit' title='Edit'></i></a></td>\n";
        $deletelink = "<a href='skills.php?skill_id=$skill_id&action=delete&nacl=$nacl' ";
		$deletelink = $deletelink . "onclick=\"return confirm('Are you sure you want to delete?')\">";
		$deletelink = $deletelink . "<i class='glyphicon glyphicon-remove-circle' title='delete'></i></a>";
		echo "<td align='center'>$deletelink</td>\n";
		echo "</tr>\n";
		} // foreach
?>
<h5><i class="fa fa-plus"></i> <a href="dnr_add_skills.php" class = "btn btn-primary">Add New</a></h5>
<?php } ?>
</table>
<h5><i class="fa fa-arrow-left"></i><a href="fhd_settings.php" class="btn btn-primary"> Back to Settings</a></h5>
<?php
if(isset($_SESSION['user_name'])){
	echo "<h5>Current User: " . $_SESSION['user_name'] . "</h5>";
}
include("includes/footer.php");
?>
</body>
</html>