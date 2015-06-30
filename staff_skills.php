<?php
// skills.php
include("includes/session.php");
include("includes/checksession.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Staff Skills</title>
<?php
include("fhd_config.php");
include("includes/header.php");
include("includes/all-nav.php");
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");
include("includes/functions.php");
$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
// Staff Members
$myquery1 = "SELECT user_id,user_login,user_name,user_level FROM site_users WHERE user_level = 2 ORDER BY user_name;";
// Staff Skills
$myquery2 = "SELECT site_users.user_id,user_name,skills.skill_id,skill_name FROM site_users, skills,user_skills WHERE site_users.user_id = user_skills.user_id and skills.skill_id = user_skills.skill_id ORDER BY user_name;";
// Available Skills
$myquery3 = "SELECT skill_id, skill_name, skill_desc FROM skills WHERE 1 ORDER BY skill_name;";

//$skill_id = $db->escape( $_GET['skill_id'] );
//$action = $db->escape( $_GET['action'] );
//if ($action == 'delete'){
//   $db->query("DELETE FROM skills WHERE skill_id = $skill_id;");
//}

$staffcrew = $db->get_results($myquery1);
$num = $db->num_rows;
echo "<p><a href='fhd_settings.php'>Settings</a></p>";
echo "<h4>$num $title Staff Members</h4>";
if ($num >= 0){ // if there are Staff Members
    	echo '<div class="form-group">';
	echo '<label for="select" class="col-lg-2 control-label">Staff Members</label>';
	echo '<div class="col-lg-10">';
        echo '<div style="clear:both;"></div>';
        echo '<select class="form-control" name="staff_members" id="staff_members" multiple="multiple" size=5>';
	foreach ( $staffcrew as $staffmember ) {
		$user_name = $staffmember->user_name;
		echo "<option value='$user_name'>$user_name</option>";
	} // foreach
        echo '</select>';
	echo '</div><br>';
	$availskills = $db->get_results($myquery3);
	$num = $db->num_rows;
	if ($num >= 0){ // if there are Skills Available
        	echo '<div class="form-group">';
        	echo '<label for="select" class="col-lg-2 control-label">Available Skills</label>';
        	echo '<div class="col-lg-10">';
        	echo '<div style="clear:both;"></div>';
        	echo '<select class="form-control" name="staff_members" id="staff_members" multiple="multiple" size=5>';
        	foreach ( $availskills as $availskill ) {
                	$skill_name = $availskill->skill_name;
                	echo "<option value='$skill_name'>$skill_name</option>";
        	} // foreach
        	echo '</select>';
        	echo '</div><br>';
	} // if
?>
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
