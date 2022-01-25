<?php  //notikationen limitiere
    session_start();
    include_once '../dbconn/dbconnection.php';
    $sessid= $_SESSION["id"];
    $selctrolle = "SELECT * FROM nutzertabelle WHERE id ='$sessid'";  //benutzer selektieren und mit der profilbild tabelle verknüpfen
    $exce = mysqli_query($connection, $selctrolle);
    $linie = mysqli_fetch_assoc($exce);
   // echo $linie["rolle"];
   // select content 
   $selectpost = "SELECT * FROM trainingblock WHERE idtrainer = '$sessid'";
   $collect = mysqli_query($connection, $selectpost);
   $countnot = mysqli_fetch_array(mysqli_query($connection, "SELECT * FROM trainingblock WHERE idtrainer = '$sessid'"));
   $selectnotif = "SELECT * FROM notifikation WHERE id_trainer = '$sessid' AND statu = 0";
   $exnot = mysqli_query($connection, $selectnotif);
   $notify = mysqli_num_rows($exnot);
   $notrow = mysqli_fetch_array($exnot);

     $KommentarNeuCount = $_POST["KommentarNeuCount"];
     $selmaxnot = "SELECT * FROM notifikation  JOIN nutzertabelle ON notifikation.id_user = nutzertabelle.id WHERE id_trainer = '$sessid' AND statu = 0 LIMIT $KommentarNeuCount"; 
       $maxsel = mysqli_query($connection, $selmaxnot);
       $count = 0;
       while($maxnot = mysqli_fetch_array($maxsel)){?>
       <span class="icon"> <i class="fas fa-user mod"></i></span>
       <a href="funcphp/benachrichtigung.php?id=<?php echo $maxnot['id']?>"><span class="text"> Benutzer <?php echo $maxnot["benutzern"]?> hat gebucht </span> </a> <br>
<?php 
        $count++;
    }?>