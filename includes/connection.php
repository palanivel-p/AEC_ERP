<?php
$website="https://erp.aecindia.net";
$servername="localhost";
$username="u145503039_aec_developer";
$password="2Eb|DN:8wB";
$dbname="u145503039_aec_db";
$conn=mysqli_connect($servername,$username,$password,$dbname);
if(!$conn)
{
    die("connection failed:".mysqli_connect_error());
}
// else{
// 	echo "success";
// }
?>