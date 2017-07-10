<?php

namespace Mag\Admin;

/**
 * Class for handling administration pages
 * @param $db string The name of the database
 * @param $app string The app object
 * @return void
 */
class Admin
{
    // private $db;
    // public $hello = "hello";
    public $db;
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
     *
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
     * Show all products
     * @param string $orderby  Which column to order by, default: 'name'
     * @param string $order  ASC or DESC, default: 'ASC'
     * @var array $res      The resultset
     * @return $res
     */
    public function showProducts($orderby = 'name', $order = 'ASC')
    {
        $this->db->execute("SELECT * FROM VProduct ORDER BY $orderby $order");
        $res = $this->db->fetchAll();
        //  executeFetchAll
        return $res;
    }

}
