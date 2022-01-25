<?php
session_start();

function leerInput($nname, $vname, $email, $bname, $passw, $passconfirm, $rolle){
  $leer;
  if(empty($nname) || empty($vname) || empty($email) || empty($bname) || empty($passw) || empty($passconfirm) || empty($rolle)){
    $leer = true;
  }
  else {
    $leer = false;
  }
  return $leer;
}


function passabweicht($passw, $passconfirm){
  $abweichung;
  if($passw !== $passconfirm){
    $abweichung = true;
  }
  else {
    $abweichung = false;
  }
  return $abweichung;
}

function bnamebesetzt($connection, $bname, $email){
  $sql = "Select * FROM nutzertabelle WHERE benutzern = ? OR email = ?; ";  //? platzhalter
  $stmt = mysqli_stmt_init($connection);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../login.php?error=benemailbesetzt");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "ss", $bname, $email);
  mysqli_stmt_execute($stmt);

  $data = mysqli_stmt_get_result($stmt);

  if ($row = mysqli_fetch_assoc($data)){
    return $row;
  }
  else{
    $result = false;
    return $result;
  }
  mysqli_stmt_close($stmt);
}

function createUser($connection, $nname, $vname, $email, $bname, $passw, $rolle){
  $sql = "INSERT INTO nutzertabelle (nachname, vorname, email, benutzern, passwort, rolle) VALUES (?,?,?,?,?,?); ";  //? platzhalter
  $stmt = mysqli_stmt_init($connection);
  if(!mysqli_stmt_prepare($stmt, $sql)){
    header("location: ../register.php?failed");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "ssssss", $nname, $vname, $email, $bname, PASSWORD_HASH($passw, PASSWORD_DEFAULT), $rolle);

  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  


  $selctnutz = "SELECT * FROM nutzertabelle WHERE benutzern ='$bname'";  //benutzer selektieren und mit der profilbild tabelle verknüpfen
  $exce = mysqli_query($connection, $selctnutz);
  while($linie = mysqli_fetch_assoc($exce)){
    $uid = $linie["id"];
    $insinim = "INSERT INTO profilblid (benutzerId, status) VALUES ('$uid', 1); ";
    mysqli_query($connection, $insinim);

    $profbild = "INSERT INTO profilbild (status, benutzerid) VALUES (0, '$uid');";
    mysqli_query($connection, $profbild);
  }

  header("location: ../login.php?error=none");
  exit();
}



function login($connection, $bname, $passw){
  $usexist = bnamebesetzt($connection, $bname, $bname);

  if($usexist === false){
    header("location: ../login.php?error=benutzernichtgefunden");
    exit();
  }

  $phash = $usexist["passwort"];
  $checkPwd = password_verify($passw, $phash);

  if($checkPwd === false){

    header("location: ../login.php?error=falshepass");
    exit();
  }
  else if ($checkPwd === true){
    $_SESSION["id"] = $usexist["id"];
    $_SESSION["un"] = $usexist["benutzern"];
    $_SESSION["rolle"] = $usexist["rolle"];
    $selctrolle = "SELECT * FROM nutzertabelle WHERE benutzern ='$bname'";  //benutzer selektieren und mit der profilbild tabelle verknüpfen
    $exce = mysqli_query($connection, $selctrolle);
    while($linie = mysqli_fetch_assoc($exce)){
        $userrolle = $linie["rolle"];
    }
    if($userrolle === "admin"){
        header("location: ../admin.php?error=none");
        exit();
    }
    if($userrolle === "user"){
      header("location: ../user.php?error=none");
      exit();
  }
    header("location: ../login.php?error=none");
    exit();
  }
}
