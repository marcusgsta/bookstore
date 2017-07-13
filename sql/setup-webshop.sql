-- ------------------------------------------------------------------------
--
-- For lecture in oophp-v3 kmom03
--
-- CREATE DATABASE oophp;
-- GRANT ALL ON oophp.* TO user@localhost IDENTIFIED BY "pass";
-- USE magi16 (change to this database on the student server)

SET NAMES utf8;



-- ------------------------------------------------------------------------
--
-- Setup tables
--
DROP TABLE IF EXISTS `CartRow`;
DROP TABLE IF EXISTS `Cart`;
DROP TABLE IF EXISTS `Prod2Cat`;
DROP TABLE IF EXISTS `ProdCategory`;
DROP TABLE IF EXISTS `Inventory`;
DROP TABLE IF EXISTS `InvenShelf`;
DROP TABLE IF EXISTS `OrderRow`;
DROP TABLE IF EXISTS `InvoiceRow`;
DROP TABLE IF EXISTS `Invoice`;
DROP TABLE IF EXISTS `Order`;
DROP TABLE IF EXISTS `Product`;
DROP TABLE IF EXISTS `Customer`;



-- ------------------------------------------------------------------------
--
-- Product and product category
--
CREATE TABLE `ProdCategory` (
	`id` INT AUTO_INCREMENT,
	`category` CHAR(10),

	PRIMARY KEY (`id`)
);

-- CREATE TABLE `Product` (
-- 	`id` INT AUTO_INCREMENT,
--     `description` VARCHAR(20),
-- 	`price`INT,
-- 	`image`VARCHAR(20),
--
-- 	PRIMARY KEY (`id`)
-- );

CREATE TABLE `Product` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `name` varchar(20) DEFAULT NULL,
	  `description` varchar(60) DEFAULT NULL,
	  `price` decimal(10, 2) DEFAULT NULL,
	  `image` varchar(20) DEFAULT NULL,
      `recommended` INT(1),
  PRIMARY KEY (`id`),
  KEY `index_description` (`description`)
)
ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

CREATE TABLE `Prod2Cat` (
	`id` INT AUTO_INCREMENT,
	`prod_id` INT,
	`cat_id` INT,

	PRIMARY KEY (`id`),
    FOREIGN KEY (`prod_id`) REFERENCES `Product` (`id`),
    FOREIGN KEY (`cat_id`) REFERENCES `ProdCategory` (`id`)
);



-- ------------------------------------------------------------------------
--
-- Inventory and shelves
--
CREATE TABLE `InvenShelf` (
    `shelf` CHAR(6),
    `description` VARCHAR(40),

	PRIMARY KEY (`shelf`)
);

-- CREATE TABLE `Inventory` (
-- 	`id` INT AUTO_INCREMENT,
--     `prod_id` INT,
--     `shelf_id` CHAR(6),
--     `items` INT,
--
-- 	PRIMARY KEY (`id`),
-- 	FOREIGN KEY (`prod_id`) REFERENCES `Product` (`id`),
-- 	FOREIGN KEY (`shelf_id`) REFERENCES `InvenShelf` (`shelf`)
-- );

