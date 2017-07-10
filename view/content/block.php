<?php

$content = $data;
?>
<div class="container">

<article>
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
