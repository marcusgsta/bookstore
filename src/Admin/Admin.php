<?php
/**
 * Class for handling administration pages
 *
 *
 */

namespace Mag\Admin;

/**
 * Class for handling administration pages
 * @var $db string The name of the database
 * @var $app string The app object
 * @return void
 */
class Admin
{
    /**
    * @var $db string The name of the database
    */
    public $db;

    /**
    * @var $app string The name of the database
    */
    public $app;

    /**
     * Constructor
     * @param $app string the app object
     * @return void
     */
    public function __construct($app)
    {

        $this->setDatabase($app->db);
        $this->setApp($app);
    }

    /**
     * Sets app
     * @param $app The app object
     * @return void
     */
    public function setApp($app)
    {
        $this->app = $app;
    }

    /**
     * Sets database
     * @param $database string The name of the database
     * @return void
     */
    public function setDatabase($database)
    {
        $this->db = $database;
    }

    /**
     * Deletes an account
     * @param $id string The id of the user
     * @var $message string     Success message
     * @return $message string
     */
    public function deleteAccount($id)
    {
        try {
            $this->db->execute("DELETE FROM users WHERE id='$id';");
            $message = "Användaren raderades!";
        } catch (Exception $e) {
            $message = "Caught exception: " .  $e->getMessage() . "\n";
        }

        return $message;
    }

    /**
     * Check if user is admin
     *
     * @param $userName string A username
     * @return bool
     */
    public function userIsAdmin($userName)
    {
        $this->db->execute("SELECT role FROM users WHERE name='$userName'");
        $res = $this->db->fetchOne();
        if ($res->role != 1) {
            return false;
        }
        return true;
    }

    /**
     * Function to create links for sorting.
     *
     * @param string $column the name of the database column to sort by
     * @param string $route  prepend this to the anchor href
     *
     * @return string with links to order by column.
     */
    public function orderby($column, $route)
    {
        return <<<EOD
<span class='orderby'>
<a href="{$route}orderby={$column}&order=asc">&darr;</a>
<a href="{$route}orderby={$column}&order=desc">&uarr;</a>
</span>
EOD;
    }

