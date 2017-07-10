<div class="container">

<?php

// Handle incoming POST variables
$user_name = isset($_POST["name"]) ? htmlentities($_POST["name"]) : null;
$user_pass = isset($_POST["pass"]) ? htmlentities($_POST["pass"]) : null;


// Correspond according to input
// Check if both fields are filled
if ($user_name != null && $user_pass != null) {
    // Check if username exists
    if ($app->access->exists($user_name)) {
        $get_hash = $app->access->getHash($user_name);
        // Verify user password
        if (password_verify($user_pass, $get_hash)) {
            $app->session->set("user_name", $user_name);
            header("Location: profile");
        } else {
            // Redirect to login.php
            echo "<p>Användarnamn eller lösenord är felaktigt.</p> <p> <a href='login'>Försök igen.</a></p>";
        }
    } else {
        // Redirect to login.php
        echo "<p>Ingen användare med det namnet. <a href='login'>Försök igen.</a><p>";
    }
}
?>
