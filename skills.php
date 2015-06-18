<?php
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

$pending = "";
$title	 = "";

if (isset($_GET['pending'])){
	$pending = "AND skill_pending = 1";
}

if (isset($_GET['support_staff'])){
	$pending = "AND user_level = 2";
	$title = "Support Staff";
}

$myquery = "SELECT skill_id, skill_name, skill_desc FROM skills WHERE 1 $pending ORDER BY skill_name;";
$site_calls = $db->get_results($myquery);
$num = $db->num_rows;
echo "<p><a href='fhd_settings.php'>Settings</a></p>";
echo "<h4>$num $title Skills</h4>";
if ($num > 0){
?>

<table class="<?php echo $table_style_2;?>" style='width: auto;'>
<tr>
	<th>Skill Name</th>
	<th>Description</th>
</tr>
<?php
foreach ( $site_calls as $call )
{
	$skill_id = $call->skill_id;
	$skill_name = $call->skill_name;
	$skill_desc  = $call->skill_desc;
	$bg = ($user_pending == 1) ? " class='usernote'" : "";
	$call_count = $db->get_var("SELECT count(call_id) from site_calls WHERE (call_user = $user_id) AND (call_status = 0);");
	echo "<tr>\n";
	echo "<td".$bg."><a href='fhd_edit_user.php?url_user_id=$user_id'>$user_id</a></td>\n";
	echo "<td align='center'><a href='fhd_calls.php?user_id=$user_id'>$call_count</a></td>\n";
	echo "<td>$user_name</td>\n";
	echo "<td>$user_email</td>\n";
	echo "<td>".show_user_level($user_level)."</td>\n";
	echo "<td style='text-align: center;'>".onoff($user_msg_send)."</td>\n";
	echo "<td style='text-align: center;'>".onoff($user_pending)."</td>\n";
	echo "<td style='text-align: center;'>".onoff($user_protect_edit)."</td>\n";
	echo "</tr>\n";
	}
}
?>
</table>

<?php
if(isset($_SESSION['user_name'])){
	echo "<h5>Current User: " . $_SESSION['user_name'] . "</h5>";
}
include("includes/footer.php");
