# API for webshop SQL-commands

## Stored Procedures

### createCart
- Create a cart for a customer
- Before it can be used, a customer id must be created in table customer
USAGE:
CALL createCart(customerId);
EXAMPLE:
CALL createCart(2);

### addToCart
- Add a cartRow to a cart.
USAGE:
CALL addToCart(cartId, productId, amount)
Example:
CALL addToCart(1, 2, 50);

### showCart
- Show all cart rows associated with a cart.
USAGE:
CALL showCart(cartId)
EXAMPLE:
CALL showCart(3);

### showUsersCart
- Show all cart rows associated with a cart from user id.
USAGE:
CALL showUsersCart(userId)
EXAMPLE:
CALL showUsersCart(2);

## removeFromCart
- Remove product from cart. Removes row from table CartRow with
    from cartId and productId.
USAGE:
CALL removeFromCart(cartId, productId);
EXAMPLE:
CALL removeFromCart(2, 1);

## makeOrder
- Make an order from a shopping cart
- Creates a row in table Order, and creates one or several rows in
table OrderRow.
- Takes items from the inventory and puts in order, for each
ordered product.
USAGE:
CALL makeOrder(cartId);
EXAMPLE:
CALL makeOrder(3);

## showOrder
- Show all rows in table orderRow of an order with id = orderId
USAGE:
CALL showOrder(orderId);
EXAMPLE:
CALL showOrder(3);

## removeOrder
- Remove an order from orderId
- Does not remove, but indicates as DELETED.
USAGE:
CALL removeOrder(orderId);
EXAMPLE:
CALL removeOrder(2);

## SELECT * FROM view VInventoryLog
- To see which products that needs to be bought in
- Shows an inventor log, triggered from new orders compared to
items in inventory.

## Function to calculate 20 % tax on a product
-- USAGE:
SELECT price,
Moms(price) AS 'Moms 20%'
FROM Product;
