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
$nacl = md5(AUTH_KEY.$db->get_var("SELECT last_login FROM site_users WHERE user_id = $user_id;"));
if (isset($_POST['submit'])) {
		if ($nacl == md5(AUTH_KEY.$db->get_var("SELECT last_login FROM site_users WHERE user_id = $user_id;"))) {
			  // authentication verified, continue.
				// Review if the record is not duplicated before updating it
		    if (if_type_exist($type, $_POST['type_name'])) {
				// Record Found
		       $actionstatus = "<div class=\"alert alert-danger\" style=\"max-width: 250px;\">
		       <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
		       Record duplicated, nothing was changed.
			     </div>";
				// Record Not Found, proceed
				} else {
					 $tempid = $_POST['type_id'];
					 $tempname = $_POST['type_name'];
				   $db->query("UPDATE site_types SET type_name='$tempname' WHERE type_id = '$tempid';");
//					 $db->debug();
			     $actionstatus = "<div class=\"alert alert-success\" style=\"max-width: 250px;\">
			     <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
			     Record Updated.
			     </div>";
				}
			} // if nacl
}// if isset
$type_id = $_GET['type_id'];
$num = $db->get_var("SELECT COUNT(type_id) FROM site_types WHERE type_id LIKE '$type_id';");
?>
<h4>Edit Department</h4>
<?php
echo $actionstatus;
echo "<p><a href='fhd_settings.php'> Settings</a></p>";
if ($num > 0) {
			$results = $db->get_results("SELECT type_id, type_name FROM site_types WHERE type_id LIKE '$type_id' ORDER BY type_name;");
			echo "<form action='mod_departments.php' method='post' class='form-horizontal'>\n";
			foreach ($results as $result ) {
				$type_id = $result->type_id;
				$type_name = $result->type_name;
				echo "<table class='<?php echo $table_style_2;?>' style='width: auto;'>";
				echo "<input type='hidden' name='type_id' value='$type_id' readonly>\n";
				echo "<tr><td>Department New Name*</td>";
				echo "<td><input type='text' name='type_name' value='$type_name' required></td></tr>\n";
				echo "<tr><td colspan='2'><input type='submit' name='submit' value='Update' class='btn btn-primary'></td></tr>\n";
				echo "</table>\n</form>\n";
				} //foreach
   		} //IF
?>
<h5><i class="fa fa-arrow-left"></i><a href="departments.php?type=1"> Back to Departments</a></h5>
<?php
if (isset($_SESSION['name'])) {
	 echo "<br /><p><strong>Login Name:</strong> " . $_SESSION['name'] . "</p>";
}
include("includes/footer.php");
?>
