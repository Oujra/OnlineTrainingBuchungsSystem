<?php
    include "php/header.php";
?>

<!DOCTYPE html>

<main>
    <div class="login-container">
        <div class="login-titel"><h2> Registrieren </h2></div>
        <div class="div_form_login">
            
            <form class="form" action="dbconn/registrieren.php" method="post">
            
            <label for="">Name</label>
                <div class="form-feld">
                    <input type="text" name="nachname" placeholder="Name" required>
                </div>
                <label for="">Vorname</label>
                <div class="form-feld">
                    <input type="text" name="vorname" placeholder="Vorname" required>
                </div>
                <label for="">E-Mail</label>
                <div class="form-feld">
                    <input type="email" name="email" placeholder="E-mail" required>
                </div>
                <label for="">Benutzername</label>
                <div class="form-feld">
                    <input type="text" name="benname" placeholder="Benutzername" required>
                </div>
                <label for="">Passwort</label>
                <div class="input-feld">
                    <input type="password" name="passwort" placeholder="Passwort" required>
                </div>
                <label for="">Passwort</label>
                <div class="input-feld">
                    <input type="password" name="passwieder" placeholder="Confirm Passwort" required>
                </div>
                <label for="usertyp"> Rolle </label>
                <div class="usertyp">
                    <select name="rolle" id="usertyp" required>
                        <option value="siesind" disabled selected> Sie sind </option>
                        <option name="rolle" value="admin"> Admin  </option>
                        <option name="rolle" value="user"> User</option>
                    </select>
                </div>
                <div class="btnsubmit">
                    <input class="submitbtn" name="bestätigen" type="submit" value="Bestätigen">
                </div>
            </form>
            
        </div>
        
    </div>
</main>
  

</html>

<?php
    include "php/footer.php";
?>