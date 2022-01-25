<?php
include "php/header.php";
include_once 'dbconn/dbconnection.php';
if(isset($_GET["id"])){
    $idbetrag = $_GET["id"];
  }
  $selectpost = "SELECT * FROM trainingsplan WHERE id = $idbetrag";
  $coll = mysqli_query($connection, $selectpost);
  $tp = mysqli_fetch_array($coll);  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/postbearbeiten.css">
</head>

<div class="maindiv">


<form class="form" action="modtplan.php" method="POST" enctype="multipart/form-data">
                                    <div class="inputBox">
                                        <div class="inputwrap">
                                            <span>Name</span>
                                            <input type="text" name="trainingsname" value="<?php echo $tp["tname"]?>" required>
                                        </div>
                                        <div class="inputwrap">
                                            <span>Kategorie</span>
                                            <input type="text" name="trainingskategorie" value="<?php echo $tp["categorie"]?>" required>
                                        </div>
                                    </div>
                                    <div class="inputBox">  
                                        <div class="inputwrap">
                                            <span>Ubungen</span>
                                            <textarea rows="7" class="ub" name="beschreibung" placeholder="" required><?php echo $tp["ubungen"]?></textarea>
                                        </div>

                                        <div class="inputbild">
                                            <span> Bild </span>    
                                            <input class="bildhochladen" type="file" name="bild">
                                        </div>
                                    </div>

                                    <div class="btnsubmit">
                                    <input class="submitbtn" type="submit" value="Bestätigen" name="bearbeiten">
                                    </div>
                         
                                    </form>
    </div>
    
<?php
if (isset($_POST["bearbeiten"])){
    $trname = $_POST["trainingsname"];
    $trkat = $_POST["trainingskategorie"];
    $ubungen = $_POST["beschreibung"];

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
                $bildtarget = 'uploads/'.$bildNameNeu;
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

    $modtrainingp = "UPDATE trainingsplan SET id_trainer='$sessid', 
                            tname= '$trname', categorie='$trkat', ubungen = '$ubungen', bild='$bildNameNeu' 
                            WHERE id_trainer = $sessid AND id = $idbetrag";
    $stmt = mysqli_query($connection, $modtrainingp);
    if($stmt === true){
        echo "ok";
    }
    else{
        echo "scheisse";
    }
    
}
?>
<?php
    include "./php/footer.php";
?>