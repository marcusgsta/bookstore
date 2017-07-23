<?php
if (hasKeyPost("doCreate")) {
    $name = getPost("productName");

    $sql = "INSERT INTO Product (name) VALUES (?);";
    $app->db->execute($sql, [$name]);

    $id = $app->db->lastInsertId();

    $sql = "INSERT INTO Inventory (prod_id, items) VALUES ($id, 0);";
    $app->db->execute($sql);


    header("Location: edit?id=$id");
}
?>

<div class="container">
    <a href="../home">
    <img src="../image/books_logo.png?w=100" alt="Böcker" class="books left">
    </a>
    <h1>Skapa produkt</h1>

<form method="post">
    <fieldset>
    <legend>Skapa</legend>

    <p>
        <label>Namn:<br>
        <input type="text" name="productName" default="Name"/>
        </label>
    </p>

    <p>
        <button type="submit" name="doCreate"><i class="fa fa-plus" aria-hidden="true"></i> Skapa</button>
        <button type="reset"><i class="fa fa-undo" aria-hidden="true"></i> Rensa</button>
    </p>
    </fieldset>
</form>
