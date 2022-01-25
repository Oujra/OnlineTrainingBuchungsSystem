<?php

function func_alert($benachrichtigung){
    echo "<script>alert('$benachrichtigung');</script>";
}


session_start();
include_once '../dbconn/dbconnection.php';
$selecttrblock = "SELECT * FROM trainingblock";
$exe = mysqli_query($connection, $selecttrblock);
$trainingbc = mysqli_fetch_array($exe);
$userid = $_SESSION["id"];


if(isset($_GET["id"])){
    $idtrblock = $_GET["id"];
    echo $idtrblock;
    $selecttrblock = "SELECT * FROM trainingblock WHERE id = $idtrblock";
    $exe = mysqli_query($connection, $selecttrblock);
    $trainingbc = mysqli_fetch_array($exe);
  /*  $selectuser = "SELECT * FROM nutzertabelle WHERE id = $userid";
    $seluser = mysqli_query($connection, $selectuser);
    $user = mysqli_fetch_array($selectuser);*/
    $tracap = $trainingbc["capacity"];
    $trainerid = $trainingbc["idtrainer"];
    $trainort = $trainingbc["ort"];
    $trainingid = $trainingbc["id"];
    $trainerid = $trainingbc["idtrainer"];
    $trainingtermin = $trainingbc["datetim"];
    if($tracap>0){
        $updatecap = "UPDATE trainingblock SET capacity = capacity - 1 AND stat = 'frei' WHERE id = $idtrblock";
        $res = mysqli_query($connection, $updatecap);
        $notify = "INSERT INTO notifikation (id_user, id_trainer, id_beitrag) VALUES ($userid, $trainerid, $idtrblock)";
        $resnotify = mysqli_query($connection, $notify);

        $buchung = "INSERT INTO buchung (idtrainer, idnutzer, idtrainblock, ort, termin, genehmigt)
                     VALUES ($trainerid, $userid, $trainingid, '$trainort', '$trainingtermin', 'nein' )";
        $buchungval = mysqli_query($connection, $buchung);             
        
        header("location: ../index.php");
        exit();
     //   echo'gemacht';
     //   echo $tracap;
        
    }
    else {
        //func_alert("leider ausgebucht");
        $updatecap = "UPDATE trainingblock SET stat = 'ausgebucht' WHERE id = $idtrblock";
        $res = mysqli_query($connection, $updatecap);
        echo "<script>alert('leider ausgebucht');</script>";
        header("location: ../index.php");
        exit();
    //echo 'ausgebucht';
    //echo $tracap;
    }
    
}


