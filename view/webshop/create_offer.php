<div class="container">

<?php

if (!$data) {
    return;
} else {
    $products = $data;
}
$offers = $products[0]->offers;
?>


    <h1>Skapa erbjudande</h1>
    <form class="" action="" method="post">
        <table>

<tr>
    <td><select class="" name="product_name">
        <?php foreach ($products as $product) : ?>
        <option value="<?=$product->name;?>">
            <?=$product->name;?></option>
    <?php endforeach; ?>
    </select></td>
</tr>
<tr>

    <td>
        Rekommendera produkt
    <input type="radio" id="yes" name="recommended" value="1">
    <label for="yes">Ja</label>
    <input type="radio" id="no" name="recommended" value="0">
    <label for="no">Nej</label>
</td>
</tr>
<tr>
    <td><label for="discount">Välj rabattprocent</label>
    <select name="discount">
        <option>5</option>
        <option>10</option>
        <option>15</option>
        <option>20</option>
        <option>25</option>
        <option>30</option>
        <option>35</option>
        <option>40</option>
        <option>45</option>
        <option>50</option>
    </select></td>
</tr>
<tr>
    <td><textarea name="description" rows="8" cols="40"></textarea></td>
</tr>
<tr>
    <td><button type="submit" name="submit">Skapa</button></td>
</tr>
                </table>
    </form>
    <h2>Alla erbjudanden</h2>
<table>
    <tr>
        <th>Namn</th>
        <th>Beskrivning</th>
        <th>Rabattprocent</th>
        <th>Nytt pris</th>
        <th>Borttaget</th>
    </tr>
    <?php foreach ($offers as $offer) : ?>
    <tr>
        <td><?=esc($offer->name);?></td>
        <td><?=esc($offer->description);?></td>
        <td><?=esc($offer->discount);?></td>
        <td><?=esc($offer->new_price);?></td>
        <td><?php
        if ($offer->deleted != null) {
                echo esc($offer->deleted);
        } else {
                echo "<a href='?remove=$offer->id'>Ta bort erbjudande</a>";
        }
        ?>

        <td></td>
    </tr>
<?php endforeach; ?>
</table>
