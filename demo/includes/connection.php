<?php
$website="https://erp.aecindia.net/demo";
$servername="localhost";
$username="u145503039_aec_backupdb";
$password="rV6vb3Dtq!";
$dbname="u145503039_backup_aec";
$conn=mysqli_connect($servername,$username,$password,$dbname);
if(!$conn)
{
    die("connection failed:".mysqli_connect_error());
}
// else{
// 	echo "success";
// }
?>