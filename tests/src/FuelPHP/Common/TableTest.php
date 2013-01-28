<?php

namespace FuelPHP\Common;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-01-25 at 17:46:44.
 */
class TableTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var Table
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new Table;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
		
	}
	
	/**
	 * @covers FuelPHP\Common\Table::getCurrentRow
	 * @covers FuelPHP\Common\Table::createRow
	 * @group common
	 */
	public function testGetCurrentRow()
	{
		$this->assertInstanceOf(
				'FuelPHP\Common\Table\Row',
				$this->object->getCurrentRow()
		);
	}
	
	/**
	 * @covers FuelPHP\Common\Table::getRows
	 * @group common
	 */
	public function testGetRowsEmpty()
	{
		$this->assertEquals(0, count($this->object->getRows()));
	}
	
	/**
	 * @covers FuelPHP\Common\Table::getRows
	 * @covers FuelPHP\Common\Table::addRow
	 * @covers FuelPHP\Common\Table::createRow
	 * @group common
	 */
	public function testAddRow()
	{
		$rowCount = 10;
		
		for ($i=0; $i < $rowCount; $i++)
		{
			$this->object->addRow();
		}
		
		$this->assertEquals($rowCount, count($this->object->getRows()));
	}
	
	/**
	 * @covers FuelPHP\Common\Table::addCell
	 * @covers FuelPHP\Common\Table::getCurrentRow
	 * @covers FuelPHP\Common\Table::createRow
	 * @covers FuelPHP\Common\Table::constructCell
	 * @group common
	 */
	public function testAddCellContent()
	{
		$this->object->addCell('This is some content');
		
		$this->assertEquals(
				1,
				count($this->object->getCurrentRow())
		);
	}
	
	/**
	 * @covers FuelPHP\Common\Table::addCell
	 * @covers FuelPHP\Common\Table::getCurrentRow
	 * @covers FuelPHP\Common\Table::createRow
	 * @group common
	 */
	public function testAddCell()
	{
		$this->object->addCell(new Table\Cell('This is some content'));
		
		$this->assertEquals(
				1,
				count($this->object->getCurrentRow())
		);
	}
	
	/**
	 * @covers FuelPHP\Common\Table::setAttributes
	 * @covers FuelPHP\Common\Table::getAttributes
	 * @group common
	 */
	public function testSetGetAttributes()
	{
		$attributes = array('class' => 'table', 'id' => 'test');
		
		$this->object->setAttributes($attributes);
		
		$this->assertEquals($attributes, $this->object->getAttributes());
	}
	
	/**
	 * @covers FuelPHP\Common\Table::setCurrentRowAttributes
	 * @covers FuelPHP\Common\Table::getCurrentRow
	 * @covers FuelPHP\Common\Table::createRow
	 * @group common
	 */
	public function testSetRowAttributes()
	{
		$attributes = array('name' => 'test', 'id' => 'foobar');
		$this->object->setCurrentRowAttributes($attributes);
		
		$this->assertEquals(
			$attributes,
			$this->object->getCurrentRow()->getAttributes()
		);
	}

}
