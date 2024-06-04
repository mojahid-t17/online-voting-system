<?php
$host = "localhost";
$user_name="root";
$password = "";
$db_name= "voting_system";
$connect=mysqli_connect($host,$user_name, $password,$db_name);
// if($connect){
//     echo"database connect";

// }
// else{
//     echo"connect failed";
// }
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>