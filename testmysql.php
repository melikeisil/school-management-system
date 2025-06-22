<?php
/*
* Change the value of $password if you have set a password on the root userid
* Change NULL to port number to use DBMS other than the default using port 3306
*
*/
$conn = mysqli_connect("localhost", "root", "", "school");
if (!$conn) {
    die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}
echo '<p>Connection OK '. mysqli_get_host_info($conn).'</p>';
echo '<p>Server '. mysqli_get_server_info($conn).'</p>';
echo '<p>Initial charset: '. mysqli_character_set_name($conn).'</p>';
mysqli_close($conn);
?>
