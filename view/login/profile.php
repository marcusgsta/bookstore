<?php

if (!$app->session->has("user_name")) {
    header('Location: login');
}

$user = $app->session->get("user_name");

//Handle incoming POST variables
$grav_link = isset($_POST["grav_link"]) ? htmlentities($_POST["grav_link"]) : null;
if ($grav_link != null) {
    // update database table
    $app->db->execute("UPDATE users SET gravatar='$grav_link' WHERE name='$user'");
}
// Get gravatar
    $app->db->execute("SELECT gravatar FROM users WHERE name='$user'");
    $res = $app->db->fetchOne();

    $grav_link = $res->gravatar;
?>
<div class="container">

<h1>Välkommen <?=$user;?></h1>
<img class="gravatar right" src="<?=$grav_link;?>" alt="Gravatar">

<p>Detta är din personliga profil.</p>

<p><a href="orderhistory">Se din orderhistorik</a></p>


<p><a href="change_password">Ändra lösenord</a></p>
<p><a href="change_email">Ändra epostadress</a></p>


<p>Om du har skapat en <a href="http://gravatar.com">Gravatar</a> kan du lägga till den i din profil:</p>
<form action="profile" method="post">

    <input type="text" name="grav_link" value="">
    <input type="submit" name="submitForm" value="Sänd">

</form>

<p>Cookien 'my_cookie' innehåller <?=$app->cookie->get('my_cookie')?>.</p>


<p><a href="logout">Logga ut</a></p>
