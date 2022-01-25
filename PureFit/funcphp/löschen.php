<?php

session_start();
include_once '../dbconn/dbconnection.php';

if(isset($_GET["id"])){
    $iddel = $_GET["id"];
   // echo $iddel;
    $nutzerlöschen = "DELETE FROM nutzertabelle WHERE id = '$iddel';";
    $res = mysqli_query($connection, $nutzerlöschen);
    header("location: ../login.php");
}