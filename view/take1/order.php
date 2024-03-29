<div class="container">
    <a href="home">
<img src="image/books_logo.png?w=100" alt="Böcker" class="books left">
</a>
<?= isset($app->user_logged_in) ? $app->user_logged_in : "";?>

<?php
if (!$data) {
    return;
}

$result = $data;
$sum = 0;
$orderId = $result[0]->order;

?>

<h1>Order nr. <?=$orderId;?></h1>
<table class="order">
    <tr class="first">
        <th>Produktnamn</th>
        <th>Pris</th>
        <th>Antal</th>
        <th>Totalt</th>
    </tr>
<?php foreach ($result as $row) :
?>
    <tr>
        <td><?= esc($row->name); ?></td>

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
    </tr>

<?php endforeach; ?>
<tr>
    <td>Totalt att betala: </td><td></td><td><td></td></td><td><?=$sum . " SEK";?></td>

</tr>
</table>
