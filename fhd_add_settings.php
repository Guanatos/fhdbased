<?php
/*
add_settings.php

This is a generic process to add settings

- Departments
- Priorities
- Devices

*/
ob_start();
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
$type = $_GET['type'];
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
	<title>Add <?php echo $label; ?></title>
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
		      Record duplicated, nothing was changed.
			    </div>";
			 	// Record Not Found
			 } else {
			    $db->query("INSERT INTO site_types(type,type_name,type_email,type_location,type_phone) VALUES ('$type','$type_name',NULL,NULL,NULL);");
//          $db->debug();
			    $actionstatus = "<div class=\"alert alert-success\" style=\"max-width: 250px;\">
		      <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
		      Record Added.
		      </div>";
		   }
  	} // if nacl
}
?>
<h4>Add <?php echo $label; ?></h4>
<?php
if (empty($actionstatus)) {
		echo "<form action='fhd_add_settings.php' method='post' class='form-horizontal' data-parsley-validate>";
		echo "<table class='<?php echo $table_style_2;?>' style='width: auto;'>";
		echo "<tr><td>" .  $label . " Name*</td>";
		echo "<td><input type='text' class='form-control' name='type_name' required></td>";
		echo "</tr></table>";
		echo "<input type='hidden' name='label' value='$label' readonly>\n";
		echo "<input type='hidden' name='type' value='$type' readonly>\n";
		echo "<input type='hidden' name='nacl' value='$nacl' readonly>\n";
		echo "<input type='submit' name='submit' value='Add " . $label . "' class='btn btn-primary'>";
		echo "</form>";
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
