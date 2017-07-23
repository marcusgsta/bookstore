<?php

if (!$data) {
    return;
}

?>

<div class="container">
    <a href="home">
<img src="image/books_logo.png?w=100" alt="Böcker" class="books left">
</a>
<h1>Orderhistorik för </h1>

<?php foreach ($data as $order) : ?>
    <table>
        <tr>
            <th>Order id</th><th>Orderdatum</th>
        </tr>
        <tr>
            <td><a href="order?order_id=<?=$order->id?>"><?=$order->id?></a></td><td><?=$order->created?></td>
        </tr>
    </table>


<?php endforeach;?>
