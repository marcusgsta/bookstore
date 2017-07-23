<?php

$product = $data; ?>

<div class="container">
    <a href="../home">
    <img src="../image/books_logo.png?w=100" alt="Böcker" class="books left">
    </a>
<h1>Radera produkt</h1>

<form method="post">
    <fieldset>
    <legend>Radera</legend>

    <input type="hidden" name="productId" value="<?= esc($product->id) ?>"/>

    <p>
        <label>Beskrivning:<br>
            <input type="text" name="productTitle" value="<?= esc($product->description) ?>" readonly/>
        </label>
    </p>

    <p>
        <button type="submit" name="doDelete"><i class="fa fa-trash-o" aria-hidden="true"></i> Ta bort</button>
    </p>
    </fieldset>
</form>
