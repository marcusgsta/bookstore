<?php
if (hasKeyPost("doCreate")) {
    $description = getPost("productDescription");

    $sql = "INSERT INTO Product (description) VALUES (?);";
    $app->db->execute($sql, [$description]);

    $id = $app->db->lastInsertId();

    $sql = "INSERT INTO Inventory (prod_id, items) VALUES ($id, 0);";
    $app->db->execute($sql);


    header("Location: edit?id=$id");
}
?>

<div class="container">
    <h1>Skapa produkt</h1>

<form method="post">
    <fieldset>
    <legend>Skapa</legend>

    <p>
        <label>Beskrivning:<br>
        <input type="text" name="productDescription" default="A Description"/>
        </label>
    </p>

    <p>
        <button type="submit" name="doCreate"><i class="fa fa-plus" aria-hidden="true"></i> Skapa</button>
        <button type="reset"><i class="fa fa-undo" aria-hidden="true"></i> Rensa</button>
    </p>
    </fieldset>
</form>
