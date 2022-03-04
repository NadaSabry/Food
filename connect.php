<?php

$host='localhost';
$user='root';
$pass='';
$db='food_db';
//$con= mysqli_connect($host, $user, $pass, $db);
$con =new mysqli($host,$user,$pass,$db);
if(!$con){
    echo 'un connect';
}

