</div> <!-- end of container -->
<div class="footer">
<?php

if (isset($footer->data)) {
    $footer->data = esc($footer->data);
    echo $footer->data;
} else {
    echo "<p>&copy; Marcus Gustafsson</p>";
}

?>
</div>

</body>
</html>
