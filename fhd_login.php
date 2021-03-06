<?php
	include("includes/session.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title>Service Desk</title>
<?php
$is_valid = 0;
$is_pending = 0;
include("fhd_config.php");
include("includes/header.php");
include("includes/functions.php");

if (!isset($_SESSION['auth'])) {
	echo "<p>Authentication Error</p><p><i class='fa fa-lock'></i></p>";
	include("includes/footer.php");
	exit;
}

//limit login tries.
if (isset($_SESSION['hit'])) {
	$_SESSION['hit'] += 1;
	if ($_SESSION['hit'] > LOGIN_TRIES) {
		echo "<p><i class='fa fa-lock fa-2x pull-left'></i> Access Locked</p>";
		include("includes/footer.php");
		exit;
	}
} else {
	$_SESSION['hit'] = 0;
}

// Required for MySQL DB
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");
$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);

if (isset($_POST['user_login'])) {
	$user_login = trim( $db->escape($_POST['user_login']));
} else {
	echo "<div class='alert alert-warning' style='width: 375px;'>";
	echo "<i class='glyphicon glyphicon-info-sign'>";
	echo "</i> Username / Email is Required.</div>";
	include("includes/footer.php");
	exit;
}

if (isset($_POST['user_password'])) {
	$user_password = trim( $db->escape( $_POST['user_password'] ));
	$is_valid = check_pwd($user_password,$user_login);
}

//users can login with either login name or email address.
$pos = strrpos($user_login, "@");
if ($pos === false) { // note: three equal signs
    $checkusing = "user_login";
} else {
    $checkusing = "user_email";
}

if ($is_valid <> 1) {
	$_SESSION['hit'] += 1;
	echo "<div class='alert alert-warning' style='width: 375px;'>";
	echo "<i class='glyphicon glyphicon-info-sign'>";
	echo "</i> Login incorrect.</div>";
	include("includes/footer.php");
	exit;
}

$is_pending = $db->get_var("SELECT user_pending FROM site_users WHERE user_login = '$user_login' OR user_email = '$user_login' LIMIT 1;");
//$db->debug();
if ($is_pending == 1) {
	$_SESSION['hit'] += 1;
	echo "<div class='alert alert-warning' style='width: 375px;'>";
	echo "<i class='glyphicon glyphicon-info-sign'>";
	echo "</i> Your registration is pending.</div>";
	include("includes/footer.php");
	exit;
}

$site_users = $db->get_row("SELECT user_id,user_name,user_level FROM site_users WHERE $checkusing = '$user_login' LIMIT 1;");
$user_id = $site_users->user_id;
$user_name = $site_users->user_name;
$user_level = $site_users->user_level;

if ($user_level == 0) {
	$_SESSION['admin'] = 1;
} else {
	$_SESSION['user'] = 1;
}

$_SESSION['user_id']=$user_id;
$_SESSION['user_name']=$user_name;
$_SESSION['user_level']=$user_level;
$_SESSION['hit'] = 0;

include("includes/all-nav.php");

echo "<!-- <p>$user_id</p> -->";
echo "<h2>Welcome, $user_name</h2>";

//record some details about this login
$lastip = $_SERVER['REMOTE_ADDR'];

//$last_login = mktime($dateTime->format("n/j/y g:i a"));
$last_login = date(time());
//echo $dateTime->format("Y-m-d h:i:s");

$db->query("UPDATE site_users SET last_ip = '$lastip',last_login = '$last_login' WHERE user_id = $user_id;");
//$d_last_login = $db->get_var("select last_login from site_users where user_id = $num limit 1;");
?>

<h3><a href="fhd_user_call_add.php" class="btn btn-large btn-primary btn-success">Open Ticket</a></h3>
<h3><a href="fhd_calls.php" class="btn btn-large btn-primary">View Tickets</a></h3>

<?php
	include("includes/footer.php");
?>
