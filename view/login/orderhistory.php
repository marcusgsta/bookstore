<?php

if (!$data) {
    return;
}

?>

<div class="container">
<h1>Orderhistorik för </h1>

<?php foreach($data as $order): ?>
    <table>
        <tr>
            <th>Order id</th><th>Orderdatum</th>
        </tr>
        <tr>
            <td><a href="order?order_id=<?=$order->id?>"><?=$order->id?></a></td><td><?=$order->created?></td>
        </tr>
    </table>


<?php endforeach;?>