CREATE TABLE `Inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prod_id` int(11) DEFAULT NULL,
  `shelf_id` char(6) DEFAULT NULL,
  `items` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prod_id` (`prod_id`),
  KEY `shelf_id` (`shelf_id`),
  KEY `index_items` (`items`),
  CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`prod_id`) REFERENCES `Product` (`id`),
  CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`shelf_id`) REFERENCES `InvenShelf` (`shelf`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;



-- ------------------------------------------------------------------------
--
-- Customer
--
CREATE TABLE `Customer` (
	`id` INT AUTO_INCREMENT,
    `firstName` VARCHAR(20),
    `lastName` VARCHAR(20),

	PRIMARY KEY (`id`)
);

-- ------------------------------------------------------------------------
--
-- Cart
--

CREATE TABLE `Cart` (
	`id` INT AUTO_INCREMENT,
	`customer` INT,
    `deleted` DATETIME DEFAULT NULL,

	PRIMARY KEY (`id`),
	FOREIGN KEY (`customer`) REFERENCES `users` (`id`)
);

CREATE TABLE `CartRow` (
	`id` INT AUTO_INCREMENT,
    `cart` INT,
    `product` INT,
	`items` INT,

	PRIMARY KEY (`id`),
	FOREIGN KEY (`cart`) REFERENCES `Cart` (`id`),
	FOREIGN KEY (`product`) REFERENCES `Product` (`id`)
);


-- ------------------------------------------------------------------------
--
-- Order
--
CREATE TABLE `Order` (
	`id` INT AUTO_INCREMENT,
    `customer` INT,

      -- MySQL version 5.6 and higher
  -- `published` DATETIME DEFAULT CURRENT_TIMESTAMP,
  -- `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
  -- `updated` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

  -- MySQL version 5.5 and lower
  `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated` DATETIME DEFAULT NULL, --  ON UPDATE CURRENT_TIMESTAMP,
  `deleted` DATETIME DEFAULT NULL,
  `delivery` DATETIME DEFAULT NULL,

	PRIMARY KEY (`id`),
	FOREIGN KEY (`customer`) REFERENCES `users` (`id`)
);

CREATE TABLE `OrderRow` (
	`id` INT AUTO_INCREMENT,
    `order` INT,
    `product` INT,
	`items` INT,

	PRIMARY KEY (`id`),
	FOREIGN KEY (`order`) REFERENCES `Order` (`id`),
	FOREIGN KEY (`product`) REFERENCES `Product` (`id`)
);



-- ------------------------------------------------------------------------
--
-- Invoice
--
CREATE TABLE `Invoice` (
	`id` INT AUTO_INCREMENT,
    `order` INT,
    `customer` INT,
	`created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

	PRIMARY KEY (`id`),
	FOREIGN KEY (`order`) REFERENCES `Order` (`id`),
	FOREIGN KEY (`customer`) REFERENCES `Customer` (`id`)
);

CREATE TABLE `InvoiceRow` (
	`id` INT AUTO_INCREMENT,
    `invoice` INT,
    `product` INT,
	`items` INT,

	PRIMARY KEY (`id`),
	FOREIGN KEY (`invoice`) REFERENCES `Invoice` (`id`),
	FOREIGN KEY (`product`) REFERENCES `Product` (`id`)
);


--
-- Inventory Log table
--
DROP TABLE IF EXISTS InventoryLog;
CREATE TABLE InventoryLog
(
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
    `what` VARCHAR(20),
    `when` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `prod_id` INT,
	`old_amount` NUMERIC,
    `new_amount` NUMERIC
);

--
-- Trigger for logging updating inventory
--
DROP TRIGGER IF EXISTS LogInventoryUpdate;
DELIMITER //

CREATE TRIGGER LogInventoryUpdate
AFTER UPDATE
ON Inventory
	FOR EACH ROW
BEGIN
	IF NEW.items < 5 THEN
		INSERT INTO InventoryLog (`what`, `prod_id`, `old_amount`, `new_amount`)
        VALUES ("trigger", NEW.prod_id, OLD.items, NEW.items);
END IF;
	END
//
DELIMITER ;

-- ------------------------------------------------------------------------
-- View VinventoryLog

DROP VIEW IF EXISTS VInventoryLog;
CREATE VIEW VInventoryLog AS
SELECT
 Product.name,
 InventoryLog.prod_id,
 InventoryLog.when,
 InventoryLog.old_amount,
 InventoryLog.new_amount
 FROM InventoryLog
	INNER JOIN Product
		ON InventoryLog.prod_id = Product.id
;

SELECT * FROM VInventoryLog;
-- ------------------------------------------------------------------------
--
-- Buy some stuff to get it up and running,
-- the first truck has arrived and you need to
-- insert the details into you database.
--

-- ------------------------------------------------------------------------
--
-- Start with the product catalogue
--
INSERT INTO `ProdCategory` (`category`) VALUES
("kitchen"), ("utensils"), ("plates"), ("egg-cups")
;


INSERT INTO `Product` (`id`, `name`, `description`, `price`, `image`) VALUES
(1, 'Super Blender', 'Blender', 90, 'blender.jpg'),
(2, 'Super Egg Cup', 'Egg Cup 1', 90, 'egg-cup-1.jpg'),
(3, 'Super Cheesus', 'Cheese Slicer', 90, 'cheese-slicer.jpg'),
(4, 'Fab Egg Cup', 'Egg Cup 2', 90, 'egg-cup-2.jpg'),
(5, 'Kitchen Collection', 'Kitchen Utensils', 400, 'utensils-kitchen.jpg');

INSERT INTO `Prod2Cat` (`id`, `prod_id`, `cat_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 3, 1),
(4, 3, 2),
(5, 2, 4),
(6, 2, 1),
(7, 4, 4),
(8, 4, 1),
(9, 5, 1),
(10, 5, 2);

