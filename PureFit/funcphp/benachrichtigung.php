<?php
 session_start();
 include_once '../dbconn/dbconnection.php';


 if(isset($_POST['accept'])){
     $idbeitrag = $_GET["id"];
     $idUser = $_GET["user"];
     //fetch trainblock 
     $seltb = "SELECT * FROM trainingblock WHERE id = $idbeitrag";
     $ex = mysqli_query($connection, $seltb);
     $fetchtb = mysqli_fetch_array($ex);
     $trid = $fetchtb["idtrainer"];
     $trname = $fetchtb["trainame"];
   //  echo $idbeitrag, $trid, $trname, ''. $idUser;
     $updatebuchung = "UPDATE buchung SET genehmigt = 'ja', beantwortet = 'ja' WHERE idtrainblock = $idbeitrag AND idnutzer = $idUser";
     $res = mysqli_query($connection, $updatebuchung);
     $usernotif = "INSERT INTO usernotification (trainblockid, trainerid, status, traininame, erg, userid)
                    VALUES ($idbeitrag, $trid, 0, '$trname', 'genehmigt', $idUser)";
     $resnot = mysqli_query($connection, $usernotif);
     header("location: ../admin.php");
     exit();
 }

 if(isset($_POST['decline'])){
    $idbeitrag = $_GET["id"];
    $idUser = $_GET["user"];
    $seltb = "SELECT * FROM trainingblock WHERE id = $idbeitrag";
     $ex = mysqli_query($connection, $seltb);
     $fetchtb = mysqli_fetch_array($ex);
     $trid = $fetchtb["idtrainer"];
     $trname = $fetchtb["trainame"];
   // echo $idbeitrag;
    $updatebuchung = "UPDATE buchung SET genehmigt = 'nein', beantwortet = 'ja' WHERE idtrainblock = $idbeitrag AND idnutzer = $idUser";
     $res = mysqli_query($connection, $updatebuchung);
    $updatetrainb = "UPDATE trainingblock SET capacity = capacity + 1 WHERE id = $idbeitrag";
     $exres = mysqli_query($connection, $updatetrainb);
    $usernotif = "INSERT INTO usernotification (trainblockid, trainerid, status, traininame, erg, userid)
     VALUES ($idbeitrag, $trid, 0, '$trname', 'abgelehnt', $idUser)";
    $resnot = mysqli_query($connection, $usernotif);
     header("location: ../admin.php");
        exit();
    //echo "dec";
}

