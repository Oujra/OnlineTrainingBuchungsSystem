<?php
    include "php/header.php";
    
?>

<!DOCTYPE html>


    <div class="login-container">
        <div class="login-titel"><h2> Login </h2></div>
        <div class="div_form_login">
            <form class="form" action="dbconn/login.dbconn.php" method="post">
                <label for="">Benutzername</label>
                <div class="form-feld">
                    <input type="text" name="benname" placeholder="Benutzername" required>
                </div>
                <label for="">Passwort</label>
                <div class="input-pass">
                    <input type="password" name="passwort" placeholder="Passwort" id="password" required>
                </div>
            
  <!--              <label for="usertyp"> Rolle </label>
                <div class="usertyp">
                    <select name="typeuser" id="usertyp">
                        <option value="siesind" disabled selected> Sie sind </option>
                        <option value="admin"> Admin  </option>
                        <option value="user"> User</option>
                    </select>
                </div>-->
                <div class="btnsubmit">
                    <input class="submitbtn" type="submit" value="Anmelden" name="anmelden">
                </div>

                <div class="error">
                     <h1 style="color:red; font-size:18px;">
                        <?php
                            if(isset($_GET['error'])){
                                switch($_GET['error']){
                                    case 'benutzernichtgefunden':
                                        echo' Benutzername Bzw. Email nicht gefunden';
                                        break;
                                    case 'falshepass':
                                        echo' Falsches Passwort';
                                        break;
                                    case '':
                                        echo'';
                                        break;    
                                }
                            }
                        ?>
                     </h1>
                </div>
                <div class="passvergessen"> <a href="#"> Passwort Vergessen ?</a> </div>
                <div>  <p> noch kein Konto ? 
                        <a href="register.php"> registrieren </a>
                       </p>
                </div>
            </form>
        </div>
    </div>
<main>
</main>


</html>
<?php
    include "php/footer.php";
?>