DROP VIEW IF EXISTS VProduct;
CREATE VIEW VProduct AS
SELECT
	P.id,
	P.name,
    P.description,
	P.image,
    P.recommended,
    GROUP_CONCAT(DISTINCT category) AS category,
	P.price,
    Offer.new_price,
	I.items
FROM Product AS P
	LEFT OUTER JOIN Prod2Cat AS P2C
		ON P.id = P2C.prod_id
	LEFT OUTER JOIN ProdCategory AS PC
		ON PC.id = P2C.cat_id
	LEFT OUTER JOIN Offer
		ON P.id = Offer.product
	LEFT OUTER JOIN Inventory AS I
		ON P.id = I.prod_id
GROUP BY P.id
ORDER BY P.name
;



-- ------------------------------------------------------------------------
--
-- The truck has arrived, put the stuff into shelfs and update the database
--
INSERT INTO `InvenShelf` (`shelf`, `description`) VALUES
("AAA101", "House A, aisle A, part A, shelf 101"),
("AAA102", "House A, aisle A, part A, shelf 102")
;

INSERT INTO `Inventory` (`prod_id`, `shelf_id`, `items`) VALUES
(1, "AAA101", 100), (2, "AAA102", 100),
(3, "AAA101", 100), (4, "AAA102", 100), (5, "AAA102", 100)
;

SELECT * FROM InvenShelf;

INSERT INTO `Offer` (name, description, discount, new_price ) VALUES
("Super Blender", 81, 10, "hej")
;

--
-- View connecting products with their place in the inventory
-- and offering reports for inventory and sales personal.
--
DROP VIEW IF EXISTS VInventory;
CREATE VIEW VInventory AS
SELECT
	S.shelf,
    S.description AS location,
    I.items,
    P.name
FROM Inventory AS I
	INNER JOIN InvenShelf AS S
		ON I.shelf_id = S.shelf
	INNER JOIN Product AS P
		ON P.id = I.prod_id
ORDER BY S.shelf
;

SELECT * FROM VInventory;

DROP VIEW IF EXISTS VBlog;
CREATE VIEW VBlog AS
SELECT
	C.path,
	C.slug,
	C.title,
	C.data,
	C.type,
	C.filter,
	C.published,
	C.created,
	C.updated,
	C.deleted
	FROM Content AS C
	WHERE C.type = 'post'
	ORDER BY C.published
	;
    





-- Create a table for this week's offer
DROP TABLE IF EXISTS `Offer`;
CREATE TABLE `Offer` (
	id INT(3) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    name VARCHAR(100),
    product INT(4),
    description VARCHAR(200),
    discount NUMERIC(10,2),
    new_price NUMERIC(10,2),
    `deleted` datetime DEFAULT NULL,
    
    FOREIGN KEY (product) REFERENCES Product (id)
);
    
-- INSERT INTO Offer VALUES (name, description, price)(
-- 	
-- );
    -- FUNCTION TO CREATE OFFER PRICE

