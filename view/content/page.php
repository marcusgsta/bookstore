<?php
$content = $data;
// $route = getGet('route');
// if (isset($route)) {
//     var_dump($route);
// }

$content->data = esc($content->data);
if (isset($content->filter)) {
    $content->data = $app->textfilter->doFilter($content->data, $content->filter);
}

?>
<div class="container">

<article>
    <header>
        <h1><?= esc($content->title) ?></h1>
        <p><i>Latest update: <time datetime="<?= esc($content->modified_iso8601) ?>" pubdate><?= esc($content->modified) ?></time></i></p>
    </header>

    <?= $content->data ?>
</article>
