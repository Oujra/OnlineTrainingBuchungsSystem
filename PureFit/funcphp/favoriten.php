<?php




session_start();
include_once '../dbconn/dbconnection.php';
if(isset($_SESSION["id"])){
    $userid = $_SESSION["id"];
}
$sessid= $_SESSION["id"];
?>
<?php

if(isset($_GET["id"])){
    $idrez = $_GET["id"];

    //echo $idtrblock;
    mysqli_query($connection, "INSERT INTO  favoriten (idbeitrag, iduser) 
                VALUES ($idrez, $sessid)");

}
echo "<script>
alert('Ihre Kommentar würde zugesendet');
window.history.go(-1);
</script>"; 