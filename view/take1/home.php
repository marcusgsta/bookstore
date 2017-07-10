<div class="container">
    <?= isset($app->user_logged_in) ? $app->user_logged_in : "";?>
<img src="image/books_logo.png?w=200" alt="Böcker" class="left">

<?php

if (!$data) {
    return;
} else {
    $resultset = $data;
}

$lastProducts = $resultset[0]->lastProducts;
$mostSold = $resultset[0]->mostSold;
?>

<article class="news">

    <h1>Hem</h1>
    <p>De senaste nyheterna:</p>

<?php foreach ($resultset as $row) : ?>
<section>
    <header>
        <h2><a href="newspost?route=<?= esc($row->slug) ?>"><?= esc($row->title) ?></a></h2>
        <p><i>Published: <time datetime="<?= esc($row->published_iso8601) ?>" pubdate><?= esc($row->published) ?></time></i></p>
    </header>
    <?php
    $row->extract = esc($row->extract);
    if (isset($row->filter)) {
        $row->extract = $app->textfilter->doFilter($row->extract, $row->filter);
    }
        echo $row->extract . " [...]";
    ?>
</section>
<?php endforeach; ?>

</article>

<article class="latest_products">
    <h2>Senaste inkomna produkter</h2>
        <table>
            <tr class="first">
                <th>Namn</th>
                <th>Beskrivning</th>
                <th>Bild</th>
                <th>Kategori</th>
                <th>Pris</th>
                <th>På lager</th>
                <th></th>
            </tr>
        <?php foreach ($lastProducts as $row) :
        ?>
            <tr>
                <td><?= esc($row->name); ?></td>
                <td><?= esc($row->description); ?></td>
                <td><img src="image/webshop/<?=esc($row->image)?>?w=150" class="productImage" title="Image of <?=esc($row->description)?>"></td>
                <td><?= esc($row->category); ?></td>
                <td><?= esc($row->price); ?></td>
                <td><?= esc($row->items); ?></td>
                <td><a href="webshop-new?add=<?= esc($row->id);?>">Lägg till i varukorg</a></td>
            </tr>

        <?php endforeach; ?>
        </table>

</article>
<article class="most_sold">
    <h2>Mest sålda produkt</h2>
    <table>
        <tr>
            <?php foreach($mostSold as $row) : ?>
            <td><?= esc($row->name);?> </td>
            <td><img src="image/webshop/<?=esc($row->image)?>?w=150" class="productImage" title="Image of <?=esc($row->description)?>"></td>
            <td><?=esc($row->sold) . " stk sålda!";?></td>
        <?php endforeach; ?>
</tr>
</table>

</article>
<article class="this_week">
    <h2>Veckans erbjudande</h2>
</article>
<article class="recommended_products">
    <h2>Rekommenderade produkter</h2>
</article>
