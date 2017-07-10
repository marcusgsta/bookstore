<div class="container">
<?= isset($app->user_logged_in) ? $app->user_logged_in : "";?>
<img src="image/books_logo.png?w=200" alt="Böcker" class="left">

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
