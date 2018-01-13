<?php

include("fhd_config.php");

//$link = mysqli_connect("localhost", "fhdbased", "t3l05ab3s", "fhdbased");

$link = mysqli_connect(db_host,db_user,db_password,db_name);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

/* check if server is alive */
if (mysqli_ping($link)) {
    printf ("Our connection is ok!\n");
} else {
    printf ("Error: %s\n", mysqli_error($link));
}

/* close connection */
mysqli_close($link);
?>
