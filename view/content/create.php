<?php
// if (hasKeyPost("doCreate")) {
//     $title = getPost("contentTitle");
//
//     $sql = "INSERT INTO Content (title) VALUES (?);";
//     $app->db->execute($sql, [$title]);
//     $id = $app->db->lastInsertId();
//     header("Location: edit?id=$id");
// }
?>

<div class="container">
    <a href="../home">
    <img src="../image/books_logo.png?w=100" alt="Böcker" class="books left">
    </a>
    <h1>Skapa innehåll</h1>

<form method="post">
    <fieldset>
    <legend>Create</legend>

    <p>
        <label>Title:<br>
        <input type="text" name="contentTitle" default="A Title"/>
        </label>
    </p>

    <p>
        <button type="submit" name="doCreate"><i class="fa fa-plus" aria-hidden="true"></i> Create</button>
        <button type="reset"><i class="fa fa-undo" aria-hidden="true"></i> Reset</button>
    </p>
    </fieldset>
</form>
