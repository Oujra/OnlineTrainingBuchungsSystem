<?php
    session_start();
    include_once 'dbconn/dbconnection.php';
    $sessid= $_SESSION["id"];
   // echo $sessid, $_SESSION["un"];
    $selctrolle = "SELECT * FROM nutzertabelle WHERE id ='$sessid'";  //benutzer selektieren und mit der profilbild tabelle verknüpfen
    $exce = mysqli_query($connection, $selctrolle);
    $linie = mysqli_fetch_assoc($exce);
    //$user = mysqli_fetch_array($exce);
   // echo $linie["rolle"];
    $selbuch = "SELECT * FROM buchung JOIN trainingblock ON buchung.idtrainblock = trainingblock.id AND genehmigt = 'nein' AND beantwortet = 'nein' WHERE idnutzer = $sessid LIMIT 7 ";
    $selbex = mysqli_query($connection, $selbuch);
    $bcount = mysqli_num_rows($selbex);
    $buchung = mysqli_fetch_assoc($selbex);
    

    //select profil bild
   $slctprofbild = "SELECT * FROM profilbild WHERE benutzerid = '$sessid'";
   $collectbild = mysqli_query($connection, $slctprofbild);

   // sel notification
   $selectnotif = "SELECT * FROM usernotification WHERE userid = '$sessid'";
   $exnot = mysqli_query($connection, $selectnotif);
   $notify = mysqli_num_rows($exnot);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./styles/adminstyle.css">
    <link rel="stylesheet" href="./styles/userstyle.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
   <!-- <link rel="stylesheet" href="./style.css"> -->
    <link rel="stylesheet" href="./styles/login.css">
    <link rel="stylesheet" href="./css/all.css" >
    <script type="text/javascript" src="main.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
    <script> 
        $(document).ready(function(){
            //training stornieren
            $('.traininganul').click(function(){
                var el = this;
                var trainingid = $(this).data('id');

                // confirm Box
                bootbox.confirm("Sind Sie Sicher ? ", function(result){
                    if (result){
                        $.ajax({
                            url: 'funcphp/user_funktionen.php?id=<?php echo $row['id'] ?>',
                            type: 'POST',
                            data: {id: trainingid},
                            succes: function(response){
                                if(response==1){
                                    $(el).closest('tr').css('background', 'tomato');
                                    $(el).closest('tr').fadeOut(800, function (){
                                        $(this).remove();
                                    });
                                } else {
                                    bootbox.alert('Record not deleted');
                                }
                            }
                        });
                    }
                });
            })
        }) 
        
    </script>
