<?php

// $user_name = $app->session->get('user_name');

// if (!$app->admin->userIsAdmin($user_name)) {
//     $admin_message = "<div class='container'><p>Bara administratörer har tillgång till sidan.</p>";
//     echo $admin_message;
//     header("refresh:5;url=login");
//     echo '<p>You\'ll be redirected in about 5 secs. If not, click <a href="login">here</a>.</p>';
//     exit;
// }

if (isset($_POST['add'])) {
    try {
        $name = isset($_POST['name']) ? htmlentities($_POST['name']) : "";
        $pass = isset($_POST['pass']) ? htmlentities($_POST['pass']) : "";
        // $rePass = isset($_POST['re_pass']) ? htmlentities($_POST['re_pass']) : "";
        $role = isset($_POST['role']) ? htmlentities($_POST['role']) : 0;
        $gravatar = isset($_POST['gravatar']) ? htmlentities($_POST['gravatar']) : "";
        $accounts = $app->admin->addUser($name, $pass, $rePass, $role, $gravatar);
    } catch (Exception $e) {
        $add_message = "Caught exception: " .  $e->getMessage() . "\n";
    }
}

// if (isset($_GET['show'])) {
$orderby = isset($_GET['orderby']) ? htmlentities($_GET['orderby']) : "name";
$order = isset($_GET['order']) ? htmlentities($_GET['order']) : "ASC";
$accounts = $app->admin->showAccounts($orderby, $order);
// }



?>

<div class="container">

<h1>Admin</h1>

<?php if (isset($add_message)) {
    echo $add_message;
}

$search = isset($_GET['search']) ? htmlentities($_GET['search']) : "";

if ($search != "") {
    $search_results = $app->admin->search($search);
}
?>
<form class="" action="" method="get">

    <fieldset>
    <legend>Sök</legend>
    <label for="search">Användare (% = wildcard):
    <input type="text" name="search" value="">
    </label>
    <input type="submit" name="submit" value="Sök">


    <?php if (isset($search_results) and $search_results != "") :?>
    <table class="admin">
        <th>Namn</th>
        <th>Epost</th>
        <th>Gravatar</th>
        <th>Roll</th>
    <?php foreach ($search_results as $search_result) : ?>

    <tr>
        <td><?=$search_result->name?></td>
        <td><?=$search_result->email?></td>
        <td class="gravatar_column"><?=$search_result->gravatar?></td>
        <td><?=$search_result->role?></td>
    </tr>

    <?php endforeach;?>

    </table>
    <?php endif; ?>

    </fieldset>
</form>

<?php if (isset($accounts)) :?>
<table class="admin">

    <?php $defaultRoute = "?route=show-all-sort&" ?>
        <tr class="first">
            <th>&nbsp;Id&nbsp; <?= $app->admin->orderby("id", $defaultRoute) ?></th>
            <th>Namn <?= $app->admin->orderby("name", $defaultRoute) ?></th>
            <th>Epost</th>
            <th>Gravatar</th>
            <th>Roll <?= $app->admin->orderby("role", $defaultRoute) ?></th>
        </tr>

<?php foreach ($accounts as $account) : ?>

<tr>
    <td><?=$account->id?></td>
    <td><?=$account->name?></td>
    <td><?=$account->email?></td>
    <td class="gravatar_column"><?=$account->gravatar?></td>
    <td><?=$account->role?></td>
</tr>

<?php endforeach;?>

</table>
<?php endif; ?>


<?php $user_accounts = $app->admin->showAccounts(); ?>

<form class="" action="edit" method="post">
    <fieldset>
        <legend>Redigera användare</legend>

    <label for="edit">Välj användare

    <select class="" name="edit">
        <?php foreach ($user_accounts as $account) : ?>
        <option value="<?=$account->id?>"><?=$account->name?></option>
        <?php endforeach;?>
    </select>


    </label>
    <input type="submit" name="" value="Välj">
        </fieldset>
</form>



<form class="add_user" action="" method="post">

    <fieldset>

    <legend>Lägg till användare</legend>
    <label for="name"> Namn:
    <input type="text" name="name" value="">
    </label>

    <label for="password">Lösenord:
    <input type="password" name="pass" value="">
    </label>

    <label for="re_pass">Lösenord igen:
    <input type="password" name="re_pass" value="">
    </label>

    <label for="gravatar">Gravatar-länk:
    <input type="gravatar" name="gravatar" value="">
    </label>

    <label for="role">Roll:
        <select class="" name="role">
            <option value="0">Användare</option>
            <option value="1">Administratör</option>
        </select>
    </label>

    <input type="submit" name="add" value="Lägg till">

    </fieldset>
</form>
