<?php
include("includes/session.php");
include("includes/checksession.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Open Tickets</title>
<?php
include("fhd_config.php");
include("includes/header.php");
include("includes/all-nav.php");
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");
include("includes/functions.php");
$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
$queryadd = "";
$colspan = 2;
if($user_level == 1){
	$queryadd = " AND call_user = $user_id";
	$colspan = 1;
}

if(isset($_GET['user_id'])){
	$queryadd = " AND call_user = ".$db->escape( valid_user($_GET['user_id']) );
	$colspan = 2;
}

$myquery = "SELECT call_id,call_date,call_first_name,call_last_name,call_request,call_department,call_device,call_staff,call_status from site_calls WHERE (call_status = 0) $queryadd order by call_id desc;";
$site_calls = $db->get_results($myquery);
$num = $db->num_rows;
//$db->debug();
echo "<h4><i class='fa fa-tags'></i> &nbsp; Open Tickets <small>[ $num ]</small></h4>";
if ($num > 0){
?>
<table class="<?php echo $table_style_1;?>" style='width: auto;'>
<tr>
	<th colspan="<?php echo $colspan;?>" style='text-align: center;'>Action</th>
	<th>Status</th>
	<th>Creation Date</th>
	<th>Priority</th>
	<?php if($user_level <> 1){?>
	<th>Customer</th>
	<?php } ?>
	<th>Dept</th>
	<th>Device</th>
	<th>Staff Assigned</th>
	<th>Notes</th>
</tr>
<?php
foreach ( $site_calls as $call )
{
	$call_id = $call->call_id;
	$call_date = date("Y-m-d H:i",$call->call_date);
	$call_first_name  = $call->call_first_name;
	$call_last_name  = $call->call_last_name;
	$call_status = $call->call_status;
	switch ($call_status) {
		case 0:
		$call_status="active";
		break;
		case 1:
		$call_status="closed";
		break;
	}
	$call_request = $call->call_request;
	$call_department = $call->call_department;
	$call_device = $call->call_device;
	$call_staff = $call->call_staff;
	$call_staff = $db->get_var("SELECT user_name from site_users WHERE (user_id = $call_staff);");
	$request_name = $db->get_var("SELECT type_name from site_types WHERE (type_id = $call_request);");
	$department_name = $db->get_var("SELECT type_name from site_types WHERE (type_id = $call_department);");
	$device_name = $db->get_var("SELECT type_name from site_types WHERE (type_id = $call_device);");
	$note_count = $db->get_var("SELECT count(note_id) from site_notes WHERE (note_relation = $call_id) and (note_type = 1);");
	echo "<tr>\n<td style='text-align: center;'><a href='fhd_call_details.php?call_id=$call_id'><i class='fa fa-eye'></i></a></td>\n";


	if($user_level <> 1){
	echo "<td style='text-align: center;'><a href='fhd_call_edit.php?call_id=$call_id'><i class='fa fa-pencil-square-o' title='edit'></i></a><td>$call_status</td>\n<td>$call_date</td>\n<td>$request_name</td>\n<td>$call_first_name</td>\n</td>\n";
	}

	echo "<td>$department_name</td>\n<td>$device_name</td>\n<td>$call_staff</td>\n";
	echo "<td>$note_count</td>\n</tr>\n";
}
}
?>
</table>

<?php
if(isset($_SESSION['user_name'])){
	
	echo "<p><i class='fa fa-user fa-sm fa-border'></i>" . $_SESSION['user_name'] . "</p>";
}
include("includes/footer.php");
