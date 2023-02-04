<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "quanlydathang";

$con = mysqli_connect($host, $user, $password, $database);
mysqli_set_charset($con, 'UTF8');
if (mysqli_connect_errno()){
    echo "Connection Fail: ".mysqli_connect_errno();exit;
}