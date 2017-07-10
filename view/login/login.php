<?php

$user_loggedin = "";

// Make sure no one is logged in
if ($app->session->has("user_name")) {
    $message = "<p>You are already logged in as " . $app->session->get('user_name') . "</p>";
    $message .= "<p><a href='logout'>Logout</a></p>";
    $user_loggedin = "disabled";
}

?>

<div class="container">
<?php if (isset($message)) {
    echo $message;
} ?>

    <form action="validate" method="POST">
        <table>
            <legend><h1>Logga in</h1></legend>
            <tr>
                <td>Namn:</td><td><input type="text" name="name"></td>
            </tr>
            <tr>
                <td>Lösenord:</td><td><input type="password" name="pass"></td>
            </tr>
            <tr>
                <td><input type="submit" name="submitForm" value="Logga in"></td>
            </tr>
        </table>
    </form>
<a href="create_user">Skapa ny användare</a>
