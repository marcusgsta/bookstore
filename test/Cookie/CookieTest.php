<?php

namespace Mag\Cookie;

/**
 * Test cases for class Guess.
 */
class CookieTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test case to test method has()
     *
     */
    public function testHas()
    {
        $cookie = new Cookie();
        $this->assertEquals(isset($_COOKIE["keyOne"]), $cookie->has("keyOne"));
    }
}