DELIMITER //

DROP FUNCTION IF EXISTS Discount //
CREATE FUNCTION Discount(
	price NUMERIC,
    discount NUMERIC(10, 2)
)
RETURNS NUMERIC
BEGIN
	RETURN price - (price * discount);
END
//

DELIMITER ;

-- USAGE:
SELECT price,
Discount(price, 0.2) AS 'Discount 20%'
FROM Offer; 


    
    -- DROP VIEW IF EXISTS VOffer;
--     CREATE VIEW VOffer AS
--     SELECT
--     name,
--     description,
--     price 
    


-- Create a view for products

-- DROP VIEW IF EXISTS VProducts;
-- CREATE VIEW VProducts AS
-- SELECT
-- 	S.shelf,
--     S.description AS location,
--     I.items,
--     P.description
-- FROM Inventory AS I
-- 	INNER JOIN InvenShelf AS S
-- 		ON I.shelf_id = S.shelf
-- 	INNER JOIN Product AS P
-- 		ON P.id = I.prod_id
-- ORDER BY S.shelf
-- ;



INSERT INTO `Cart` (`customer`) VALUES
(1), (2)
;

INSERT INTO `CartRow` (`cart`, `product`, `items`) VALUES
(1, 3, 2),
(1, 4, 2),
(2, 1, 1),
(2, 2, 1),
(2, 3, 1),
(2, 4, 96)
;


-- ------------------------------------------------------------------------------
-- PROCEDURE createCart


DROP PROCEDURE IF EXISTS createCart;

DELIMITER //

CREATE PROCEDURE createCart(
	thisCustomer INT
)
BEGIN
START TRANSACTION;
INSERT INTO Cart
SET
customer = thisCustomer;
SELECT LAST_INSERT_ID() AS id;
COMMIT;

END
//
DELIMITER ;
-- USAGE:
-- CALL createCart(customerId);
-- Example:
-- CALL createCart(2);
--
-- ------------------------------------------------------------------------------
-- PROCEDURE addToCart

USE oophp;
DROP PROCEDURE IF EXISTS addToCart;

DELIMITER //

CREATE PROCEDURE addToCart(
	cartId INT,
	thisProductId NUMERIC,
	amount NUMERIC
)
BEGIN
	DECLARE exist INT(2);
START TRANSACTION;

SELECT product INTO exist FROM CartRow WHERE product = thisProductId
AND cart = cartId;
SELECT exist;
	IF (exist IS NULL) THEN
    	INSERT INTO CartRow
			SET
				cart = cartId,
				product = thisProductId,
				items = amount;
    ELSE
		UPDATE CartRow
			SET
				items = items + amount
			WHERE
				product = thisProductId
                AND
                cart = cartId
			LIMIT 1
;

END IF;

COMMIT;

END
//
DELIMITER ;
-- USAGE:
-- CALL addToCart(cartId, productId, amound)
-- Example:
CALL addToCart(2, 4, 1);

-- ------------------------------------------------------------------------------
-- PROCEDURE removeFromCart
-- Remove product from cart
DROP PROCEDURE IF EXISTS removeFromCart;

DELIMITER //

CREATE PROCEDURE removeFromCart(
	cartId NUMERIC,
    productId NUMERIC
)
BEGIN
START TRANSACTION;

DELETE FROM CartRow
WHERE product = productId AND cart = cartId;
COMMIT;

END
//
DELIMITER ;
-- USAGE:
-- CALL removeFromCart(cartId, productId)
-- Example:
-- CALL removeFromCart(4, 2);
--

-- ------------------------------------------------------------------------------
-- PROCEDURE makeOrder
-- Make an order from a cart
DROP PROCEDURE IF EXISTS makeOrder;

DELIMITER //

CREATE PROCEDURE makeOrder(
	cartId INT
)
BEGIN
DECLARE amount INT;
DECLARE i INT DEFAULT 0;
DECLARE n INT DEFAULT 0;
DECLARE productId INT;
DECLARE orderNr INT;
DECLARE currentAmount NUMERIC;

