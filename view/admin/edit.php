<?php
if (isset($_POST['save'])) {
    try {
        $id = $_POST['id'];
        $name = isset($_POST['name']) ? htmlentities($_POST['name']) : "";
        $pass = isset($_POST['pass']) ? htmlentities($_POST['pass']) : "";
        $role = isset($_POST['role']) ? htmlentities($_POST['role']) : "";
        $gravatar = isset($_POST['gravatar']) ? htmlentities($_POST['gravatar']) : "";
        $app->admin->editUser($id, $name, $pass, $role, $gravatar);
    } catch (Exception $e) {
        $edit_message = "Caught exception: " .  $e->getMessage() . "\n";
    }
    $edit_message = "Användaren uppdaterades!";
}


if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $message = $app->admin->deleteAccount($id);
}

$user_id = isset($_POST['edit']) ? $_POST['edit'] : "";

if (isset($user_id) and $user_id != "") {
    $app->db->execute("SELECT * FROM users WHERE id='$user_id'");
    $account = $app->db->fetchOne();
}

?>
<div class="container">

<?php
if (isset($message)) {
    echo $message;
}
if (isset($edit_message)) {
    echo $edit_message;
}
?>
<?php if (isset($account)) : ?>
<form class="edit_user" action="" method="post">
    <fieldset>
        <legend>Redigera användare</legend>

<input type="hidden" name="id" value="<?=$account->id?>">
<label>Namn
<input type="text" name="name" value="<?=$account->name?>">
</label>
<label>Lösenord
<input type="text" name="pass" value="">
</label>
<label>Gravatar
<input type="text" name="gravatar" value="<?=$account->gravatar?>">
</label>
<label>Roll
<select class="" name="role">
    <option value="0">Användare</option>
    <option value="1">Administratör</option>
</select>
</label>
<input type="submit" name="save" value="Spara ändringar">

</fieldset>
<input type="submit" class="delete right" name="delete" value="Radera användare">
</form>
<?php endif; ?>