</head>

        <header class="adminpage-header">
            <nav>
                <a href="index.php" class="logo"> 
                    <img src="img/fitpure.png" alt="fitpurelogo">
                </a>

                <div class="admin-header-right">
                    <div class="box">
                        <div class="notification">
                            <i id="notification" class="fas fa-bell"></i>
                            <span class="notcount"> <?php echo $notify?> </span>
                            <ul>
                                <li id="notificationslist">
                                <?php  
                                                 $selmaxnot = "SELECT * FROM usernotification JOIN nutzertabelle ON usernotification.trainerid = nutzertabelle.id WHERE userid = '$sessid' AND status = 0  ORDER BY notdate DESC";
                                                 $sel = mysqli_query($connection, $selmaxnot);
                                                 $count = 0;
                                                 while($maxnot = mysqli_fetch_array($sel)){?>
                                                   <a href="funcphp/benachrichtigung.php?id=<?php echo $maxnot['id']?>"><span class="text"> <?php echo $maxnot["benutzern"]?> hat deine Anfrage <?php echo $maxnot["erg"]?> </span> </a> <br>
                                                    <?php 
                                                    $count++;
                                                    }?>
                                </li>
                             <!--   <button id="btnmehrcoms">mehr zeigen</button> -->
                            </ul>
                        </div>             
                    </div>
                    
                <!--    <a id="notification" href=""> <i class="far fa-bell "> <span> <?php echo $notify?>  </span> </i> </a>-->
                    
                </div>   
            </nav>
        </header>

        <nav class="sidemenu">
            
            <div class="s-m-t">
            <div class="logout">
                <a href="dbconn/logout.php" id="logout">  <span class="material-icons">logout </span> </a>
            </div> 
            </div>
            <div class="profilinfo">
                <div class="profilimg">
                    <?php 
                        while($pbrow = mysqli_fetch_array($collectbild)){
                            if($pbrow['status'] == 1){
                                echo '<img src="uploads/profil'.$sessid.'.jpg">';
                            }
                            else{
                                echo '<img src="img/maxmusterman.png" alt="">';
                            }
                        } 
                                
                    ?>
                    
                </div>

                <form action="funcphp/profilimg.php" method="POST" enctype="multipart/form-data">
                          <label for="profimg"> 
                          <i class="material-icons">add_photo_alternate</i>    
                           Bild </label>
                          <input id="profimg" type="file" name="bild">
                          <button type="submit" name="prfbakt"> 
                          <i class="material-icons">check_circle</i>
                          </button>
                        
                </form>





             <div class="profilcontent">
                <div class="details">
                    <h2> <?php echo $linie['benutzern']?> <br> <span> <?php echo $linie['rolle']?> </span> </h2>
                </div>
             </div>
            </div>
         
            <ul>
                
          
            <li> <span>Dashboard</span></li>
                <li> <i class="fas fa-business-time"></i> <a href="">  <span class="notcount"> <?php echo ''?> </span> Anfragen </a></li>
                <li> <i class="fab fa-modx"></i> <a href="trainingsblöcke"> <span> Trainings </span> </a> </li>
                <li> <i class="far fa-calendar-alt"></i> <span>Termine</span></li>
                <li> <i class="far fa-heart"></i> <span> Favoriten </span></li>
            <!--    <li> <i class="far fa-envelope"></i><span> Nachrichten</span></li> -->
            </ul>  
            <div>
                
            <button class="löschen" onClick="confirmvorloeschen()" name="delete"> Konto Löschen </button>
               <script>
                   function confirmvorloeschen(){
                    var confmodal = document.getElementById("confirmmodal");
                     confmodal.style.display = "block";
                    var span = document.getElementsByClassName("close")[0];
                        }
               </script>
            </div> 
        </nav>

        <div class="user-main-container">
            <div class="sectiontitel"><p class="titletext"> Anfragen </p></div>  
             <section class="anfragen-section">
             <?php  
                    $counter = 0;
    $selbex = mysqli_query($connection, $selbuch);
                    while($row = mysqli_fetch_array($selbex)){
                        $tid = $row["id"];
                     echo  '<div class="anfragen">'?>
                        <div class="trainingimg">
                            <img src="uploads/<?php echo ($row['bild'])?>" alt="">
                        </div>
                        <div class="trainingsinfo">
                            <h1>Trainingsname :<?php echo $row["trainame"]?> </h1>
                            <p>  Status : <span> <?php echo $row["stat"]?> </span> </p>
                        </div>
                        <div class="anulieren">
                        
                            <button class="traininganul"  onClick="openmodalstornieren()" name="tranulieren"> <span class="material-icons">delete</span> </button> 
                        
                        </div>
                   <?php echo '</div>';
                        $counter++;
                    }
                ?>
                
             </section>

             <div class="sectiontitel"><p class="titletext"> Training </p></div>
             <section class="training">
                 <?php
                    $selbuch = "SELECT * FROM buchung JOIN trainingblock ON buchung.idtrainblock = trainingblock.id WHERE idnutzer = $sessid AND genehmigt = 'ja' ORDER BY termin DESC";
                    $selbex = mysqli_query($connection, $selbuch);
                    $bcount = mysqli_num_rows($selbex);
                    $buchung = mysqli_fetch_assoc($selbex);
                    //JOIN trainingblock ON buchung.idtrainblock = trainingblock.id
                 ?>
                 <?php
                    $counter = 0;
                    while($rowter = mysqli_fetch_array($selbex)){
                        echo'<div class="admin-content">'?>
                            <h1> Sie haben am : <span><?php echo $rowter["termin"]?></span> </h1>
                            <h1> einen Training : <span> <?php echo $rowter["trainame"]?> </span> </h1>
                            <h1> Ort : <span> <?php echo $rowter["ort"]?> </span> </h1>
                        <div></div>
                    <?php echo '</div>';
                        $counter++;
                    }
                ?>
             </section>

             <div class="sectiontitel"><p class="titletext"> favoriten </p></div>
             <section class="fav">
                
                <div class="admin-content">
                        <div>
                            
                        </div>
                    </div>
             </section>
            
            
            
            </div>
                  

            
        <!-- Confirm Modal before Account Delete-->
            <div class="confirm-modal" id="confirmmodal">
                <div class="modalcontent">
                    <div class="modheader">
                        <h2> Sind Sie sicher ?</h2>
                    </div>
                    <div class="modalbody">
                        <p> Bitte beachten Sie, dass Sie ihren Konto nicht mehr wiederherstellen können, falls Sie Ihre Meinung ändern.
                            Alle mit diesem Konto verknüpften Daten und Inhalte wie E-Mails, Dateien, Kalender und Fotos gehen verloren.
                            Sie verlieren den Zugriff auf Inhalte, die Sie gespeichert haben und mehr.
                        </p>
                    </div>
                    <div class="modalbtn"> 
                         <h1> Das Löschen ist unwiederuflich </h1>
                         <button> <a  name="delete" href="funcphp/löschen.php?id=<?php echo  $sessid ?>">  delete </a> </button> 
                        <button> abrechen </button>
                    </div>
                    
                </div>

            </div>
        <!-- Confirm Modal before Delete Appointement-->
                    <div class="training-delete-modal" id="terminlöschen">
                        <div class="content">
                            <div class="headermodal">
                                <h4 class="titel"> <i class="fas fa-exclamation-circle"></i>Trainingstermin stornieren</h4>
                            </div>
                       
                            <div class="modal-body">
                                 <p> Sind Sie Sicher, dass Sie nicht mehr teilnehmen wollen ? </p>
                                 <?php $st = "SELECT * From trainingblock WHERE id = $tid";
                                       $exec = mysqli_query($connection, $st);
                                       $rowt = mysqli_fetch_array($exec); ?>
                                 <button> <a  name="delete" href="funcphp/user_funktionen.php?id=<?php echo $rowt['id']?>">  delete </a> </button> 
                        <!--    <form action="funcphp/user_funktionen.php?id=<?php echo $rowt['idtrainblock']?>" method="POST">
                                <input class="traininganul" type="submit" value="stornieren" name="tranulieren">
                            </form> -->
                                 
                            </div>
                        </div>
                    </div>
        <main>

        </main>

        <?php
    include "./php/footer.php";
?>