START TRANSACTION;

INSERT INTO `Order` (customer)
SELECT customer FROM Cart
WHERE id = cartId;
SET orderNr = LAST_INSERT_ID();

SELECT COUNT(*) FROM CartRow WHERE cart = cartId INTO n;
SET i = 0;
aLoop: WHILE i < n DO
	SELECT items FROM CartRow WHERE cart = cartId LIMIT i,1
    INTO amount;
	SELECT product FROM CartRow WHERE cart = cartId LIMIT i,1
    INTO productId;

INSERT INTO OrderRow
(`order`, `product`, `items`)
SELECT
	orderNr, `product`, `items`
FROM CartRow
	WHERE cart = cartId
		LIMIT i,1;

SET currentAmount =
(SELECT items FROM Inventory
WHERE prod_id = productId);
	IF currentAmount - amount < 0 THEN
		ROLLBACK;
		SELECT "Vi har inte tillräckligt många produkter på lagret för att genomföra köpet.";
        LEAVE aLoop;
	ELSE

	UPDATE Inventory
SET
	items = items - amount
WHERE
	prod_id = productId
;
SET i = i + 1;
END IF;
END WHILE;

COMMIT;

END
//
DELIMITER ;
-- USAGE:
-- CALL makeOrder(cartId)
-- Example:
-- CALL makeOrder(2);
--

-- ------------------------------------------------------------------------------
-- PROCEDURE showOrder
-- Show order rows from cart with a certain ID
DROP PROCEDURE IF EXISTS showOrder;

DELIMITER //

CREATE PROCEDURE showOrder(
	orderId NUMERIC
)
BEGIN
START TRANSACTION;

SELECT
*
FROM OrderRow AS R
INNER JOIN `Order` AS O
	ON O.id = R.order
WHERE O.id = orderId
;

COMMIT;

END
//
DELIMITER ;
-- USAGE:
-- CALL showOrder(orderId)
-- Example:
-- CALL showOrder(3);
--

-- PROCEDURE showUsersOrder
-- Show order rows from order with a certain ID
DROP PROCEDURE IF EXISTS showUsersOrder;

DELIMITER //

CREATE PROCEDURE showUsersOrder(
	orderId NUMERIC
)
BEGIN
START TRANSACTION;

SELECT
R.id,
R.order,
R.product,
R.items,
P.name,
P.price,
Offer.new_price,
(P.price * R.items) as 'total'
FROM OrderRow AS R
INNER JOIN `Order` AS O
	ON R.order = O.id
LEFT OUTER JOIN `Product` AS P
	ON R.product = P.id
LEFT OUTER JOIN Offer
	ON P.id = Offer.product
WHERE O.id = orderId
-- WHERE R.id = orderId
ORDER BY R.order
;

COMMIT;

END
//
DELIMITER ;

-- USAGE:
-- CALL showUsersOrder(orderId)
-- Example:
-- CALL showUsersOrder(3);
--

-- PROCEDURE Recommended
-- Get for recommended products
-- Takes 3 product id's. Set to NULL if not wanted.

DROP PROCEDURE IF EXISTS Recommended;
DELIMITER //

CREATE PROCEDURE Recommended(
	productId1 INT,
    productId2 INT,
    productId3 INT
)
BEGIN

SELECT
P.id,
P.name,
P.description,
P.image,
P.price,
Offer.new_price
FROM Product AS P
	LEFT OUTER JOIN Offer
		ON P.id = Offer.product
WHERE P.id = productId1
OR P.id = productId2
OR P.id = productId3
LIMIT 3;

END
//
DELIMITER ;

-- EXAMPLE
CALL Recommended(1, 2, NULL);

-- PROCEDURE removeOrder
-- Assigns order with certain orderId to DELETED
DROP PROCEDURE IF EXISTS removeOrder;

DELIMITER //

CREATE PROCEDURE removeOrder(
	orderId NUMERIC
)
BEGIN
START TRANSACTION;

