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
<title>Add Skills Details</title>
<?php 
include("fhd_config.php");
include("includes/header.php");
include("includes/all-nav.php");
include("includes/functions.php");
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");
$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
$actionstatus = "";
// <ADD>
if (isset($_POST['nacl'])){
  if ( $_POST['nacl'] == md5(AUTH_KEY.$db->get_var("SELECT last_login FROM site_users WHERE user_id = $user_id;")) ) {
//authentication verified, continue.
	$skill_name = $db->escape($_POST['skill_name']);
	$skill_desc = $db->escape($_POST['skill_desc']);
	if (ifexist('skills','skill_name',$skill_name)){
// Record Found
        $actionstatus = "<div class=\"alert alert-danger\" style=\"max-width: 250px;\">
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
        Record duplicated, nothing was changed.
	</div>";
// Record Not Found
	} else { 
        $db->query("INSERT INTO skills(skill_name,skill_desc) VALUES('$skill_name','$skill_desc');");
        $actionstatus = "<div class=\"alert alert-success\" style=\"max-width: 250px;\">
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
        Skill Added.
        </div>";
	}
  }
}
//</ADD>
$nacl = md5(AUTH_KEY.$db->get_var("SELECT last_login FROM site_users WHERE user_id = $user_id;"));
?>
<h4>Add Skills</h4>
<?php 
echo $actionstatus;
//echo "<p><a href='fhd_settings.php'>Settings</a></p>";
?>
<form action="fhd_add_skills.php" method="post" class="form-horizontal" data-parsley-validate>
<table class="<?php echo $table_style_2;?>" style='width: auto;'>
	<tr><td>Name*</td>
	<td><input type="text" name="skill_name" required></td></tr>
	<tr><td>Description*</td>
	<td><textarea rows="2" name="skill_desc" required></textarea></td>
</table>
<input type='hidden' name='nacl' value='<?php echo $nacl;?>'>
<input type="submit" value="Add Skill" class="btn btn-primary">
</form>
<h5><i class="fa fa-arrow-left"></i><a href="skills.php?skill=show" class="btn btn-primary"> Back to Skills</a>
</h5>
<?php
if(isset($_SESSION['name'])){
	echo "<p><strong>Name:</strong> " . $_SESSION['name'] . "</p>";
}
include("includes/footer.php");
?>