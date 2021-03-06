<?php
/*
mod_settings.php

This is a generic process to manage settings

- Departments
- Priorities
- Devices

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
$actionstatus = "";
$label = "";
$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
$type = $db->escape( $_GET['type']);
$type_id = $db->escape( $_GET['type_id'] );
$action = $db->escape($_GET['action']);
switch ($type) {
    case 1:
      $label = 'Departments';
      break;
    case 2:
      $label = 'Priorities';
      break;
		case 3:
      $label = 'Devices';
      break;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit <?php echo $label; ?></title>
</head>
<body>
<?php
$nacl = md5(AUTH_KEY.$db->get_var("SELECT last_login FROM site_users WHERE user_id = $user_id;"));
if (isset($_POST['submit'])) {
		$label = $_POST['label'];
		$type = $_POST['type'];
		$type_id = $_POST['type_id'];
		$type_name = $_POST['type_name'];
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
				   $db->query("UPDATE site_types SET type_name='$type_name' WHERE type_id = '$type_id';");
//					 $db->debug();
			     $actionstatus = "<div class=\"alert alert-success\" style=\"max-width: 250px;\">
			     <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
			     Record Updated.
			     </div>";
				}
		} // if nacl
}// if isset
$num = $db->get_var("SELECT COUNT(type_id) FROM site_types WHERE type_id LIKE '$type_id';");
?>
<h4>Edit <?php echo $label; ?></h4>
<?php
if (empty($actionstatus)) {
	if ($num > 0) {
				$results = $db->get_results("SELECT type, type_id, type_name FROM site_types WHERE type_id LIKE '$type_id' ORDER BY type_name;");
				echo "<form action='mod_settings.php' method='post' class='form-horizontal'>\n";
				foreach ($results as $result ) {
					$type = $result->type;
					$type_id = $result->type_id;
					$type_name = $result->type_name;
					echo "<table class='<?php echo $table_style_2;?>' style='width: auto;'>";
					echo "<input type='hidden' name='label' value='$label' readonly>\n";
					echo "<input type='hidden' name='type' value='$type' readonly>\n";
					echo "<input type='hidden' name='type_id' value='$type_id' readonly>\n";
					echo "<tr><td> " . $label . " New Name*</td>";
					echo "<td><input type='text' name='type_name' value='$type_name' required></td></tr>\n";
					echo "<tr><td colspan='2'><input type='submit' name='submit' value='Update' class='btn btn-primary'></td></tr>\n";
					echo "</table>\n</form>\n";
					} //foreach
	   		} // if num
		}
	else {
		echo $actionstatus;
}
echo "<h5><i class='fa fa-arrow-left'></i><a href='settings.php?type=$type'>";
echo " Back to " . $label . "</a></h5>";
if (isset($_SESSION['name'])) {
	 echo "<br /><p><strong>Login Name:</strong> " . $_SESSION['name'] . "</p>";
}
include("includes/footer.php");
?>
</body>
</html>
