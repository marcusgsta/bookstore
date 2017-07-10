<div class="container">

<?php

// Check if someone is logged in
if ($app->session->has("user_name")) {
    $app->session->destroy();
} else {
    echo "<p>Ingen användare inloggad.</p>";
    echo "<p><a href='login'>Logga in igen.</a></p>";
    die();
}

// Check if session is active
$has_session = session_status() == PHP_SESSION_ACTIVE;

if (!$has_session) {
    echo "<p>Du har loggats ut!</p>";
}

echo "<a href='login'>Logga in igen.</a>";
?>