    /**
     * Adds user to the database
     * @param string $name The name of the user
     * @param string $pass The user's password
     * @param  string $rePass The user's password
     * @param  string $role The user's role
     * @param  string $gravatar The user's gravatar link
     * @return void
     */
    public function addUser($name, $pass, $rePass, $role, $gravatar)
    {
        // Check if username exists
        if ($this->app->access->exists($name)) {
            echo "<div class='container'><p>Användaren existerar redan! Välj ett annat användarnamn.</p>";
            header("Refresh:2; create_user");
            return false;
        }
        // Check passwords match
        if ($pass != $rePass) {
            echo "<div class='container'><p>Lösenord matchar inte!</p>";
            header("Refresh:2; create_user");
            return false;
        }

        if ($name != "" and $role != "" and $pass != "") {
        // Make a hash of the password
            $cryptPass = password_hash($pass, PASSWORD_DEFAULT);
            $this->db->execute("INSERT into users (name, role, gravatar, pass)
                    VALUES ('$name', '$role', '$gravatar', '$cryptPass')");
            echo "<div class='container'><p>Användaren lades till!</p>";
        }
    }

    /**
     * Edit user account
     *
     * @param string $id The user's id
     * @param string $name The user's name
     * @param string $pass The user's password
     * @param string $role  The user's role
     * @param string $gravatar  The user's gravatar link
     *
     * @return void
     */
    public function editUser($id, $name, $pass, $role, $gravatar)
    {
        if ($name != "") {
            $this->db->execute("UPDATE users SET name='$name' WHERE id='$id'");
        }

        if ($pass != "") {
            $cryptPass = password_hash($pass, PASSWORD_DEFAULT);
            $this->db->execute("UPDATE users SET pass='$cryptPass' WHERE id='$id'");
        }

        if ($role != "") {
            $this->db->execute("UPDATE users SET role='$role' WHERE id='$id'");
        }

        if ($gravatar != "") {
            $this->db->execute("UPDATE users SET gravatar='$gravatar' WHERE id='$id'");
        }
    }

    /**
     * Search for user
     * @param string $user  A username
     * @var array $res      The resultset
     * @return $res
     */
    public function search($user)
    {
        $this->db->execute("SELECT * FROM users WHERE name LIKE '%$user%'");
        $res = $this->db->fetchAll();
        return $res;
    }

    /**
     * Get userId from userName
     * @param string $user  A username
     * @var $res
     * @return int $res The user's id
     */
    public function getUserId($user)
    {
        $sql = "SELECT id FROM users WHERE name = '$user'";
        $res = $this->db->executeFetch($sql);
        $res = $res->id;
        return $res;
    }


    /**
     * Search for product by name or description
     * @param string $searchString  A search string
     * @var array $res      The resultset
     * @return $res
     */
    public function searchProducts($searchString)
    {
        $this->db->execute("SELECT * FROM VProduct WHERE name LIKE '%$searchString%' OR description LIKE '%$searchString%'");
        $res = $this->db->fetchAll();
        return $res;
    }

    /**
     * Show all user accounts
     * @param string $orderby  Which column to order by, default: 'name'
     * @param string $order  ASC or DESC, default: 'ASC'
     * @var array $res      The resultset
     * @return $res
     */
    public function showAccounts($orderby = 'name', $order = 'ASC')
    {
        $this->db->execute("SELECT id, name, email, gravatar, role FROM users ORDER BY $orderby $order");
        $res = $this->db->fetchAll();
        //  executeFetchAll
        return $res;
    }

        /**
     * Create navigation among pages.
     *
     * @param integer $hits per page.
     * @param integer $page current page.
     * @param integer $max number of pages.
     * @param integer $min is the first page number, usually 0 or 1.
     * @return string as a link to this page.
     */
    public function getPageNavigation($page, $max, $min = 1)
    {
        $nav  = "<a href='" . $this->getQueryString(array('page' => $min)) . "'>&lt;&lt;</a> ";
        $nav .= "<a href='" . $this->getQueryString(array('page' => ($page > $min ? $page - 1 : $min) )) . "'>&lt;</a> ";

        for ($i=$min; $i<=$max; $i++) {
            $nav .= "<a href='" . $this->getQueryString(array('page' => $i)) . "'>$i</a> ";
        }

        $nav .= "<a href='" . $this->getQueryString(array('page' => ($page < $max ? $page + 1 : $max) )) . "'>&gt;</a> ";
        $nav .= "<a href='" . $this->getQueryString(array('page' => $max)) . "'>&gt;&gt;</a> ";
        return $nav;
    }


        /**
     * Create links for hits per page.
     *
     * @param array $hits a list of hits-options to display.
     * @return string as a link to this page.
     */
    public function getHitsPerPage($hits)
    {
        $nav = "Träffar per sida: ";
        foreach ($hits as $val) {
            $nav .= "<a href='" . $this->getQueryString(array('hits' => $val)) . "'>$val</a> ";
        }
        return $nav;
    }

        /**
     * Use the current querystring as base, modify it according to $options and return the modified query string.
     *
     * @param array $options to set/change.
     * @param string $prepend this to the resulting query string
     * @return string with an updated query string.
     */
    public function getQueryString($options, $prepend = '?')
    {
        // parse query string into array
        $query = array();
        parse_str($_SERVER['QUERY_STRING'], $query);

        // Modify the existing query string with new options
        $query = array_merge($query, $options);

        // Return the modified querystring
        return $prepend . http_build_query($query);
    }

    /**
     * Show all products
     * @param string $orderby  Which column to order by, default: 'name'
     * @param string $order  ASC or DESC, default: 'ASC'
     * @param $limit string
     * @var array $res      The resultset
     * @return $res
     */
    public function showProducts($orderby = 'name', $order = 'ASC', $limit = 10, $page = 1)
    {
        // $sql = "SELECT * FROM VMovie LIMIT $hits OFFSET " . (($page - 1) * $hits);
//SELECT * FROM VMovie LIMIT 2 OFFSET 2
        // $this->db->execute("SELECT * FROM VProduct ORDER BY $orderby $order
        // LIMIT $limit");
        // $res = $this->db->fetchAll();
        $sql = "SELECT
        	P.id,
            (select COUNT(id) FROM Product) as rows,
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
        ORDER BY $orderby $order
        LIMIT $limit
        OFFSET " . (($page - 1) * $limit);
        // $res = $this->db->executeFetchAll($sql);
        $res = $this->db->executeFetchAll($sql);
        return $res;
    }

    /**
     * Get most sold products
     * @param $limit string number of rows wanted
     * @var array $res      The resultset
     * @return $res
     */
    public function getMostSoldProduct($limit = '1')
    {
        $this->db->execute("SELECT R.product,
            R.items,
            SUM(R.items) AS sold,
            P.description,
            P.name,
            P.image
        FROM `OrderRow`AS R
        LEFT OUTER JOIN Product AS P
        ON R.product = P.id
        GROUP BY product
        ORDER BY sold DESC
        LIMIT $limit;");

        $res = $this->db->fetchAll();

        return $res;
    }

    /**
     * Get recommended products
     * @param string $orderby  Which column to order by, default: 'name'
     * @param string $order  ASC or DESC, default: 'ASC'
     * @var array $res      The resultset
     * @return $res
     */
    public function getRecommended()
    {
        $this->db->execute("SELECT
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
            WHERE recommended = 1
        GROUP BY P.id
        ORDER BY P.name
        ;");

        $res = $this->db->fetchAll();

        return $res;
    }
}
