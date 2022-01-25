<?php
    include "php/header.php";
    include_once 'dbconn/dbconnection.php';
    if(isset($_GET["id"])){
        $idbetrag = $_GET["id"];
      }
      $selectpost = "SELECT * FROM trainingsplan WHERE id = $idbetrag";
      $collect = mysqli_query($connection, $selectpost);
      $tr = mysqli_fetch_array($collect);  
    //SEL KOMMS
    $selectkoms = "SELECT * FROM kommentaretp WHERE postid = $idbetrag";
    $collectkoms = mysqli_query($connection, $selectkoms);
    $kommscount = mysqli_num_rows($collectkoms);
    //limit komms
    $selectlimitk = "SELECT * FROM kommentaretp JOIN nutzertabelle ON kommentaretp.iduser = nutzertabelle.id WHERE postid = $idbetrag ORDER BY date DESC LIMIT 5";
    $limitkoms = mysqli_query($connection, $selectlimitk);

    //SEL likes
    $selectlikes = "SELECT * FROM liketp WHERE idbeitrag = $idbetrag";
    $collectlikes = mysqli_query($connection, $selectlikes);
    $likescount = mysqli_num_rows($collectlikes);
     
?>
<body>
<!DOCTYPE html>
<html dir="ltr">
  <head>
     <meta charset="UTF-16">
     <link type="text/css" rel="stylesheet" href="../style.css">
     <script type="text/javascript">
     /* Kein eigenes Code  von stackoverflow*/
     function down(textToWrite, fileNameToSaveAs)
      {
             var textFileAsBlob = new Blob([textToWrite], {type:'text/plain'});
             var downloadLink = document.createElement("a");
             downloadLink.download = fileNameToSaveAs;
             downloadLink.innerHTML = "Download File";
             if (window.webkitURL != null)
             {
               downloadLink.href = window.webkitURL.createObjectURL(textFileAsBlob);
             }
             downloadLink.click();
    }
     </script>
  </head>

  <div class="behalter">
        <div class="imgcontainer">
          <img class="img" src="uploads/<?php echo ($tr['bild'])?>"> </img>
        </div>
        
        <div class="autofetch">
          <hr>
          <div class="titel">
            <h1><?php echo ($tr['tname']) ?></h1>
          </div>
          <hr>
          <p> <span>Ubungen:</span>  <br><br>  <?php echo nl2br($tr['ubungen']) ?></p>
          <br>
          <hr>
          <div class="downloadbtn" onclick="down(document.getElementById(id='test<?php $i?>').parentElement.innerText,'<?php echo ($tr['tname']) ?>.txt')"> <span class="material-icons down">file_download</span></div>
        </div>
        <div class="comslike">
            
            <div class="comlikes">
            <a href="funcphp/liktp.php?id=<?php echo ($tr['id'])?>"> <span class="material-icons like">thumb_up_alt <span class="likc"> <?php echo $likescount?> </span> </span> </a>
              
              <i class="material-icons com">comment <span class="comc"> <?php echo $kommscount?> </span> </i>
              
            </div>
            
          </div>
          <div class="comschreiben">
              <form action="funcphp/kommentieren.php?id=<?php echo $idbetrag?>" method="post">
                <textarea name="kommtext" rows="8" cols="80" placeholder="Deine meinung zählt..."></textarea>
                <br>
                <button type="submit" name ="tpkommentieren"> 
                  <span class="material-icons">check_circle</span> 
                </button>
          
              </form>
            </div>
            <br>
            <hr>
            <div class="zeigkomms">
              <?php
                $counter = 0;
                    while($row = mysqli_fetch_array($limitkoms)){
                        echo '<div class="">'; ?>
                <h2> Am <span> <?php echo $row["date"] ?> </span> schrieb  <span> <?php echo $row["benutzern"] ?> :</span> </h2>
                 <p> <?php echo $row["kommtext"] ?></p>
                 <?php echo '</div>';
                              $counter++;
                  }
                    ?>
            </div>
        </div>
        
  </div>

<?php
    include "php/footer.php";
    ?>