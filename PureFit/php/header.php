<?php
    session_start();
    include_once './dbconn/dbconnection.php';
    if(isset($_SESSION['id'])){
        $sessid= $_SESSION["id"];
       // echo $sessid;
       $user = "SELECT * FROM nutzertabelle WHERE id = $sessid ";
       $erg = mysqli_query($connection, $user);
       $nutzer = mysqli_fetch_assoc($erg);
       $name = $nutzer['benutzern'];
       $rolle = $nutzer['rolle'];
    }
    
    
    
?>

<!DOCTYPE html>


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./styles/login.css">
    <link rel="stylesheet" href="./css/all.css" > <!--load all styles -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Fitpure</title>
</head>
<body>
    <header>
        <div class="headercontainer">
            <div class="logo-container">
                <a href="index.php" class="logo"> 
                    <img src="img/fitpure.png" alt="fitpurelogo">
                </a>
            </div>
            <div class="slogan">
                <h2> The latest Eden of Fitness in your Town... </h2>
            </div>
            <div class="user-navigation">
                <?php 
                    if(isset($_SESSION['id'])){
                        echo '<div class="logout">';
                        echo '<a href="dbconn/logout.php" id="logout">  <i class="fas fa-sign-out-alt "></i> </a>';
                        echo '</div>'; 
                        
                        if ($rolle === 'admin'){
                            echo '<a href="admin.php">';
                        }
                        else {echo '<a href="user.php">';}
                         echo'<span>'; echo $name;  echo '</span>';
                         echo '</a>';
                         
                    }
                    else {
                        echo '<a href="login.php">
                              <i class="fas fa-user fa-xs mod"></i>
                              <span> Anmelden </span>
                              </a>';
                    }
                ?>
                
            </div>
            <nav class="navbar">
                <ul class="nav">
                    <li class="nav-item"> <i class="fas fa-home fa-1x mod"></i> <a href="index.php">  Home</a> </li>
                    <li class="nav-item"> <i class="fas fa-info fa-1x modi" ></i> <a href="about.html">  About</a> </li>
                    <li class="nav-item"> <i class="far fa-images fa-1x mod"></i> <a href="#"> Story</a> </li>
                    <li class="nav-item"> <i class="far fa-images fa-1x mod"></i> <a href="#">  Galerie</a> </li>
                </ul> 
             </nav>
        </div>
        
    </header>