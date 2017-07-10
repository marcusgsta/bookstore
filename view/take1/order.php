<div class="container">
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
        <td><?= esc($row->price . " SEK"); ?></td>
        <td><?= esc($row->items); ?></td>
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
