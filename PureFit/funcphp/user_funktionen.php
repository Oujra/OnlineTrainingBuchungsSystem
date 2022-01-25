<?php
session_start();
include_once '../dbconn/dbconnection.php';
$sessid= $_SESSION["id"];
//echo $sessid;

if (isset($_GET["id"])){
   // echo "<script> alert('Welcome $sessid')</script>";
    $idtraining = $_GET["id"];
   // echo $idtraining;
   $updatecap = "UPDATE trainingblock SET capacity = capacity + 1 WHERE id = $idtraining";
   $res = mysqli_query($connection, $updatecap);
   $deletbuchung = "DELETE FROM buchung WHERE idtrainblock = $idtraining AND idnutzer=$sessid";
   $execdel = mysqli_query($connection, $deletbuchung);
   //$notify = "INSERT INTO notifikation (id_user, id_trainer, id_beitrag) VALUES ($userid, $trainerid, $idtrblock)";
   //$resnotify = mysqli_query($connection, $notify);
   header("location: ../user.php?termin+abgebucht");
   exit();
}