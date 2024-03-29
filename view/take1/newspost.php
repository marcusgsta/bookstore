<?php

$content = $data;
?>
<div class="container">
    <a href="home">
    <img src="image/books_logo.png?w=100" alt="Böcker" class="books left">
    </a>
<article class="newspages">
    <header>
        <h1><?= esc($content->title) ?></h1>
        <p><i>Published: <time datetime="<?= esc($content->published_iso8601) ?>" pubdate><?= esc($content->published) ?></time></i></p>
    </header>
    <?php
    $content->data = esc($content->data);
    if (isset($content->filter)) {
        $content->data = $app->textfilter->doFilter($content->data, $content->filter);
    }
        echo $content->data; ?>
</article>
