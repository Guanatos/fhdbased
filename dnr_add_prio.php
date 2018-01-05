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
<title>Add Priority</title>
<?php
include("fhd_config.php");
include("includes/header.php");
include("includes/all-nav.php");
include("includes/functions.php");
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");
$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
$actionstatus = "";
$type = 2;   // Priorities
// This code is executed after hitting the <ADD> button
if (isset($_POST['nacl'])){
	if ($_POST['nacl'] == md5(AUTH_KEY.$db->get_var("SELECT last_login FROM site_users WHERE user_id = $user_id;"))) {
	   $type_name = $db->escape($_POST['type_name']);
		 if (if_type_exist($type, $type_name)){
		 	// Record Found
		 		$actionstatus = "<div class=\"alert alert-danger\" style=\"max-width: 250px;\">
	        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
	        Record duplicated, nothing was changed.
		      </div>";
		 	// Record Not Found
	 } else {
	    $db->query("INSERT INTO site_types(type,type_name,type_email,type_location,type_phone) VALUES ('$type','$type_name',NULL,NULL,NULL);");
			//$db->debug();
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
<h4>Adding a Priority</h4>
<?php
echo $actionstatus;
echo "<p><a href='fhd_settings.php'>Settings</a></p>";
?>
<form action="dnr_add_prio.php" method="post" class="form-horizontal" data-parsley-validate>
<table class="<?php echo $table_style_2;?>" style='width: auto;'>
	<tr><td>Priority Name*</td>
	<td><input type="text" name="type_name" required></td></tr>
</table>
<input type='hidden' name='nacl' value='<?php echo $nacl;?>'>
<input type="submit" value="Add Priority" class="btn btn-primary">
</form>
<h5><i class="fa fa-arrow-left"></i><a href="http://localhost/fhdbased/priorities.php?type=2"> Back to Priorities</a></h5>
<?php
if(isset($_SESSION['name'])){
	echo "<p><strong>Name:</strong> " . $_SESSION['name'] . "</p>";
}
include("includes/footer.php");
?>