UPDATE
`Order`
SET
deleted = NOW()
WHERE
id = orderId;
COMMIT;

END
//
DELIMITER ;
-- USAGE:
-- CALL removeOrder(orderId)
-- Example:
-- CALL removeOrder(3);
--


-- PROCEDURE removeCart
-- Assigns cart with certain cartId to DELETED
DROP PROCEDURE IF EXISTS removeCart;

DELIMITER //

CREATE PROCEDURE removeCart(
	cartId NUMERIC
)
BEGIN
START TRANSACTION;

UPDATE
Cart
SET
deleted = NOW()
WHERE
id = cartId;
COMMIT;

END
//
DELIMITER ;
-- USAGE:
-- CALL removeOrder(orderId)
-- Example:
-- CALL removeOrder(3);
--
-- ------------------------------------------------------------------------------
-- PROCEDURE showCart
-- Show cart rows from cart with a certain ID
DROP PROCEDURE IF EXISTS showCart;

DELIMITER //

CREATE PROCEDURE showCart(
	cartId NUMERIC
)
BEGIN
START TRANSACTION;

SELECT
*
FROM CartRow AS R
INNER JOIN Cart AS C
	ON C.id = R.cart
WHERE C.id = cartId;

COMMIT;

END
//
DELIMITER ;
-- USAGE:
-- CALL showCart(cartId)
-- Example:
-- CALL showCart(2);
--

-- FUNCTION getPrice
-- Get correct price discounted or not for a product
DROP FUNCTION IF EXISTS getPrice;

DELIMITER //

CREATE FUNCTION getPrice(
	productId INT(4)
)
RETURNS FLOAT(10, 2)

BEGIN
	DECLARE newPrice FLOAT(10, 2);
	DECLARE oldPrice FLOAT(10, 2);
	DECLARE price FLOAT(10, 2);
    
    -- SET price = 3;

SELECT Offer.new_price
INTO @price
FROM Offer
WHERE product = productId
-- 	LEFT OUTER JOIN Product AS P
-- 		ON Offer.product = P.id
	-- WHERE P.id = productId
		LIMIT 1
;
-- 
-- SELECT @oldPrice:=P.price
-- FROM Product AS P
-- 	WHERE P.id = productId
-- 		LIMIT 1;
-- 
-- IF newPrice IS NULL THEN SET price = oldPrice;
-- ELSE SET price = newPrice;
-- END IF;

RETURN price;

END//
DELIMITER ;

-- USAGE:
SELECT
getPrice(1);

-- PROCEDURE getPrice
-- Get correct price discounted or not for a product
DROP PROCEDURE IF EXISTS getPrice;

DELIMITER //

CREATE PROCEDURE getPrice(
	productId INT(4)
)

BEGIN
	DECLARE newPrice FLOAT(10, 2);
	DECLARE oldPrice FLOAT(10, 2);
	DECLARE currentPrice FLOAT(10, 2);

SELECT price
INTO oldPrice
FROM Product
	WHERE id = productId
    LIMIT 1
;

SELECT IFNULL( (
SELECT new_price
FROM Offer
WHERE product = productId
AND (deleted IS NULL OR deleted > NOW())
LIMIT 1) , oldPrice);


END
//

DELIMITER ;

-- USAGE:

CALL getPrice(5);


-- PROCEDURE showCart
-- Show cart rows from cart from a users ID
DROP PROCEDURE IF EXISTS showUsersCart;

DELIMITER //

CREATE PROCEDURE showUsersCart(
	userId NUMERIC
)
BEGIN
START TRANSACTION;

SELECT
	CR.id,
	CR.cart,
    CR.product,
	CR.items,
	P.name,
	P.image,
	P.price,
    Offer.new_price,
	C.id,
	C.customer,
	(P.price * CR.items) as 'total'
FROM CartRow AS CR
	LEFT OUTER JOIN Product AS P
		ON CR.product = P.id
	LEFT OUTER JOIN Cart AS C
		ON C.id = CR.cart
	LEFT OUTER JOIN Offer
		ON Offer.product = P.id
	WHERE C.customer = userId
