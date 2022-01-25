<?php
include "php/header.php";
include_once 'dbconn/dbconnection.php';
if(isset($_GET["id"])){
    $idbetrag = $_GET["id"];
  }
  $selectpost = "SELECT * FROM fitnesrezept WHERE id = $idbetrag";
  $collect = mysqli_query($connection, $selectpost);
  $fr = mysqli_fetch_array($collect);  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="./styles/postbearbeiten.css">
</head>
<div class="maindiv">
                        <form class="form" action="modrezept.php?id=<?php echo $idbetrag?>" method="POST" enctype="multipart/form-data" >
                                    <div class="inputBox">
                                        <div class="inputwrap">
                                            <span>Titel</span>
                                            <input type="text" name="Rezepttitel" value="<?php echo $fr['rezeptitel']?>" required> 
                                        </div>
                                        <div class="inputwrap">
                                            <span>Zutaten</span>
                                            <textarea rows="7" class="zt" name="zutaten" placeholder="<?php echo $fr['zutaten']?>" required> <?php echo $fr['zutaten']?> </textarea>
                                        </div>
                                    </div>
                                    <div class="inputBox">  
                                        <div class="inputwrap">
                                            <span>Zubereitung</span>
                                            <textarea rows="7" class="zb" name="zubereitung" placeholder="" required> <?php echo $fr['zubereitung']?> </textarea>
                                            
                                        </div>
                                        <div class="inputwrap">
                                        <span> Nährwerte </span> 
                                            <textarea rows="1" class="nw" name="naehrwert" placeholder="" required> <?php echo $fr['naehrwert']?> </textarea>
                                        </div>

                                        <div class="inputbild">
                                            <span> Bild </span>    
                                            <input class="bildhochladen" type="file" name="bild">
                                        </div>
                                    </div>

                                    <div class="btnsubmit">
                                    <input class="submitbtn" type="submit" value="bearbeiten" name="bearbeiten">
                                    </div>
                         
                                    </form>                   
                     
                
                    
                    </div>

                    <?php
if (isset($_POST["bearbeiten"])){

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

  
    $inserttp = "UPDATE fitnesrezept SET rezeptitel = '$titel', zutaten = '$zutaten', zubereitung = '$zubereitung', 
                naehrwert = '$nahrwert', bild='$bildNameNeu', benutzerid = $sessid
                WHERE benutzerid = $sessid AND id = $idbetrag  ";
    $strz = mysqli_query($connection, $inserttp);
    header("location: ../admin.php");
    exit();
    
        

}
?>
                    <?php
    include "./php/footer.php";
?>