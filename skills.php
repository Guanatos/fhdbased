<?php
// skills.php
include("includes/session.php");
include("includes/checksession.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Skills</title>
<?php
include("fhd_config.php");
include("includes/header.php");
include("includes/all-nav.php");
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");
include("includes/functions.php");
$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
$myquery = "SELECT skill_id, skill_name, skill_desc FROM skills WHERE 1 ORDER BY skill_name;";
$skill_id = $db->escape( $_GET['skill_id'] );
$action = $db->escape( $_GET['action'] );
if ($action == 'delete'){
   $db->query("DELETE FROM skills WHERE skill_id = $skill_id;");
}
$site_calls = $db->get_results($myquery);
$num = $db->num_rows;
echo "<p><a href='fhd_settings.php'>Settings</a></p>";
echo "<h4>$num $title Skills</h4>";
if ($num >= 0){ // if there are records, show them
?>
	<table class="<?php echo $table_style_2;?>" style='width: auto;'>
	<tr>
		<th>Skill Name</th>
		<th>Description</th>
		<th>Edit</th>
		<th>Delete</th>
	</tr>
<?php
	foreach ( $site_calls as $call ) {
		$skill_id = $call->skill_id;
		$skill_name = $call->skill_name;
		$skill_desc = $call->skill_desc;
		echo "<tr>\n";
		echo "<td>$skill_name</td>\n";
		echo "<td>$skill_desc</td>\n";
		echo "<td align='center'><a href='mod_skills.php?skill_id=$skill_id&action=edit'><i class='glyphicon glyphicon-edit' title='edit'></i></a></td>\n";
        	$deletelink = "<a href='skills.php?skill_id=$skill_id&action=delete&nacl=$nacl' onclick=\"return confirm('Are you sure you want to delete?')\"><i class='glyphicon glyphicon-remove-circle' title='delete'></i></a>";
		echo "<td align='center'>$deletelink</td>\n";
		echo "</tr>\n";
		} // foreach
?>
	<h5><i class="fa fa-plus"></i> <a href="add_skills.php">Add New</a></h5>
<?php } ?> 
	</table>

<?php
if(isset($_SESSION['user_name'])){
	echo "<h5>Current User: " . $_SESSION['user_name'] . "</h5>";
}
include("includes/footer.php");
