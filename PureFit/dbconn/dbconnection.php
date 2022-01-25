<?php

$server = "localhost";
$dbuname = "root";
$dbpw = "";
$dbname= "purefittest";

$connection = mysqli_connect($server,$dbuname,$dbpw, $dbname);

if(!$connection){
    die("fehler beim DB Connextion " . mysqli_connect_error());
}