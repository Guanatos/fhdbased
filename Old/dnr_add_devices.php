<?php
ob_start();
include("includes/session.php");
include("includes/checksession.php");
include("includes/checksessionadmin.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Add Devices</title>
<?php
include("fhd_config.php");
include("includes/header.php");
include("includes/all-nav.php");
include("includes/functions.php");
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");
$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
$actionstatus = "";
$type = 3;   // Devices
// This code is executed after hitting the <ADD> button
if (isset($_POST['nacl'])){
	if ( $_POST['nacl'] == md5(AUTH_KEY.$db->get_var("SELECT last_login FROM site_users WHERE user_id = $user_id;")) ) {	
  	 $type_name = $db->escape($_POST['type_name']);	 
	 if (ifexist('site_types','type_name',$type_name)){
	 	// Record Found
	 	$actionstatus = "<div class=\"alert alert-danger\" style=\"max-width: 250px;\">
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
        Record duplicated, nothing was changed.
	    </div>";
	 	// Record Not Found
	 } else {
	    $db->query("INSERT INTO site_types(type,type_name,type_email,type_location,type_phone) VALUES ('$type','$type_name',NULL,NULL,NULL);");
	    $actionstatus = "<div class=\"alert alert-success\" style=\"max-width: 250px;\">
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
        Record Added.
        </div>";
     }
   }
}
//</ADD>
$nacl = md5(AUTH_KEY.$db->get_var("SELECT last_login FROM site_users WHERE user_id = $user_id;"));
?>
<h4>Add Devices</h4>
<?php 
echo $actionstatus;
echo "<p><a href='fhd_settings.php'>Settings</a></p>";
?>
<form action="dnr_add_devices.php" method="post" class="form-horizontal" data-parsley-validate>
<table class="<?php echo $table_style_2;?>" style='width: auto;'>
	<tr><td>Name*</td>
	<td><input type="text" name="type_name" required></td></tr>
</table>
<input type='hidden' name='nacl' value='<?php echo $nacl;?>'>
<input type="submit" value="Add Device" class="btn btn-primary">
</form>
<h5><i class="fa fa-arrow-left"></i><a href="http://localhost/fhdbased/devices.php?type=3"> Back to Devices</a></h5>
<?php
if(isset($_SESSION['name'])){
	echo "<p><strong>Name:</strong> " . $_SESSION['name'] . "</p>";
}
include("includes/footer.php");
?>