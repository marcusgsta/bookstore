<div class="container">
<?= isset($app->user_logged_in) ? $app->user_logged_in : "";?>
<a href="home">
<img src="image/books_logo.png?w=100" alt="Böcker" class="books left">
</a>
<h1>Varukorg</h1>


<?php
if (!$data) {
    return;
}

$result = $data;
$sum = 0;
?>

<table>
    <tr class="first">
        <th>Namn</th>
        <th>Bild</th>
        <th>Pris</th>
        <th>Antal</th>
        <th>Total</th>
        <th></th>
    </tr>

<?php $id = -1; foreach ($result as $row) :
    $id++;
?>
    <tr>
        <td><?= esc($row->name); ?></td>
        <td><img src="image/webshop/<?=esc($row->image)?>?w=150" class="tableImage" title="Image of <?=esc($row->name)?>"</td>
        <td><?php

        $price = isset($row->new_price) ? $row->new_price : $row->price;
        echo $price . " SEK"; ?>
    </td>
        <td><?= esc($row->items); ?></td>
        <td><?php
            $total = 0;
        if (isset($row->new_price)) {
                $row->total = $row->new_price * $row->items;
        }
            ?></td>
        <td><?= esc($row->total . " SEK"); ?></td>
        <?php
            $sum += $row->total;
            ?>
        <td><a href="?remove=<?= esc($row->product);?>">Ta bort från varukorg</a></td>
    </tr>

<?php endforeach; ?>
<tr>
    <td>Totalt att betala: </td><td></td><td><td></td></td><td><?=$sum . " SEK";?></td>
    <form class="" action="" method="post">
    <td><button type="submit" name="order">Beställ</button></td>
    </form>
</tr>
</table>
