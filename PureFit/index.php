<?php
    include "php/header.php";
    include_once 'dbconn/dbconnection.php';
    $selectpost = "SELECT * FROM trainingblock";
    $collect = mysqli_query($connection, $selectpost);
    $tb = mysqli_fetch_array($collect);
    $status = $tb['stat'];
    $cap = $tb ["capacity"];
     
    
     
?>
<!DOCTYPE html>
    
    
    

    
   <div class= "maincontainer">

   <div class="sectiontitel"><p class="titletext"> Trainingsblock </p></div>  
   <div class="search">
            <form method="post" action="search.php" class="searchform">
                <input type="text" name="suche" placeholder="Nach Trainingsblock Suchen..." required/>
                <button type="submit" name="tbsuchen"> <span class="material-icons loupe">search</span></button>
            </form>

            

        </div>    
    <section class="container">
        
                    <?php
                    $count = 0;
                     while ($row = mysqli_fetch_array($collect)){   
                       echo '
                        <div class="card">'; ?>
                            <div class="imgBx">
                                <img src="uploads/<?php echo ($row['bild'])?>" alt="">
                                <h2> <?php echo $row["trainame"] ?></h2>
                            </div>
                            <div class="content">
                                <div class="infos">
                                    
                                  <!--  <p> <?php echo $row["stat"] ?></p> -->
                                   <p>  <?php 
                                        if($row["capacity"] >= 1){
                                            echo 'Frei';
                                        }
                                        else {
                                            echo 'Ausgebucht';
                                        }
                                   ?>         </p>
                                    <h2> <?php echo $row["capacity"] ?></h2>
                                    <p> <?php echo $row["ort"] ?></p>
                                    <p> <?php echo $row["datetim"] ?></p>
                                </div>
                                <div class="bookbtn"> 
                                    <button> <a  name="buchen" href="funcphp/beitraegefunktionen.php?id=<?php echo $row['id'] ?>">  Buchen </a> </button>
                                </div>
                             <!--   <button class="fav"> <a  name="fav" href="funcphp/favoriten.php?id=<?php echo $row['id'] ?>"> <i class="material-icons"> star_outline </i> </a> </button> -->
                            </div>
                        <?php echo '</div>';
                              $count++;
                }  
                ?>
                
    </section>   

  
    
    <div class="sectiontitel"><p class="titletext"> Trainingsplan </p></div> 
         
    <section class="trainingplan">
        
            
            
            <?php
                    $selecttp = "SELECT * FROM trainingsplan";
                    $coltp = mysqli_query($connection, $selecttp);
                    
                    $count = 0;
                     while ($tp = mysqli_fetch_array($coltp)){
                       echo '<div class="rezeptbehalter">'; ?>
            
                        <div class="trainingsbild">
                            <a href="">
                                <img src="uploads/<?php echo ($tp['bild'])?>" alt="">
                            </a>
                        </div>
                        <hr>
                        <h1> <?php echo $tp["tname"] ?>  </h1>

                    <a href="funcphp/favoritentp.php?id=<?php echo ($tp['id'])?>"> <spann class="material-icons fav"> star_outline </span> </a> 
                    <a href="trainingsplandetail.php?id=<?php echo ($tp['id'])?>"> <span class="material-icons see"> visibility</span> </a>
                      <?php echo '</div>';
                              $count++;
                        }  
            ?>



                
    </section>


    
    <div class="sectiontitel"><p class="titletext"> Fitnesrezepte </p></div>    
            
    <section class="rezepte">
        
            
            
            <?php
                    $selectfr = "SELECT * FROM fitnesrezept";
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

                    <a href="funcphp/favoriten.php?id=<?php echo ($tp['id'])?>"> <spann class="material-icons fav"> star_outline </span> </a> 
                    <a href="rezeptdetail.php?id=<?php echo ($tp['id'])?>"> <span class="material-icons see"> visibility</span> </a>
                      <?php echo '</div>';
                              $count++;
                        }  
            ?>



                
    </section>


     <!--   <section class="waswirmachen">
                        <div class=titel>
                            <i class="far fa-calendar-check fa-2x"></i>
                            <p>  du bestimmst den Zeitplan</p>
                        </div>
                        <div>
                            <p> </p>
                        </div>
        </section>

        <section class="warumwir">
                <div class=titel>
                        <p>  wir sind das Richtige für dich, wenn du </p>
                </div>
                    <div>
                        <p> </p>
                    </div>
        </section>-->

    </div> 

    <?php
    include "php/footer.php";
    ?>




