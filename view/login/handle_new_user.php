<div class="container">

<?php

// Handle incoming POST variables
$user_name = isset($_POST["new_name"]) ? htmlentities($_POST["new_name"]) : null;
$user_pass = isset($_POST["new_pass"]) ? htmlentities($_POST["new_pass"]) : null;
$re_user_pass = isset($_POST["re_pass"]) ? htmlentities($_POST["re_pass"]) : null;

// Check if username exists
if (!$app->access->exists($user_name)) {
    // Check passwords match
    if ($user_pass != $re_user_pass) {
        echo "Lösenord matchar inte!";
        header("Refresh:2; create_user");
    } else {
        // Make a hash of the password
        $crypt_pass = password_hash($user_pass, PASSWORD_DEFAULT);

        // Add user to database
        $app->access->addUser($user_name, $crypt_pass);

        echo "<p>Lade till " . $user_name . "!</p><p><a href='login'>Logga in</a></p>";
    }
} else {
    echo "Användaren existerar redan! Välj ett annat användarnamn.";
    header("Refresh:2; create_user");
}
