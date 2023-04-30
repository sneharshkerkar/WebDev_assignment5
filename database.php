<?php

$db_name = "mysql:host=localhost;dbname=cubicle_booking";
$username= "root";
$password= "";
$conn = new PDO($db_name,$username,$password);

if($conn==TRUE){
    
}
else{
    echo "Not established";
}
?>