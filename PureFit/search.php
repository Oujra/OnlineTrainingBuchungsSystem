<?php
    include "php/header.php";
    include_once 'dbconn/dbconnection.php';
    if(isset($_GET["id"])){
        $idbetrag = $_GET["id"];
      }
?>

<div class= "maincontainer">

<div class="sectiontitel">
         <p>Tainings-Blöcke</p>
 </div>      
 <section class="container">
<?php


                if (isset($_POST["tbsuchen"])){
                    $search = mysqli_real_escape_string($connection, $_POST['suche']); 
                    $sql = "SELECT * FROM trainingblock WHERE trainame LIKE '%$search%'";
                    $result = mysqli_query($connection, $sql);
                    $queryRes = mysqli_num_rows($result);
                    if($queryRes > 0){
                        while($row = mysqli_fetch_assoc($result)){
                        
                            echo '
                        <div class="card">'; ?>
                            <div class="imgBx">
                                <img src="img/training.jpg" alt="">
                                <h2> <?php echo $row["trainame"] ?></h2>
                            </div>
                            <div class="content">
                                <div class="infos">
                                    
                                  <!--  <p> <?php echo $row["stat"] ?></p> -->
                                   <p>  <?php 
                                        if($row["capacity"] >= 1){
                                            echo 'frei';
                                        }
                                        else {
                                            echo 'ausgebucht';
                                        }
                                   ?>         </p>
                                    <h2> <?php echo $row["capacity"] ?></h2>
                                    <p> <?php echo $row["id"] ?></p>
                                </div>
                                <div class="bookbtn"> 
                                    <button> <a  name="buchen" href="funcphp/beitraegefunktionen.php?id=<?php echo $row['id'] ?>">  Buchen </a> </button>
                                </div>
                            </div>
                        <?php echo '</div>';
                             
                        }   
                
                    }else {
                        echo 'nichts';
                    }
                }
                
            ?>
 </section>         
                <?php
                include "./php/footer.php";
            ?>