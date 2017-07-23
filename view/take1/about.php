<div class="container">
<?= isset($app->user_logged_in) ? $app->user_logged_in : "";?>
<a href="home">
<img src="image/books_logo.png?w=100" alt="Böcker" class="books left">
</a>
<?php
if (!$data) {
    return;
} else {
    $result = $data;
}

?>

<article>
    <header>
        <h1><?= esc($result->title) ?></h1>
    </header>
    <?php
    $result->data = esc($result->data);
    if (isset($result->filter)) {
        $result->data = $app->textfilter->doFilter($result->data, $result->filter);
    }
        echo $result->data; ?>
</article>
