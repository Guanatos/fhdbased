<?php
include("includes/session.php");
include("includes/checksession.php");
include("includes/checksessionadmin.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Departments</title>
<?php
include("fhd_config.php");
include("includes/header.php");
include("includes/all-nav.php");
include("includes/functions.php");
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");
$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
$actionstatus = "";
$type = 1; // Departments
// <UPDATE>
if (isset($_POST['nacl'])){
 if ( $_POST['nacl'] == md5(AUTH_KEY.$db->get_var("SELECT last_login FROM site_users WHERE user_id = $user_id;")) ) {
	//authentication verified, continue.
        $type_id = $db->escape($_POST['type_id']);
        $type_name = $db->escape($_POST['type_name']);
// See if the record is not duplicated
	if (ifexist2($type,$type_name)){
// Record Found
        $actionstatus = "<div class=\"alert alert-danger\" style=\"max-width: 250px;\">
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
        Record duplicated, nothing was changed.
	    </div>";
// Record Not Found
	} else { 
	    $db->query("UPDATE site_types SET type_name='$type_name' WHERE type_id = $type_id;");
        $actionstatus = "<div class=\"alert alert-success\" style=\"max-width: 250px;\">
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
        Record Updated.
        </div>";
	}
 } // if
}
// </UPDATE>
$type_id = checkid($_GET['type_id']);
$num = $db->get_var("SELECT count(type_id) FROM site_types WHERE type_id LIKE '$type_id';");
//$db->debug();
$nacl = md5(AUTH_KEY.$db->get_var("SELECT last_login FROM site_users WHERE user_id = $user_id;"));
?>
<h4>Edit Department</h4>
<?php 
echo $actionstatus;
echo "<p><a href='fhd_settings.php'> Settings</a></p>";
?>
<?php if ($num > 0) { 
	$skills = $db->get_results("SELECT type_name FROM site_types WHERE type_id LIKE '$type_id' ORDER BY type_name;");
	echo "<form action='mod_departments.php' method='post' class='form-horizontal'>\n";
	foreach ( $skills as $skill ) {
	$type_id = $skill->type_id;
	$type_name = $skill->type_name;
	echo "<table class='<?php echo $table_style_2;?>' style='width: auto;'>";
	echo "<tr><td>Department Name*</td>";
	echo "<td><input type='text' name='type_name' value='$type_name' required></td></tr>\n";
	echo "<tr><td colspan='2'><input type='submit' value='Update' class='btn btn-primary'></td></tr>\n";
	echo "</table>\n</form>\n";
	} //foreach
   } //IF
?>
<h5><i class="fa fa-arrow-left"></i><a href="departments.php?type=1"> Back to Departments</a></h5>
<?php
if(isset($_SESSION['name'])){
	echo "<br /><p><strong>Login Name:</strong> " . $_SESSION['name'] . "</p>";
}
include("includes/footer.php");
?>