<?php

namespace Fuel\Common;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-01-25 at 17:46:44.
 */
class DateRangeTest extends \PHPUnit_Framework_TestCase
{
	public $instance;

	/**
	 * @covers Fuel\Common\DateRange::__construct
	 * @group Common
	 */
	public function setup()
	{
	}

	/**
	 * @covers Fuel\Common\DateRange::__construct
	 * @group Common
	 */
	public function testConstructor()
	{
		$start = '2012-07-01';
		$interval = 'P7D';
		$recurrences = 4;
		$period = new DateRange($start, $interval, $recurrences);

		$end = '2012-07-31';
		$period = new DateRange($start, $interval, $end);

		$end = time();
		$period = new DateRange($start, $interval, $end);

		$start = new \DateTime('2012-07-01');
		$interval = new \DateInterval('P7D');
		$recurrences = 4;
		$period = new DateRange($start, $interval, $recurrences);

		$end = new \DateTime('2012-07-31');
		$period = new DateRange($start, $interval, $end);

		$iso = 'R4/2012-07-01T00:00:00Z/P7D';
		$period = new DateRange($iso);

		// test for the results
		$expected = array('2012-07-01', '2012-07-08', '2012-07-15', '2012-07-22', '2012-07-29');
		foreach ($period as $key => $date)
		{
			$this->assertEquals($expected[$key], $date->format('Y-m-d'));
		}
	}

	/**
	 * @covers Fuel\Common\DateRange::offsetExists
	 * @covers Fuel\Common\DateRange::offsetGet
	 * @group Common
	 */
	public function testArrayAccess()
	{
		$iso = 'R4/2012-07-01T00:00:00Z/P7D';
		$period = new DateRange($iso);

		$this->assertEquals($period[0]->format('Y-m-d'), '2012-07-01');
		$this->assertEquals($period[4]->format('Y-m-d'), '2012-07-29');
		$this->assertTrue(isset($period[0]));
		$this->assertTrue(isset($period[4]));
		$this->assertFalse(isset($period[5]));
		$this->assertNull($period[5]);
	}

	/**
	 * @covers Fuel\Common\DateRange::offsetSet
	 * @expectedException  RuntimeException
	 * @group Common
	 */
	public function testArrayAccessSet()
	{
		$iso = 'R4/2012-07-01T00:00:00Z/P7D';
		$period = new DateRange($iso);

		$period[10] = 'this is an exception';
	}

	/**
	 * @covers Fuel\Common\DateRange::offsetUnset
	 * @expectedException  RuntimeException
	 * @group Common
	 */
	public function testArrayAccessUnset()
	{
		$iso = 'R4/2012-07-01T00:00:00Z/P7D';
		$period = new DateRange($iso);

		unset($period[10]);
	}
}
