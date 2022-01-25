<?php

if (isset($_POST["bestätigen"])){
    $nname = $_POST["nachname"];
    $vname = $_POST["vorname"];
    $email = $_POST["email"];
    $bname = $_POST["benname"];
    $passw = $_POST["passwort"];
    $passconfirm = $_POST["passwieder"];
    $rolle = $_POST["rolle"];

    require_once "dbconnection.php";
    require_once "funktionen.php";




    if (leerInput($nname, $vname, $email, $bname, $passw, $passconfirm, $rolle) !== false){
        header("location: ../register.php?error=Siehabennichtseingegeben");
        exit();
      }
  
      if (passabweicht($passw, $passconfirm) !== false){
  
        header("location: ../register.php?error=esgibtabweichungenbeimpass");
        exit();
      }
      if (bnamebesetzt($connection, $bname, $email) !== false) {/*musste im db gesucht erstmal*/
        header("location: ../register.php?error=benutzarnamenichtverfügbar");
        exit();
      }
  
      createUser($connection, $nname, $vname, $email, $bname, $passw, $rolle);
  
    }
  
    else {
      header("location: ../login.php");
      exit();















}