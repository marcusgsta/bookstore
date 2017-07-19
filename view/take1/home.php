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
$offers = $resultset[0]->offer;
$recommended = $resultset[0]->recommended;

?>
<div class="home">


<article class="news">

    <h1>Välkommmen</h1>
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
    <h2>Senast inkomna produkter</h2>

        <?php foreach ($lastProducts as $row) :
        ?>

                <div class="name"><?= esc($row->name); ?></div>
                <div class="scrollable"><?= esc($row->description); ?></div>
                <div><img src="image/webshop/<?=esc($row->image)?>?w=150" class="productImage" title="Image of <?=esc($row->name)?>"></div>

                <div><?php
                $price = isset($row->new_price) ? $row->new_price . " (<span class='line'>$row->price</span>)" : $row->price;
                echo $price; ?></div>

                <div><a href="webshop-new?add=<?= esc($row->id);?>">Lägg till i varukorg</a></div>

        <?php endforeach; ?>


</article>

<article class="recommended_products">
    <h2>Rekommenderade produkter</h2>

        <?php foreach ($recommended as $row) :
        ?>

                <div class="name"><?= esc($row->name); ?></div>

                <div><img src="image/webshop/<?=esc($row->image)?>?w=150" class="productImage" title="Image of <?=esc($row->name)?>"></div>

                <div><?php
                $price = isset($row->new_price) ? $row->new_price . " (<span class='line'>$row->price</span>)" : $row->price;
                echo $price; ?></div>

                <div><a href="webshop-new?add=<?= esc($row->id);?>">Lägg till i varukorg</a></div>


        <?php endforeach; ?>


</article>

<article class="most_sold">
    <h2>Mest sålda produkt</h2>

            <?php foreach ($mostSold as $row) : ?>
            <div class="name"><?= esc($row->name);?> </div>
            <img src="image/webshop/<?=esc($row->image)?>?w=150" class="productImage" title="Image of <?=esc($row->name)?>">
            <?=esc($row->sold) . " stk sålda!";?>
        <?php endforeach; ?>


</article>
<article class="this_week">
    <h2>Veckans erbjudande</h2>

            <?php foreach ($offers as $offer) : ?>

            <div class="name"><?=esc($offer->name); ?></div>
            <div class="scrollable"><?=esc($offer->description); ?></div>
            <div><?=esc($offer->new_price); ?> kr</div>
            <div><?=esc($offer->discount); ?> % rabatt</div>

        <?php endforeach ?>


</article>

</div>
