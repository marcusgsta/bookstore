<?php
/**
*   Class Webshop for handling webshop
*/
namespace Mag\Webshop;

/**
* A Webshop class for everything related to the webshop.
*/
class Webshop
{
    /**
     * @var PDO          $db     the database object
     */
    public $db;

    /**
    * Constructor
    * @return void
    */
    public function __construct($database)
    {
        $this->setDatabase($database);
    }

    /**
     * Set database
     * @param $database string The name of the database
     * @return void
     */
    public function setDatabase($database)
    {
        $this->db = $database;
    }

    /**
     * add a product to a user's cart
     * @param $cartId int The cart id
     * @param $productId int The product id
     * @param $amount int The amount
     * @return void
     */
    public function addToCart($cartId, $productId, $amount)
    {
        $sql = "CALL addToCart('$cartId', '$productId', '$amount');";
        $this->db->execute($sql);
    }

    /**
     * Get a user's cart id
     * @param $userId int The user's id
     * @return $cartId int The cart id
     */
    public function getCartId($userId)
    {
        $sql = "SELECT id FROM Cart WHERE customer = $userId";
        // $cartId = $this->db->executeFetch($sql);
        $cartId = $this->db->executeFetchAll($sql);
        $cartId = end($cartId);
        // $cartId = $this->db->fetchOne($sql);
        if ($cartId == false) {
            // $sql = "CALL createCart($userId)";
            $sql = "INSERT INTO Cart SET customer = $userId;";
            $this->db->execute($sql);

            $sql = "SELECT LAST_INSERT_ID() as id;";
            $cartId = $this->db->executeFetch($sql);
            // $cartId = $this->db->fetchOne($sql);

            // $cartId = end($cartId);
            $cartId = $cartId->id;

            return $cartId;
        };
        return $cartId->id;
    }

    /**
     * Get a user's order id ('s)
     * @param $userId int The user's id
     * @return $cartId int The cart id ('s)
     */
    public function getOrderId($userId)
    {

        $sql = "SELECT id FROM `Order` WHERE customer = '$userId'";
        $orderIds = $this->db->executeFetchAll($sql);
        // get the last key in the array,
        // that is the last order from this customer

        $lastId = end($orderIds);
        $lastId = $lastId->id;

        return $lastId;
    }

    /**
     * Get all order ids for a user
     * @param $userId int The user's id
     * @return $orderIds array The order ids
     */
    public function getOrderIds($userId)
    {
        $sql = "SELECT id FROM `Order` WHERE customer = '$userId'";
        $orderIds = $this->db->executeFetchAll($sql);

        return $orderIds;
    }

    /**
     * Get all orders for a user
     * @param $userId int The user's id
     * @return $orders array The orders
     */
    public function getOrders($userId)
    {
        $sql = "SELECT id, created FROM `Order`
        WHERE customer = '$userId'";
        $orders = $this->db->executeFetchAll($sql);

        return $orders;
    }

    /**
     * remove a product from a user's cart
     * @param $cartId int The cart id
     * @param $productId int The product id
     * @param $amount int The amount
     * @return void
     */
    public function removeFromCart($cartId, $productId)
    {
        $sql = "CALL removeFromCart('$cartId', '$productId');";
        $this->db->execute($sql);
    }
}
