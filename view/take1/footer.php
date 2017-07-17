</div> <!-- end of container -->
<div class="footer">
<?php

if (isset($app->footer)) {
    $footer = $app->footer->data;
    $footer = esc($footer);
    echo $footer;
} else {
    echo "<p>&copy; Marcus Gustafsson</p>";
}

?>
</div>

</body>
</html>
