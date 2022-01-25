<?php
session_start();


if (isset($_POST["anmelden"])){                                                     /*isset*/

  $bename = $_POST["benname"];
  $paswt = $_POST["passwort"];

  require_once 'dbconnection.php';
  require_once 'funktionen.php';


  login($connection, $bename, $paswt);

  
}
else {
  header("location: ../login.php");
  exit();
}
