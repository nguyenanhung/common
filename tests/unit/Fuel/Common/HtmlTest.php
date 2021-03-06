<?php

namespace Fuel\Common;

use Codeception\TestCase\Test;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-01-23 at 22:34:55.
 */
class HtmlTest extends Test
{

	/**
	 * @covers Fuel\Common\Html::tag
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
	 * @covers Fuel\Common\Html::tag
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
	 * @covers Fuel\Common\Html::tag
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
	 * @covers Fuel\Common\Html::arrayToAttributes
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
	 * @covers Fuel\Common\Html::arrayToAttributes
	 * @group Common
	 */
	public function testArrayToAttributesNoValue()
	{
		$this->assertEquals(
			'selected',
			Html::arrayToAttributes(array(
				'selected',
			))
		);
	}

	/**
	 * @covers Fuel\Common\Html::arrayToAttributes
	 * @group Common
	 */
	public function testArrayToAttributesSingle()
	{
		$this->assertEquals(
			'name="test"', Html::arrayToAttributes(array(
				'name' => 'test',
			))
		);
	}

	/**
	 * @covers Fuel\Common\Html::arrayToAttributes
	 * @group Common
	 */
	public function testArrayToAttributesMixed()
	{
		$this->assertEquals(
			'name="test" selected', Html::arrayToAttributes(array(
				'name' => 'test',
				'selected',
			))
		);
	}

	/**
	 * @covers Fuel\Common\Html::arrayToAttributes
	 * @group Common
	 */
	public function testArrayToAttributesEmpty()
	{
		$this->assertEquals(
			'', Html::arrayToAttributes(array())
		);
	}

	/**
	 * @covers Fuel\Common\Html::arrayToAttributes
	 * @group Common
	 */
	public function testTagWithAttributesThatNeedEncoding()
	{
		$this->assertEquals(
				'name="blue &amp; green"',
				Html::arrayToAttributes(array('name' => 'blue & green'))
		);
	}

}
