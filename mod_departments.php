<?php
include("includes/session.php");
include("includes/checksession.php");
include("includes/checksessionadmin.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Skills</title>
<?php
include("fhd_config.php");
include("includes/header.php");
include("includes/all-nav.php");
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");
include("includes/functions.php");
$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
$actionstatus = "";
// <UPDATE>
if (isset($_POST['nacl'])){
 if ( $_POST['nacl'] == md5(AUTH_KEY.$db->get_var("SELECT last_login FROM site_users WHERE user_id = $user_id;")) ) {
	//authentication verified, continue.
        $skill_id = $db->escape($_POST['skill_id']);
        $skill_name = $db->escape($_POST['skill_name']);
        $skill_desc = $db->escape($_POST['skill_desc']);
// See if the record is not duplicated
	if (ifexist('skills','skill_name',$skill_name)){
// Record Found
        $actionstatus = "<div class=\"alert alert-danger\" style=\"max-width: 250px;\">
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
        Record duplicated, nothing was changed.
	</div>";
// Record Not Found
	} else { 
	$db->query("UPDATE skills SET skill_name='$skill_name',skill_desc='$skill_desc' WHERE skill_id = $skill_id;");
        $actionstatus = "<div class=\"alert alert-success\" style=\"max-width: 250px;\">
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
        Skill Updated.
        </div>";
	}
 } // if
}
// </UPDATE>
$skill_id = checkid($_GET['skill_id']);
$num = $db->get_var("SELECT count(skill_id) FROM skills WHERE skill_id LIKE '$skill_id';");
//$db->debug();
$nacl = md5(AUTH_KEY.$db->get_var("SELECT last_login FROM site_users WHERE user_id = $user_id;"));
?>
<h4>Edit Type</h4>
<?php 
echo $actionstatus;
echo "<p><a href='fhd_settings.php'>Settings</a></p>";
?>
<?php if ($num > 0) { 
	$skills = $db->get_results("SELECT skill_id,skill_name,skill_desc FROM skills WHERE skill_id LIKE '$skill_id' ORDER BY skill_name;");
	echo "<form action='' method='post' class='form-horizontal'>\n";
	foreach ( $skills as $skill ) {
	$skill_id = $skill->skill_id;
	$skill_name = $skill->skill_name;
	$skill_desc = $skill->skill_desc;
	echo "<table class='<?php echo $table_style_2;?>' style='width: auto;'>";
	echo "<tr><td>Skill Name*</td>";
	echo "<td><input type='text' name='skill_name' value='$skill_name' required></td></tr>\n";
	echo "<tr><td>Description*</td>\n";
	echo "<td><textarea rows='2' name='skill_desc' required>$skill_desc</textarea></td></tr>\n";
	echo "<tr><td colspan='2'><input type='submit' value='update' class='btn btn-primary'></td></tr>\n";
	echo "</table>\n</form>\n";
	} //foreach
   } //IF
?>
<h5><i class="fa fa-arrow-left"></i><a href="skills.php?skill=show">Back to Skills</a></h5>
<?php
if(isset($_SESSION['name'])){
	echo "<br /><p><strong>Login Name:</strong> " . $_SESSION['name'] . "</p>";
}
include("includes/footer.php");
