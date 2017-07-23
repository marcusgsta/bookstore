<?php

if (!$data) {
    return;
} else {
    $resultset = $data;
}


?>
<div class="container">


    <?= isset($app->user_logged_in) ? $app->user_logged_in : "";?>
    <a href="home">
    <img src="image/books_logo.png?w=100" alt="Böcker" class="books left">
    </a>
    <article class="newspage">
    <h1>Nyheter</h1>
    <p>Här kommer senaste nyheter angående böcker</p>

<?php foreach ($resultset as $row) : ?>
<section>
    <header>
        <h2><a href="newspost?route=<?= esc($row->slug) ?>"><?= esc($row->title) ?></a></h2>
        <p><i>Published: <time datetime="<?= esc($row->published_iso8601) ?>" pubdate><?= esc($row->published) ?></time></i></p>
    </header>
    <?php
    $row->data = esc($row->data);
    if (isset($row->filter)) {
        $row->data = $app->textfilter->doFilter($row->data, $row->filter);
    }
        echo $row->data;
    ?>
</section>
<?php endforeach; ?>

</article>
