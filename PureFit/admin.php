<?php
    session_start();
    include_once 'dbconn/dbconnection.php';
    $sessid= $_SESSION["id"];
    //echo $sessid;
    $selctrolle = "SELECT * FROM nutzertabelle WHERE id ='$sessid'";  //benutzer selektieren und mit der profilbild tabelle verknüpfen
    $exce = mysqli_query($connection, $selctrolle);
    $linie = mysqli_fetch_assoc($exce);
   // echo $linie["rolle"];
   // select content 
   $selectpost = "SELECT * FROM trainingblock WHERE idtrainer = '$sessid'";
   $collect = mysqli_query($connection, $selectpost);
   $countnot = mysqli_fetch_array(mysqli_query($connection, "SELECT * FROM trainingblock WHERE idtrainer = '$sessid'"));
   $selectnotif = "SELECT * FROM buchung WHERE idtrainer = '$sessid' AND genehmigt='nein' ";
   $exnot = mysqli_query($connection, $selectnotif);
   $notify = mysqli_num_rows($exnot);
   $notrow = mysqli_fetch_array($exnot);
   //select Trainpläne
   $seltrainplan = "SELECT * FROM trainingsplan WHERE id_trainer = '$sessid'";
   $collecttp = mysqli_query($connection, $seltrainplan);
   // $tp = mysqli_fetch_assoc($collecttp);
   //selct nutzer die gebucht haben 
   $selnot = "SELECT * FROM buchung JOIN nutzertabelle ON buchung.idtrainer = nutzertabelle.id WHERE idtrainer = '$sessid' AND genehmigt = 'nein' LIMIT 5"; 
   $notsel = mysqli_query($connection, $selnot);
   $notfikation = mysqli_fetch_array($notsel);
   $notRow = mysqli_fetch_array($notsel);

   //select profil bild
   $slctprofbild = "SELECT * FROM profilbild WHERE benutzerid = '$sessid'";
   $collectbild = mysqli_query($connection, $slctprofbild);
  

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./styles/adminstyle.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <script type="text/javascript" src="main.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   <!--  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
   <link rel="stylesheet" href="./style.css"> -->
   <script>
       $(document).ready(function(){
    var KommentarCount = 5;
    $("#btnmehrcoms").click(function(){
       KommentarCount = KommentarCount + 2;
       $("#notificationslist").load("funcphp/notificationsload.php", {
          KommentarNeuCount: KommentarCount
       });
    });
  });
   </script>
    <link rel="stylesheet" href="./styles/login.css">
    <link rel="stylesheet" href="./css/all.css" >
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
                                    <?php  //notikationen limitiere
                                                 $selmaxnot = "SELECT * FROM notifikation  JOIN nutzertabelle ON notifikation.id_user = nutzertabelle.id WHERE id_trainer = '$sessid' AND statu = 0  ORDER BY notfdate DESC"; 
                                                 $maxsel = mysqli_query($connection, $selmaxnot);
                                                 $count = 0;
                                                 while($maxnot = mysqli_fetch_array($maxsel)){?>
                                                <!--   <span class="icon"> <i class="fas fa-user mod"></i></span>-->
                                                   <a href="funcphp/benachrichtigung.php?id=<?php echo $maxnot['id']?>"><span class="text"> Benutzer <?php echo $maxnot["benutzern"]?> hat gebucht </span> </a> <br>
                                                    <?php 
                                                    $count++;
                                                    }?>
                                </li>
                            <!--    <button id="btnmehrcoms">mehr zeigen</button> -->
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
                            else {
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
                    <h2> <?php echo $linie["benutzern"] ?> <br> 
                    <span> <?php echo $linie["rolle"] ?> </span> <br>
                    <?php echo $linie["email"] ?> 
                    </h2>
                </div>
             </div>
              <!--   <div class="profilcart">
                <div class="front">
                <img src="img/fitpure.png" alt="">
                </div>
                <div class="back">
                    <p class="name"> <?php echo $linie["nachname"];?></p>
                    <p class="email"> <?php echo $linie["email"];?> </p>
                    <p class="Tel"> 0123456789 </p>
                </div>
                </div>
               <div class="inputwrap">    
                <input type="file" name="bild">
                </div>-->
            </div> 
            <ul>
                <li> <span>Dashboard</span></li>
                <li> <i class="fas fa-business-time"></i> <a href="#anfragen">  <span class="notcount">  <?php echo $notify?>  </span> Anfragen </a></li>
                <li> <i class="fab fa-modx"></i> <a href="#trainingsblöcke"> <span> Trainings </span> </a> </li>
                <li> <i class="far fa-calendar-alt"></i> <a href="#trainingsplan"> <span> trainingsplan </span></li>
                <li> <i class="fas fa-tasks"></i> <a href="#rezepte"> <span> Rezepte </span></li>
            </ul> 
             
        </nav>
        
                                                
                                               
        
            <div class="admin-main-container">
            <div class="sectiontitel"><p class="titletext"> Anfragen </p></div>  
                <section id="anfragen">
                    <div class="anfragen">
                        
                       
                            <?php   $selbuchung = "SELECT * FROM buchung WHERE idtrainer = '$sessid' AND genehmigt = 'nein' AND beantwortet = 'nein' LIMIT 7"; 
                                    $buchsel = mysqli_query($connection, $selbuchung); 
                                    //$buchung = mysqli_fetch_array($buchsel);
                                                
                        $count = 0;
                        while ($buchung = mysqli_fetch_array($buchsel)){
                            $idus = $buchung["idnutzer"];
                            $idtrb = $buchung["idtrainblock"];
                            echo ' <div class="anfragenkarte"> ';?>
                                <div class="anfragenbestatigen">
                                    <div class="image"> </div>
                                    <div class="anfragetext">
                                        <span class="datum"></span>
                                        <?php $seluser = "SELECT * FROM buchung JOIN nutzertabelle ON buchung.idnutzer = nutzertabelle.id WHERE idnutzer = '$idus' AND genehmigt = 'nein'";
                                              $usersel = mysqli_query($connection, $seluser); 
                                              $user = mysqli_fetch_array($usersel); 
                                              // select trainingsinfo
                                              $seltrain = "SELECT * FROM trainingblock WHERE id = '$idtrb'";
                                              $trainsel = mysqli_query($connection, $seltrain); 
                                              $trainings = mysqli_fetch_array($trainsel);
                                              ?>
                                        <h2> User: <?php echo $user["benutzern"]?> </h2>
                                        <h2> Taining-id: <?php echo $buchung["idtrainblock"]?> </h2>
                                        <h2> Termin: <?php echo $buchung["termin"]?> </h2>
                                        <h2> Ort: <?php echo $buchung["ort"]?> </h2>
                                        
                
                                    </div>
                                    <div class="anfrageaction">
                                        <form action="funcphp/benachrichtigung.php?id=<?php echo $buchung['idtrainblock'] ?>&user=<?php echo $idus?>" method="POST">
                                                    <input type="submit" value="bestätigen" name="accept">
                                                    <input type="submit" value="ablehnen" name="decline">
                                        </form>
                                    </div>
                                </div>
                         <?php echo '</div>';
                              $count++;
                }  
                ?>
                            
                    </div>
                </section>
                <!--      TRAININGSBLOCK                   --->
            <div class="sectiontitel"><p class="titletext"> Tainings-Blöcke </p></div>  
            <section id="trainingsblöcke">
                <div class="trainingsblock">
                    
                    <?php
                    $counter = 0;
                    while($row = mysqli_fetch_array($collect)){
                        echo '<div class="admin-content">'; ?>
                                <div class="trainingimg">  
                                <img src="uploads/<?php echo ($row['bild'])?>" alt=""></div>
                                <div ><h1>  <?php echo $row["trainame"] ?> </h1></div>
                                <div><h1> 
                                   <?php 
                                        if($row["capacity"] >= 1){
                                            echo 'Frei';
                                        }
                                        else {
                                            echo 'Ausgebucht';
                                        }
                                   ?></h1>
                                </div>
                                <div ><h1>  <?php echo $row["datetim"] ?> </h1></div>
                                <div ><h1>  <?php echo $row["ort"] ?> </h1></div>
                                <div class="tbdiv">
                                    <button class="tpb">  <a href="modtrainingblock.php?id=<?php echo $row['id'] ?>"> <i class="far fa-edit"> </i></a>  </button>
                                </div>
                                
                          <?php echo '</div>';
                              $counter++;
                    }
                    ?>
                    <button onclick="openmodal()" class="erstellen">  Erstellen  </button>   
                </div>
            </section>


             <!---        TRAININGSPLAN    --->
            <div class="sectiontitel"><p class="titletext"> Tainings-Pläne </p></div>  
             <section id="trainingsplan">
                <div class="trainingsplaene">
                    
                    <?php
                    $countrow = 0;
                    while($rowtp = mysqli_fetch_array($collecttp)){
                        echo '<div class="admin-content">'; ?>
                            <div class="trainingimg">  
                                <img src="uploads/<?php echo ($rowtp['bild'])?>" alt="">
                            </div>
                        
                                <div ><h1>  <?php echo $rowtp["tname"] ?> </h1></div>
                                
                                
                                <div class="tpbdiv">
                                    <button>  <a href="modtplan.php?id=<?php echo $rowtp['id'] ?>"> <i class="far fa-edit"> </i></a>  </button>
                                </div>
                                <a class="detail" href="trainingsplandetail.php?id=<?php echo ($rowtp['id'])?>"> <span class="material-icons see"> visibility</span> </a>
                          <?php echo '</div>';
                              $countrow++;
                    }
                    ?>
                    

                 
                    <button onClick="opentpmodal()" class="erstellen"> Erstellen </button>
                
                </div>
             </section>
                <!---    REZEPTE ----->
             <div class="sectiontitel"><p class="titletext"> rezepte </p></div>  
                <section class="rezepte" id="rezepte">
                    
                    <?php
                    $selectfr = "SELECT * FROM fitnesrezept WhERE benutzerid='$sessid'";
                    $colfr = mysqli_query($connection, $selectfr);
                    
                    $count = 0;
                     while ($tp = mysqli_fetch_array($colfr)){  
                       echo '<div class="rezeptbehalter">'; ?>
            
                        <div class="rezeptbild">
                            <a href="">
                                <img src="uploads/<?php echo ($tp['bild'])?>" alt="">
                            </a>
                        </div>
                        <hr>
                        <h1> <?php echo $tp["rezeptitel"] ?>  </h1>

                        <div class="frdiv">
                            <button >  <a href="modrezept.php?id=<?php echo $tp['id'] ?>"> <i class="far fa-edit"> </i></a>  </button>
                            
                        </div>
                        
                        <a class="detail" href="rezeptdetail.php?id=<?php echo ($tp['id'])?>"> <span class="material-icons see"> visibility</span> </a>
                      <?php echo '</div>';
                              $count++;
                        }  
            ?>
            <button onclick="openfrmodal()" class="erstellen">  Erstellen  </button> 
                </div>   
                
                      
                    </section>
            </div>
               
            <!--                    Trainingsmodl                 --->
            <div class="modal" id="modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1> Trainingsblock hinzufügen</h1>
                        </div>
                        <?php
                             echo '<form class="form" action="funcphp/beitraege.php" method="POST" enctype="multipart/form-data">
                                    <div class="inputBox">
                                        <div class="inputwrap">
                                            <span>Name</span>
                                            <input type="text" name="trainingsname" placeholder="Trainingsname" required>
                                        </div>
                                        <div class="inputwrap">
                                            <span>Kategorie</span>
                                            <input type="text" name="trainingskategorie" placeholder="Trainingskategorie" required>
                                        </div>
                                    </div>

                                    <div class="inputBox">
                                        <div class="inputwrap">
                                            <span>capacity</span>
                                            <input type="number" name="capacity" placeholder="Plätze" required>
                                        </div>   
                                        <div class="inputwrap">
                                            <span>Dauer</span>
                                            <input type="text" name="dauer" placeholder="Dauer" required>
                                        </div>
                                    </div>

                                    <div class="inputBox">
                                        <div class="inputwrap">
                                            <span>Art</span>
                                            <input type="text" name="art" placeholder="Art" required>
                                        </div>   
                                        <div class="inputwrap">
                                            <span>Beschreibung</span>
                                            <input type="text" name="beschreibung" placeholder="Beschreibung" required>
                                        </div>
                                    </div>

                                    <div class="inputBox">
                                        <div class="inputwrap">
                                            <span>Status</span>
                                            <div class="status">
                                                <select name="status" id="status" required>
                                                    <option  value="frei"> Frei </option>
                                                    <option  value="ausgebucht"> Ausgebucht </option>
                                                </select>
                                            </div>
                                        </div>   
                                        <div class="inputwrap">
                                            <span>Ort</span>
                                            <input type="text" name="ort" placeholder="Ort" required>
                                        </div>
                                    </div>

                                    <div class="inputBox">
                                        <div class="inputwrap">
                                            <span>Datum</span>
                                            <input type="datetime-local" name="datumzeit" required>
                                        </div>
                                            
                                        <div class="inputbild">
                                        <span> <label for="bildhoch" class="bildhochladen"> 
                                            <span class="material-icons"> add_photo_alternate</span> </label> 
                                        </span>    
                                        <input  type="file" name="bild" id="bildhoch">
                                        </div>
                                    </div>

                                    <div class="btnsubmit">
                                    <input class="submitbtn" type="submit" value="Bestätigen" name="posten">
                                    </div>
                         
                         </form>'                     
                     
                     ?>    
                     <div class="dismiss-btn">
                         <button id="close-mod" onclick="closemodal()"> <i class="far fa-times-circle"></i></button>
                     </div>
                    </div>
            </div>

            <!--           Modal trainingsplan                       -->
            <div class="tpmodal" id="tpmodal">
                    <div class="modaltrainingplan">
                        <div class="modal-header">
                            <h1> Trainingsplan hinzufügen</h1>
                        </div>
                        <?php
                             echo '<form class="form" action="funcphp/beitraege.php" method="POST" enctype="multipart/form-data">
                                    <div class="inputBox">
                                        <div class="inputwrap">
                                            <span>Name</span>
                                            <input type="text" name="trainingsname" placeholder="Trainingsname" required>
                                        </div>
                                        <div class="inputwrap">
                                            <span>Kategorie</span>
                                            <input type="text" name="trainingskategorie" placeholder="Trainingskategorie" required>
                                        </div>
                                    </div>
                                    <div class="inputBox">  
                                        <div class="inputwrap">
                                            <span>Ubungen</span>
                                            <textarea rows="7" class="ta" name="beschreibung" placeholder="Beschreibung" required></textarea>
                                        </div>

                                        <div class="inputbild">
                                        <span> <label for="bildhoch" class="bildhochladen"> 
                                            <span class="material-icons"> add_photo_alternate</span> </label> 
                                        </span>    
                                        <input  type="file" name="image" id="bildhoch">
                                    </div>
                                    </div>

                                    <div class="btnsubmit">
                                    <input class="submitbtn" type="submit" value="Bestätigen" name="tppost">
                                    </div>
                         
                                    </form>'
                                                         
                     
                     ?>    
                     
                     <div class="dismiss-btn">
                         <button id="close-mod" onClick="closetpmodal()"> <i class="far fa-times-circle"></i></button>
                     </div>
                    
                    </div>
            </div>

            <!--           Modal fitnesrezepte                       -->
            <div class="frmodal" id="frmodal">
                    <div class="modalfitnesrezept">
                        <div class="modal-header">
                            <h1> Fitnessrezept hinzufügen</h1>
                        </div>
                        <?php
                             echo '<form class="form" action="funcphp/beitraege.php" method="POST" enctype="multipart/form-data">
                                    <div class="inputBox">
                                        <div class="inputwrap">
                                            <span>Titel</span>
                                            <input type="text" name="Rezepttitel" placeholder="Titel" required>
                                        </div>
                                        <div class="inputwrap">
                                            <span>Zubereitung</span>
                                            <textarea rows="7" class="zb" name="zubereitung" placeholder="Zubereitung..." required></textarea>
                                        </div>
                                    </div>
                                    <div class="inputBox">  
                                        <div class="inputwrap">
                                            <span>Zutaten</span>
                                            <textarea rows="7" class="zt" name="zutaten" placeholder="Zutaten" required></textarea>
                                        </div>
                                        <div class="inputwrap">
                                            <textarea rows="1" class="nw" name="naehrwert" placeholder="Nährewert" required></textarea>
                                        </div>

                                        <div class="inputbild">
                                            <span> <label for="bildhoch" class="bildhochladen"> 
                                                <span class="material-icons"> add_photo_alternate</span> </label> 
                                            </span>    
                                            <input  type="file" name="bild" id="bildhoch">
                                        </div>
                                    </div>

                                    <div class="btnsubmit">
                                    <input class="submitbtn" type="submit" value="Bestätigen" name="rezpost">
                                    </div>
                         
                                    </form>'                     
                     
                     ?>    
                     <div class="dismiss-btn">
                         <button id="close-mod" onClick="closefrmodal()"> <i class="far fa-times-circle"></i></button>
                     </div>
                    
                    </div>
            </div>


        

        <?php
    include "./php/footer.php";
?>