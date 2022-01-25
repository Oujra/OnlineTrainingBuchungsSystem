<?php
include "php/header.php";
include_once 'dbconn/dbconnection.php';
if(isset($_GET["id"])){
    $idbetrag = $_GET["id"];
  
  $selectpost = "SELECT * FROM trainingblock WHERE id = $idbetrag";
  $collect = mysqli_query($connection, $selectpost);
  $tb = mysqli_fetch_array($collect);  
}
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


    <form class="form" action="modtrainingblock.php?id=<?php echo $idbetrag?>" method="POST" enctype="multipart/form-data" onSubmit="window.location.reload()">
        <div class="inputBox">
            <div class="inputwrap">
                <span>Name</span>
                <input type="text" name="trainingsname" value="<?php echo $tb["trainame"]?>" required>
            </div>
            <div class="inputwrap">
                <span>Kategorie</span>
                <input type="text" name="trainingskategorie" value="<?php echo $tb["categorie"]?>" >
            </div>
        </div>

        <div class="inputBox">
            <div class="inputwrap">
                <span>Kapazität</span>
                <input type="number" name="capacity" placeholder="<?php echo $tb["capacity"]?>" >
            </div>   
            <div class="inputwrap">
                <span>Dauer</span>
                <input type="text" name="dauer" placeholder="<?php echo $tb["dauer"]?>">
            </div>
        </div>

        <div class="inputBox">
            <div class="inputwrap">
                <span>Art</span>
                <input type="text" name="art" value="<?php echo $tb["art"]?>" >
            </div>   
            <div class="inputwrap">
                <span>Beschreibung</span>
                <textarea rows="7" class="bs" name="beschreibung" placeholder="" required> <?php echo $tb["beschreibung"]?> </textarea>
            </div>
        </div>

        <div class="inputBox">
            <div class="inputwrap">
                <span>Status</span>
                <div class="status">
                <select name="status" id="status" >
                <option  value="frei"> Frei </option>
                <option  value="ausgebucht"> Ausgebucht </option>
                </select>
            </div>
        </div>   
        <div class="inputwrap">
                <span>Ort</span>
                <input type="text" name="ort" placeholder="<?php echo $tb["ort"]?>" >
        </div>
        </div>                            

        <div class="inputBox">
            <div class="inputwrap">
                <span>Datum</span>
                <input type="datetime-local" name="datumzeit" >
            </div>
                                            
            <div class="inputwrap">
                <span> Bild </span>    
                <input type="file" name="bild">
            </div>
        </div>

        <div class="btnsubmit">
            
                <input class="submitbtn" type="submit" value="Bestätigen" name="bearbeiten">
        </div>
        <div class="del">
            <button class="delete" name="deletetb" > <a href="funcphp/deltrainblock.php?id=<?php echo $tb['id'] ?>"> </a> </button>
        </div>
                         
        </form>   
    </div>
    <?php
    include "./php/footer.php";
?>
<?php
if (isset($_POST["bearbeiten"])){
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

$modtraining = "UPDATE trainingblock SET trainame='$tname', 
                            categorie='$tkat', stat='$tstat', capacity=$tcap, 
                            art='$tart', beschreibung='$tbeschreib', dauer='$tdauer', 
                            ort='$tort', datetim='$tdatzeit', bild='$bildNameNeu'
                            WHERE idtrainer = $sessid AND id = $idbetrag";
$stmt = mysqli_query($connection, $modtraining);

          
}

?>