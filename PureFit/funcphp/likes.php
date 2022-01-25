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

    
    mysqli_query($connection, "INSERT INTO  likerez (idbeitrag) 
                VALUES ($idrez)");

}
echo "<script>
window.history.go(-1);
</script>"; 