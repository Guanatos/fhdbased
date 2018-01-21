<?php
/*
settings.php

This is a generic process to list settings

- Departments
- Priorities
- Devices

*/
include("fhd_config.php");
include("includes/queries.php");
include("includes/session.php");
include("includes/checksession.php");
include("includes/checksessionadmin.php");
include("includes/header.php");
include("includes/all-nav.php");
include("includes/functions.php");
$db = mysqli_connect(db_host,db_user,db_password,db_name);
if (mysqli_connect_errno()) {
    printf("Connection failed: %s\n", mysqli_connect_error());
    exit();
}
$label = "";
$action = $_GET['action'];
$type = $_GET['type'];
$type_id = $_GET['type_id'];
$sel_query = "SELECT type, type_id, type_name FROM site_types WHERE type LIKE " . $type . " ORDER BY type_name;";
$del_query = "DELETE FROM site_types WHERE type_id = " . $type_id;
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
<html lang="en">
<head>
<meta charset="utf-8">
  <title><?php echo $label; ?></title>
</head>
<body>
<?php
//$nacl = md5(AUTH_KEY.$db->get_var("SELECT last_login FROM site_users WHERE user_id = $user_id;"));
/*
  if the action is delete
*/
if ($action == 'delete') {
   if ($db->query($del_query) == FALSE) {
     printf("Delete record failed: %s\n", $db->error);
     exit();
   }
}
$num = $db->num_rows;
echo "<h4>$num $label</h4>";
/*
  if there are records, show them
*/
if ($results = $db->query($sel_query)) {
?>
  	<table class="<?php echo $table_style_2;?>" style='width: auto;'>
  	<tr>
  		<th>Name</th>
  		<th>Edit</th>
  		<th>Delete</th>
  	</tr>
<?php
  	while ($result = $results->fetch_object()) {
      $type = $result->type;
      $type_id = $result->type_id;
  		$type_name = $result->type_name;
  		echo "<tr>\n";
  		echo "<td>$type_name</td>\n";
  		echo "<td align='center'>";
      echo "<a href='mod_settings.php?type=$type&type_id=$type_id&action=edit'>";
      echo "<i class='glyphicon glyphicon-edit' title='Edit'></i></a></td>\n";
      $deletelink = "<a href='settings.php?type=$type&type_id=$type_id&action=delete&nacl=$nacl' ";
      $deletelink = $deletelink . "onclick=\"return confirm('Are you sure you want to delete?')\">";
      $deletelink = $deletelink . "<i class='glyphicon glyphicon-remove-circle' title='Delete'></i></a>";
  		echo "<td align='center'>$deletelink</td>\n";
  		echo "</tr>\n";
    } // while
    $results->close();
?>
    <h5><i class="fa fa-plus"></i> <a href="add_settings.php?type=<?php echo $type ?>" class = "btn btn-primary">Add New</a></h5>
<?php
}
$db->close();
?>
</table>
<h5><i class="fa fa-arrow-left"></i><a href="fhd_settings.php" class="btn btn-primary"> Back to Settings</a></h5>
<?php
if(isset($_SESSION['user_name'])){
	echo "<h5>Current User: " . $_SESSION['user_name'] . "</h5>";
}
include("includes/footer.php");
?>
</body>
</html>
