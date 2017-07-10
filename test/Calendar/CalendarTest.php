<?php

namespace Mag\Calendar;

/**
 * Test cases for class Calendar.
 */
class CalendarTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test case to test method testSetCurrentMonth()
     *
     */
    public function testSetCurrentMonth()
    {
        $calendar = new Calendar();
        $this->assertInstanceOf("Mag\Calendar\Calendar", $calendar);
        $this->assertEquals(date('n'), $calendar->setCurrentMonth());
    }

    /**
     * Test case to test method testSetWeekDay()
     *
     */
    public function testSetWeekDay()
    {
        $calendar = new Calendar();
        $monthNum = $calendar->setCurrentMonth();
        $this->assertEquals(
            date('w', mktime(0, 0, 0, $monthNum, 1, 2017)),
            $calendar->setWeekDay($monthNum)
        );
    }

    /**
     * Test case to test method testGetTitle()
     *
     */
    public function testGetTitle()
    {
        $calendar = new Calendar();
        $this->assertEquals(
            date('F Y'),
            $calendar->getTitle()
        );
    }

    /**
     * Test case to test method testSetTitle()
     *
     */
    public function testSetTitle()
    {
        $calendar = new Calendar();
        $monthNum = date('n');
        $monthName = date('F', mktime(0, 0, 0, $monthNum, 10));
        $title = $monthName . date(' Y');
        $this->assertEquals(
            $title,
            $calendar->setTitle($monthNum)
        );
    }
}
