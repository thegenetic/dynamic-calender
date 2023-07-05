<?php


define('DB_NAME', 'calender');
define('USERNAME', 'root');
define('PASSWORD', '');
define('HOST', 'localhost');

$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME);

if(! $conn){
    echo mysqli_connect_error()."error code : ". mysqli_connect_errno();
}
else {
    // echo "Connection Successful";
}
?>
