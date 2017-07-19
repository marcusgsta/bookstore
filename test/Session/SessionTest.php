<?php

namespace Mag\Session;

/**
 * Test cases for class Session.
 */
class SessionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test case to test method has()
     *
     */
    public function testHas()
    {
        $session = new Session();
        $_SESSION["keyOne"] = 1;
        $this->assertEquals(isset($_SESSION["keyOne"]), $session->has("keyOne"));
    }

    /**
     * Test case to test method dump()
     *
     */
    public function testDump()
    {
        $session = new Session();
        $_SESSION['keyOne'] = 1;
        $this->assertEquals(var_dump($_SESSION), $session->dump());
    }
}
