<div class="container">
    <?= isset($app->user_logged_in) ? $app->user_logged_in : "";?>
<img src="image/books_logo.png?w=200" alt="Böcker" class="left">

<?php

if (!$data) {
    return;
} else {
    $resultset = $data;
}

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
</article>
<article class="most_sold">
    <h2>Mest sålda produkt</h2>
</article>
<article class="this_week">
    <h2>Veckans erbjudande</h2>
</article>
<article class="recommended_products">
    <h2>Rekommenderade produkter</h2>
</article>