GROUP BY CR.id, 'total'
ORDER BY CR.cart;

COMMIT;

END
//
DELIMITER ;

-- View to show cart
-- DROP VIEW IF EXISTS vCart;
-- CREATE VIEW vCart
-- SELECT
-- 	CR.id,
-- 	CR.cart,
--     CR.product,
-- 	CR.items,
-- 	P.name,
-- 	P.image,
-- 	P.price,
-- 	C.id,
-- 	C.customer,
-- 	(P.price * CR.items) as 'total',
-- 	sum(P.price) as 'sumtotal'
-- FROM CartRow AS CR
-- 	LEFT OUTER JOIN Product AS P
-- 		ON CR.product = P.id
-- 	LEFT OUTER JOIN Cart AS C
-- 		ON C.id = CR.cart
-- 	WHERE C.customer = userId
-- GROUP BY CR.id
-- ORDER BY CR.cart;

-- FUNCTION TO CALCULATE "MOMS" ON PRODUCT PRICE

DELIMITER //

DROP FUNCTION IF EXISTS Moms //
CREATE FUNCTION Moms(
	price NUMERIC
)
RETURNS NUMERIC
BEGIN
	RETURN price * 0.20;
END
//

DELIMITER ;

-- USAGE:
SELECT price,
Moms(price) AS 'Moms 20%'
FROM Product;


-- DROP VIEW IF EXISTS VCartRows;
-- CREATE VIEW VCartRows AS
-- SELECT
-- 	CR.id,
-- 	CR.cart,
--     CR.product,
-- 	CR.items,
-- 	P.name
-- FROM CartRow AS CR
-- 	LEFT OUTER JOIN Product AS P
-- 		ON CR.product = P.id
-- 	LEFT OUTER JOIN Inventory AS I
-- 		ON P.id = I.prod_id
-- GROUP BY CR.id
-- ORDER BY CR.cart
-- ;
--
-- DROP VIEW IF EXISTS VCart;
-- CREATE VIEW VCart AS
-- SELECT
-- 	LEFT OUTER JOIN Cart as C
-- 		ON CR.id = C.id


-- INDEXES

-- Denna kan jag använda. Från full table scan med 9 rader, till
-- att scanna 3 rader. type:range.
-- jag lade till ett index (icke unikt) på title-kolumnen.
-- SELECT * FROM Content WHERE title LIKE "Nu%";
-- EXPLAIN SELECT * FROM Content WHERE title LIKE "Nu%";
--
-- CREATE INDEX index_title ON Content (title);
--
-- EXPLAIN Content;
-- -- ett index på en varchar-kolumn kan vara en bra ide
-- -- men bara på delsträngar där man vet vänstra/första delen på strängen.
--
-- -- index för numeriska värden
--
-- EXPLAIN Inventory;
--
-- SELECT * FROM Inventory WHERE items < 50;
-- EXPLAIN SELECT * FROM Inventory WHERE items < 50;
--
-- SELECT * FROM Inventory;
--
-- CREATE INDEX index_items ON Inventory(items);
-- -- detta var också effektivt. Om jag vill hämta alla rader där det finns färre än ex. 50 enheter
-- -- från lagret Inventory, så kan jag lägga till ett index på kolumnen items.
-- -- Resultatet blev att gå från full table scan till att bara hämta en rad, vilket också är
-- -- resultatet.
--
-- SHOW INDEX FROM Inventory;
--
-- SHOW CREATE TABLE Inventory;
-- SHOW CREATE TABLE Product;
--
-- EXPLAIN Product;
-- SELECT * FROM Product;
-- SELECT * FROM Product WHERE description LIKE "%gg%";
-- EXPLAIN SELECT * FROM Product WHERE description LIKE "%gg%";
-- EXPLAIN SELECT * FROM Product WHERE description LIKE "Egg%";
-- CREATE INDEX index_description ON Product(description);
--
