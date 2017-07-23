<div class="container">
    <?= isset($app->user_logged_in) ? $app->user_logged_in : "";?>
    <a href="">
<img src="image/books_logo.png?w=100" alt="Böcker" class="books left">
</a>
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
$categories = $resultset[0]->categories;
?>
<div class="home">


<article class="news">

    <h1>Välkommen</h1>
    <p>De senaste nyheterna:</p>

<?php foreach ($resultset as $row) : ?>
<section>
    <header>
        <h2><a href="newspost?route=<?= esc($row->slug) ?>"><?= esc($row->title) ?></a></h2>
        <p><i><time datetime="<?= esc($row->published_iso8601) ?>" pubdate><?= esc($row->published) ?></time></i></p>
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


                <div class="scrollable"><?= esc($row->description); ?></div>
                <div class="clear">

                </div>
                <div><img src="image/webshop/<?=esc($row->image)?>?w=150" class="productImage" title="Image of <?=esc($row->name)?>"></div>

                <div class="add_to_cart">
                    <a href="webshop-new?add=<?= esc($row->id);?>">
                    <img src="image/webshop/add_to_cart.png?w=40" title="Lägg i varukorg" alt="Lägg i varukorg">
                </a>
                </div>

        <?php endforeach; ?>


</article>

<article class="recommended_products">
    <h2>Rekommenderade produkter</h2>

        <?php foreach ($recommended as $row) :
        ?>


        <div class="clear">

        </div>
                <div><img src="image/webshop/<?=esc($row->image)?>?w=150" class="productImage" title="Image of <?=esc($row->name)?>"></div>


                <div class="add_to_cart">
                    <a href="webshop-new?add=<?= esc($row->id);?>">
                    <img src="image/webshop/add_to_cart.png?w=40" title="Lägg i varukorg" alt="Lägg i varukorg">
                </a>
                </div>

        <?php endforeach; ?>


</article>

<article class="most_sold">
    <h2>Mest sålda produkt</h2>

            <?php foreach ($mostSold as $row) : ?>

            <img src="image/webshop/<?=esc($row->image)?>?w=150" class="productImage" title="Image of <?=esc($row->name)?>">
            <?=esc($row->sold) . " stk sålda!";?>
        <?php endforeach; ?>


</article>
<article class="this_week">
    <h2>Veckans erbjudande</h2>

            <?php foreach ($offers as $offer) : ?>
                <div class="clear">

                </div>
            <img src="image/webshop/<?=esc($row->image)?>?w=150" class="productImage" title="Image of <?=esc($row->name)?>">

            <div class="scrollable"><?=esc($offer->description); ?></div>
            <div><?=esc($offer->new_price); ?> kr</div>
            <div><?=esc($offer->discount); ?>% rabatt</div>

        <?php endforeach ?>


</article>
<article class="category_cloud">
    <h2>Kategorier</h2>

            <?php foreach ($categories as $category) {
                if ($category->amount >= 5) {
                    echo "<div class='extra_large_font'><a href='webshop-new?catId=" . esc($category->cat_id) . "'>" . esc($category->category) . " " . "</a></div>";
                } else if ($category->amount >= 4 && $category->amount < 5) {
                    echo "<div class='large_font'><a href='webshop-new?catId=" . esc($category->cat_id) . "'>" . esc($category->category) . " " . "</a></div>";
                } else if ($category->amount >= 2 && $category->amount <= 3) {
                    echo "<div class='medium_font'><a href='webshop-new?catId=" . esc($category->cat_id) . "'>" . esc($category->category). " "  . "</a></div>";
                } else if ($category->amount < 2) {
                    echo "<div class='small_font'><a href='webshop-new?catId=" . esc($category->cat_id) . "'>" . esc($category->category). " "  . "</a></div>";
                };
};
    ?>


</article>

</div>
