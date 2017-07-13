<?php

if (hasKeyPost("doCreate")) {
    $categoryName = getPost("categoryName");
    $sql = "INSERT INTO ProdCategory (category) VALUES (?);";
    $app->db->execute($sql, [$categoryName]);
}

// Show all categories
$sql = "SELECT * FROM ProdCategory";
$result = $app->db->executeFetchAll($sql);
?>

<div class="container">
    <h1>Skapa kategori</h1>

<form method="post">
    <fieldset>
    <legend>Skapa</legend>

    <p>
        <label>Namn på kategori:<br>
        <input type="text" name="categoryName" default="A Category Name"/>
        </label>
    </p>

    <p>
        <button type="submit" name="doCreate"><i class="fa fa-plus" aria-hidden="true"></i> Skapa</button>
        <button type="reset"><i class="fa fa-undo" aria-hidden="true"></i> Rensa</button>
    </p>
    </fieldset>
</form>
