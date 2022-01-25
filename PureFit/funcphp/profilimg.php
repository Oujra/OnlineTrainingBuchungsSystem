<?php
session_start();
include_once '../dbconn/dbconnection.php';
$sessid= $_SESSION["id"];
//echo $sessid;

if (isset($_POST["prfbakt"])){
    $bild = $_FILES['bild']; //Infos über den file
    //alle informationen etrahieren
    $bildname = $_FILES['bild']['name'];
    $bildTmpName = $_FILES['bild']['tmp_name'];
    $bildSize = $_FILES['bild']['size'];
    $bildError = $_FILES['bild']['error'];
    $bildType = $_FILES['bild']['type'];
    //Type erlauben

    $bildExt = explode('.', $bildname); //wir wollen den string nach dem Punkt
    $bildAktuExt = strtolower(end($bildExt));

    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    if(in_array($bildAktuExt, $allowed)){
        if($bildError===0){
            if($bildSize < 300000){
                $bildNameNeu = "profil".$sessid.".".$bildAktuExt;
                $bildtarget = '../uploads/'.$bildNameNeu;
                move_uploaded_file($bildTmpName, $bildtarget);
                $sql = "UPDATE profilbild SET status = 1 WHERE benutzerid = $sessid";
                $res = mysqli_query($connection, $sql);
            }else{
                echo "Bild ist zu gross";
            }
        } else {
            echo "Etwas ist schief gelaufen";
        }
    }
    else {
        echo "Bild Extension nicht Erlaubt";
    }
    header("location: ../admin.php");
    exit();
}