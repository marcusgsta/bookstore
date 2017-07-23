<?php

if (!$data) {
    return;
} else {
    $resultset = $data;
}


?>
<div class="container">
    <a href="../home">
    <img src="../image/books_logo.png?w=100" alt="Böcker" class="books left">
    </a>
<article>

<?php foreach ($resultset as $row) : ?>
<section>
    <header>
        <h1><a href="block?route=<?= esc($row->slug) ?>"><?= esc($row->title) ?></a></h1>
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
