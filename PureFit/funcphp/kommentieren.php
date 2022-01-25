<?php
    session_start();
    include_once '../dbconn/dbconnection.php';
    if(isset($_GET["id"])){
        $idbetrag = $_GET["id"];
    
       // echo $idbetrag;
      }
    
    $sessid= $_SESSION["id"];
?>

<?php
    if(isset($_POST["kommentieren"])){
        $kommentar = $_POST["kommtext"];
        
        mysqli_query($connection, "INSERT INTO  Kommentare (postid, iduser, kommtext) VALUES ($idbetrag, $sessid ,'$kommentar')");
        mysqli_query($connection, "UPDATE fitnesrezept SET kommkount = kommcount+1 WHERE id=$idbetrag");

        
    }

    

     if(isset($_POST["tpkommentieren"])){
        $kommentar = $_POST["kommtext"];
        
        mysqli_query($connection, "INSERT INTO  Kommentaretp (postid, iduser, kommtext) VALUES ($idbetrag, $sessid ,'$kommentar')");
        mysqli_query($connection, "UPDATE trainingsplan SET kommcount = kommcount+1 WHERE id=$idbetrag");

        

    }

    
    echo "<script>
             alert('Ihre Kommentar würde zugesendet');
             window.history.go(-1);
     </script>";  