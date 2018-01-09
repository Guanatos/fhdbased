<?php include("includes/session.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Free Help Desk</title>

<?php
$_SESSION['auth'] = md5(uniqid(microtime()));

//check for fhd_config
$filename = 'fhd_config.php';
if (!file_exists($filename)) {
	  define('css', 'css/bootstrap.min.css');
    echo "<p></p><strong>Notice:</strong> Software Configuration Needed</p>";
    echo "<p>Please check the <strong>fhd_config.php</strong> file.</p>";
    echo "<p>If this is a new install, you can <strong>rename fhd_config_sample.php to fhd_config.php</strong></p>";
    echo "<p>Open fhd_config.php in a text editor and <strong>configure your settings</strong>.</p>";
    echo "<p>For more information, please check the <a href='readme.htm' target='_blank'>readme file</a>.</p>";
	  include("includes/footer.php");
	  exit;
}

include("fhd_config.php");
include("includes/header.php");

//check database settings.
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");

$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
//$db->debug();

$SCHEMA_NAME = $db->get_var("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '".db_name."';");
if ($SCHEMA_NAME <> db_name) {
  echo "<p></p><strong>Notice:</strong> Software Configuration Needed</p>";
	echo "<p>Database specified in fhd_config.php [ ".db_name." ] does not exist, please check the <a href='readme.htm' target='_blank'>readme file</a>.</p>";
	include("includes/footer.php");
	exit;
}

//check if tables actually exist.
$user_table_exists = $db->get_var("SHOW TABLES LIKE 'site_users';");
if ($user_table_exists <>  "site_users") {
  echo "<p></p><strong>Notice:</strong> Software Configuration Needed</p>";
	echo "<p>One or more database tables are missing from database (named: ".db_name."). Please run <strong>site.sql</strong> against your databsae to create the tables. Please check the <a href='readme.htm' target='_blank'>readme file</a></p>";
	include("includes/footer.php");
	exit;
}

//create upload table if it does not exist.
$upload_exists = $db->get_var("SHOW TABLES LIKE 'site_upload';");
if ($upload_exists <>  "site_upload") {
	$db->query("CREATE TABLE `site_upload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `call_id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_ext` varchar(4) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `call_id` (`call_id`)
) ;");
}

//create options table if it does not exist.
$options_exists = $db->get_var("SHOW TABLES LIKE 'site_options';");
if ($options_exists <>  "site_options") {
	$db->query("CREATE TABLE `site_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(255) DEFAULT NULL,
  `option_value` varchar(500) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `option_name` (`option_name`)
) ;");
	$db->query("INSERT INTO site_options(option_name) VALUES ('encrypted_passwords');");
	}

if (isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];
	include("includes/all-nav.php");
	echo "<p>Welcome</p>";
	echo "<p><a href='fhd_dashboard.php'>Help Desk Dashboard</a></p>";
}else{
?>
<?php
//limit login tries.
if (isset($_SESSION['hit'])) {
	if ($_SESSION['hit'] > LOGIN_TRIES){
		echo "<p><i class='fa fa-lock fa-2x pull-left'></i> Access Locked</p>";
		include("includes/footer.php");
		exit;
	}
}
?>
<?php
if (isset($_GET['loggedout'])) {
echo "<div class=\"alert alert-success\" style=\"max-width: 350px; text-align: center;\"><strong>Logged Out</strong><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>";
}
?>
<?php
if (ALLOW_ANY_ADD == 'yes') {
	echo "<h4><a href='fhd_any_call_add.php' class='btn btn-success'>Open Ticket <i class='glyphicon glyphicon-new-window'></i></a></h4>";
	echo "<hr>";
	echo "<p>or Login</p>";
}
?>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Brand</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="#">Do you need a job?</a></li>
        <li><a href="#">Do you need to get a job done?</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li><a href="#">Separated link</a></li>
            <li><a href="#">One more separated link</a></li>
          </ul>
        </li>
      </ul>
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          	<input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
        </form>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Sign In</a></li>
        <li><a href="fhd_register.php">Sign Up</a></li>
      </ul>
    </div>
  </div>
</nav>

<form action="fhd_login.php" method="post" class="form-horizontal" role="form">

<div class="form-group">
	<label class="col-sm-2 control-label" for="inputEmail">Email/Username</label>
	<div class="col-sm-3">
	<input type="text" id="inputEmail" name="user_login" placeholder="Email/Username" required>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-2 control-label" for="inputPassword">Password</label>
	<div class="col-sm-3">
	<input type="password" id="inputPassword" name="user_password" placeholder="Password" required>
	</div>
</div>

 <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary">Sign in</button>
    </div>
  </div>
</form>

<p><?php if (ALLOW_REGISTER == "yes"){?>
<a href="fhd_register.php" class="btn btn-default">register</a>
<?php } ?> <a href="fhd_forgotpassword.php" class="btn btn-default">forgot password</a></p>
<?php }?>

<?php include("includes/footer.php");?>
