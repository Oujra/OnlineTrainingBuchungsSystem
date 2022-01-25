<?php
session_start();
include_once '../dbconn/dbconnection.php';
$sessid= $_SESSION["id"];
echo $sessid;

if (isset($_POST["posten"])){
    $tname = $_POST["trainingsname"];
    $tkat = $_POST["trainingskategorie"];
    $tcap = $_POST["capacity"];
    $tdauer = $_POST["dauer"];
    $tart = $_POST["art"];
    $tbeschreib = $_POST["beschreibung"];
    $tstat = $_POST["status"];
    $tort = $_POST["ort"];
    $tdatzeit = $_POST["datumzeit"];

    //fürs Bild
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
                $bildNameNeu = uniqid('', true).".".$bildAktuExt;
                $bildtarget = './uploads/'.$bildNameNeu;
                move_uploaded_file($bildTmpName, $bildtarget);
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
//echo $tname,$tkat,$tstat,$tdauer, $tdatzeit, $tbeschreib, $tart, $tort, $tcap, $sessid;

$inserttraining = "INSERT INTO trainingblock (idtrainer, trainame, categorie, stat, capacity, art, beschreibung, dauer, ort, datetim, bild) VALUES
                   ($sessid, '$tname', '$tkat', '$tstat', $tcap, '$tart', '$tbeschreib', '$tdauer', '$tort', '$tdatzeit',  '$bildNameNeu');";
$stmt = mysqli_query($connection, $inserttraining);



if($stmt === true){
    header("location: ../admin.php?Trainingsblockerfolgreichhizugefügt");
    echo $bildExt;
    exit();
} else {
    header("location: ../admin.php?fehlerbeimHinzufügen");
    exit();
 }                   
}

if (isset($_POST["tppost"])){
    $trname = $_POST["trainingsname"];
    $trkat = $_POST["trainingskategorie"];
    $ubungen = $_POST["beschreibung"];

    
    
    //fürs Bild
    $bild = $_FILES['image']; //Infos über den file
    //alle informationen etrahieren
    $bildname = $_FILES['image']['name'];
    $bildTmpName = $_FILES['image']['tmp_name'];
    $bildSize = $_FILES['image']['size'];
    $bildError = $_FILES['image']['error'];
    $bildType = $_FILES['image']['type'];
    //Type erlauben

    $bildExt = explode('.', $bildname); //wir wollen den string nach dem Punkt
    $bildAktuExt = strtolower(end($bildExt));

    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    if(in_array($bildAktuExt, $allowed)){
        if($bildError===0){
            if($bildSize < 500000){
                $bildNameNeu = uniqid('', true).".".$bildAktuExt;
                $bildtarget = './uploads/'.$bildNameNeu;
                move_uploaded_file($bildTmpName, $bildtarget);
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
  //  echo $trname, $trkat, $ubungen;
    $inserttp = "INSERT INTO trainingsplan (id_trainer, tname, categorie, ubungen, bild) VALUES
                   ($sessid, '$trname', '$trkat', '$ubungen', '$bildNameNeu');";
    $sttp = mysqli_query($connection, $inserttp);
    $check = mysqli_stmt_affected_rows($sttp);
    
    if($sttp === true){
        header("location: ../admin.php?Trainingsplanerfolgreichhizugefügt");
        exit();
    } else {
        header("location: ../admin.php?fehlerbeimHinzufügen");
        exit();
     }      
}


//REZEPTE
if (isset($_POST["rezpost"])){
    $titel = $_POST["Rezepttitel"];
    $zutaten = $_POST["zutaten"];
    $zubereitung = $_POST["zubereitung"];
    $nahrwert = $_POST["naehrwert"];
    
    //fürs Bild
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
            if($bildSize < 500000){
                $bildNameNeu = uniqid('', true).".".$bildAktuExt;
                $bildtarget = './uploads/'.$bildNameNeu;
                move_uploaded_file($bildTmpName, $bildtarget);
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

  
    $inserttp = "INSERT INTO fitnesrezept (rezeptitel, zutaten, zubereitung, naehrwert, bild, benutzerid) VALUES
                   ('$titel', '$zutaten', '$zubereitung', '$nahrwert', '$bildNameNeu', $sessid);";
    $strz = mysqli_query($connection, $inserttp);
    
    if($strz === true){
        header("location: ../admin.php?Rezepterfolgreichhizugefügt");
        exit();
    } else {
        header("location: ../admin.php?fehlerbeimHinzufügen");
        exit();
     }      
}