<?php

namespace FuelPHP\Common;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-01-23 at 22:34:55.
 */
class HtmlTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var Html
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
		
	}

	/**
	 * @covers FuelPHP\Common\Html::tag
	 * @group Common
	 */
	public function testTag()
	{
		$tag = Html::tag('div');
		
		$expected = array(
			'tag' => 'div',
		);
		
		$this->assertTag($expected, $tag);
	}
	
	/**
	 * @covers FuelPHP\Common\Html::tag
	 * @group Common
	 */
	public function testTagWithAttributes()
	{
		$attributes = array('name' => 'foobar');
		
		$tag = Html::tag('div', $attributes);
		
		$expected = array(
			'tag' => 'div',
			'attributes' => $attributes,
		);
		
		$this->assertTag($expected, $tag);
	}

	/**
	 * @covers FuelPHP\Common\Html::tag
	 * @group Common
	 */
	public function testTagWithAttributesAndContent()
	{
		$attributes = array('name' => 'foobar');
		$content = 'This is some content!';
		
		$tag = Html::tag('div', $attributes, $content);
		
		$expected = array(
			'tag' => 'div',
			'attributes' => $attributes,
			'content' => $content,
		);
		
		$this->assertTag($expected, $tag);
	}
	
	/**
	 * @covers FuelPHP\Common\Html::arrayToAttributes
	 * @group Common
	 */
	public function testArrayToAttributes()
	{
		$this->assertEquals(
				'name="test" foo="bar"',
				Html::arrayToAttributes(array(
					'name' => 'test',
					'foo' => 'bar',
				))
		);
	}

	/**
	 * @covers FuelPHP\Common\Html::arrayToAttributes
	 * @group Common
	 */
	public function testArrayToAttributesSingle()
	{
		$this->assertEquals(
				'name="test"',
				Html::arrayToAttributes(array(
					'name' => 'test',
				))
		);
	}
	
	/**
	 * @covers FuelPHP\Common\Html::arrayToAttributes
	 * @group Common
	 */
	public function testArrayToAttributesEmpty()
	{
		$this->assertEquals(
				'',
				Html::arrayToAttributes(array())
		);
	}
	
}
