<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname ="php";
$conn = new mysqli($servername,$username,$password,$dbname,3307);
if($conn->connect_error){
    die("Connection failed ".$conn->connect_error);
}
else{
    //  echo "Successfully Connected";
}
?>