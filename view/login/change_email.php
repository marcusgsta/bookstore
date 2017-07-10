<?php
// Include config
// require_once("config.php");

$user = $app->session->get("user_name");
$email = $app->access->getUsersEmail($user);
$status = "Ändra epostadress";

// Handle incoming POST variables
$new_email = isset($_POST["new_email"]) ? htmlentities($_POST["new_email"]) : null;
$pass = isset($_POST["pass"]) ? htmlentities($_POST["pass"]) : null;

// Check if all fields are filled
if ($new_email != null && $pass != null) {
//     // Check if password is correct
    if (password_verify($pass, $app->access->getHash($user))) {
            $app->access->changeEmail($user, $new_email);
            $email = $app->access->getUsersEmail($user);
            $status = "Epostadress uppdaterad.";
        } else {
            $status = "Felaktigt lösenord.";
        }
    } else {
        $status = "Alla fält måste fyllas i.";
    }

?>

<div class="container">


    <form action="" method="POST">
        <table>
            <legend><h3><?=$status?></h3></legend>
            <tr>
                <td>Din epostadress är:</td><td><?=$email?></td>
                <!-- <td>Old pass:</td><td><input type="password" name="old_pass"></td> -->
            </tr>
            <tr>
                <td>Ny epostadress:</td><td><input type="email" name="new_email" required></td>
            </tr>

            <tr>
                <td>Bekräfta med ditt lösenord:</td><td><input type="password" name="pass" required></td>
            </tr>
            <tr>
                <td><input type="submit" name="submitForm" value="Ändra epostadress"></td>
            </tr>
        </table>
    </form>
    <p><a href='login'>Tillbaka till inloggning</a></p>
