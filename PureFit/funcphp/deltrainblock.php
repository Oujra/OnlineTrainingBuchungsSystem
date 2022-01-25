<?php

session_start();
include_once '../dbconn/dbconnection.php';

if(isset($_GET["id"])){
    $iddel = $_GET["id"];
    echo $iddel;
//   $tbloechen = "DELETE FROM trainingblock WHERE id = '$iddel';";
//    $res = mysqli_query($connection, $tbloechen);
//    header("location: ../admin.php");
//    exit();
}