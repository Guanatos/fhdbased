<?php
// This is a boolean function to identify duplicates on a given table
// There are 3 parameters, table, field and value
function ifexist($table, $field, $id) {
	$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
	$var = $db->get_var("SELECT count($field) FROM $table WHERE $field LIKE '$id'");
// $db->debug();
	return $var;
}

// This is a boolean function to identify duplicates on a site_types table
// There are 3 parameters, table, field and value
function if_type_exist($type, $type_name) {
	$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
	//print_r("type: ". $type);
	//print_r("type name: ". $type_name);
	$result = 0;
	$result = $db->get_var("SELECT COUNT(type) FROM site_types WHERE type = $type AND type_name LIKE '$type_name'");
	//$db->debug();
  //print_r("result: ". $result);
	return $result;
}

// Review if the provided ID is numeric
function check_id($id) {
	if(!is_numeric($id)) {
		echo "<p>ID is not numeric</p>";
		exit;
	} else {
		return $id;
	}
}

function valid_user($id) {
if(!is_numeric($id)){
	echo "<p>Invalid ID (1)</p>";
	exit;
}else{
	$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
	$id = $db->escape($id);
	$v = $db->get_var("SELECT count(user_id) FROM site_users WHERE user_id = $id;");
		if ($v == 1) {
			return $id;
		}else{
			echo "<p>Invalid ID (2)</p>";
			exit;
		}
	}
}

function valid_id($id) {
if(!is_numeric($id)){
	echo "<p>Invalid ID (1)</p>";
	exit;
}else{
	$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
	$id = $db->escape($id);
	$v = $db->get_var("SELECT count(call_id) from site_calls where call_id = $id;");
		if ($v == 1) {
			return $id;
		}else{
			echo "<p>Invalid Call ID</p>";
			exit;
		}
	}
}

// Verify that this is a valid password
function check_pwd($password,$user_login) {
	include("includes/PasswordHash.php");
	$hasher = new PasswordHash(8, false);
	$stored_hash = "*";
	$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
	// $db->debug();
	if ( $db->get_var("SELECT option_value FROM site_options WHERE option_name = 'encrypted_passwords';") == "yes" ) {
	//if encryption is ON
		$stored_hash = $db->get_var("SELECT user_password from site_users WHERE user_login = '$user_login' OR user_email = '$user_login' LIMIT 1;");
		$check = $hasher->CheckPassword($password, $stored_hash);
		if ($check) {
			$return_value = TRUE;
		} else {
			$return_value = FALSE;
		}
	//if encryption is OFF
	} else {
		$num = $db->get_var("SELECT count(user_id) FROM site_users WHERE (user_login = '$user_login' OR user_email = '$user_login') AND user_password = BINARY '$password' AND user_pending = 0 limit 1;");
		if ($num == 1) {
			$return_value = TRUE;
		} else {
			$return_value = FALSE;
		}
	}
return $return_value;
}

function makepwd($password) {
	$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
	if ( $db->get_var("SELECT option_value FROM site_options where option_name = 'encrypted_passwords';") == "yes" ) {
		//if encryption is ON
		include("includes/PasswordHash.php");
		$hasher = "*";
		$hasher = new PasswordHash(8, false);
		$return_pass = $hasher->HashPassword($password);
		//if encryption is OFF
	}else{
		$return_pass = trim( $db->escape($password) );
	}
return $return_pass;
}

//send user a closed ticket message.
function sendmessage_closed( $call_id ) {
$call_id = valid_id($call_id);
$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
	$mail = new PHPMailer();
	//Set who the message is to be sent from
	$mail->SetFrom(FROM_EMAIL);
	//Set who the message is to be sent to
	$call_email = $db->get_var("SELECT call_email FROM site_calls WHERE call_id = $call_id;");
	$mail->AddAddress($call_email);
	//Set the subject line
	$mail->Subject = 'Ticket '.FHD_TITLE. ' [# '.$call_id.'] Closed.';
	//Read an HTML message body from an external file, convert referenced images to embedded, convert HTML into a basic plain-text alternative body
	$call_solution = $db->get_var("SELECT call_solution FROM site_calls WHERE call_id = $call_id;");
	$econtent = "Ticket Closed.<br><hr>".$call_solution;
	$mail->MsgHTML($econtent."<br>");
	//Send the message
	$mail->Send();
}

function stri_replace( $find, $replace, $string ) {
// Case-insensitive str_replace()

  $parts = explode( strtolower($find), strtolower($string) );

  $pos = 0;

  foreach( $parts as $key=>$part ){
    $parts[ $key ] = substr($string, $pos, strlen($part));
    $pos += strlen($part) + strlen($find);
  }

  return( join( $replace, $parts ) );
}


function check_email_address($email) {
 if (!preg_match("/^( [a-zA-Z0-9] )+( [a-zA-Z0-9\._-] )*@( [a-zA-Z0-9_-] )+( [a-zA-Z0-9\._-] +)+$/" , $email)) {
  return false;
 }
 return true;
}

// Yes with success button
// No with warning button
function yesno($value) {
	$result = ("yes" == $value) ? "<span class='label label-success'>Yes</span>" : "<span class='label label-warning'>No</span>";
	return $result;
}

// 1 with success button
// 0 with warning button
function onoff($value) {
	$result = ("1" == $value) ? "<span class='label label-success'>Yes</span>" : "<span class='label label-warning'>No</span>";
	return $result;
}

function show_user_level($type) {
switch ($type) {
    case 0:
        $show_user_level = "Administrator";
        break;
    case 1:
        $show_user_level = "User";
		break;
    case 2:
        $show_user_level = "Support Staff";
		break;
    case 3:
        $show_user_level = "";
		break;
	}
	return $show_user_level;
}

// Show the type name depending on EU selection
function show_type_name($type) {
switch ($type) {
    case 0:
        echo "Support Staff";
        break;
    case 1:
        echo "Departments";
		break;
    case 2:
        echo "Priorities";
		break;
    case 3:
        echo "Device Type";
		break;
 }
}

function show_type_col($type) {
switch ($type) {
    case 0:
        $show_type_col = "call_staff";
        break;
    case 1:
        $show_type_col = "call_department";
		break;
    case 2:
        $show_type_col = "call_request";
		break;
    case 3:
        $show_type_col = "call_device";
		break;
	}
	return $show_type_col;
}


function call_status($value) {
switch ($value) {
    case '0':
        $value = "Active";
        break;
    case '1':
        $value = "Closed";
		break;
    case '3':
        $value = "Deleted";
		break;
	}
	return $value;
}

///////////
function generatePassword($length=9, $strength=0) {
	$vowels = 'aeuy';
	$consonants = 'bdghjmnpqrstvz';
	if ($strength & 1) {
		$consonants .= 'BDGHJLMNPQRSTVWXZ';
	}
	if ($strength & 2) {
		$vowels .= "AEUY";
	}
	if ($strength & 4) {
		$consonants .= '23456789';
	}
	if ($strength & 8) {
		$consonants .= '@#$%';
	}

	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
}
?>
