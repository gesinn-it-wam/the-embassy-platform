<?php
namespace DTP2\Tests;

use DTP2\DateTimePicker2;

/**
 * @covers \DTP2\DateTimePicker2
 * Created by PhpStorm.
 * User: Felix
 * Date: 09.06.2017
 * Time: 10:29
 */
class DateTimePicker2Test extends \PHPUnit_Framework_TestCase {

	private $datetimepicker2;

	protected function setUp() {
		parent::setUp();
		$other_args = [    "property" => "Start Date",
		                   "input type" => "datetimepicker2",
		                   "include timezone" => "false",
		                   "delimiter" => ";",
		                   "possible_values" => [],
		                   "value_labels" => null,
		                   "is_list" => null,
		                   "semantic_property" => "Start Date",
		                   "property_type" => "_dat" ];

		$this->datetimepicker2 = new DateTimePicker2(7, null, "Issue[Start Date]", false, $other_args);
	}

	protected function tearDown() {
		unset( $this->datetimepicker2 );
		parent::tearDown();
	}

	public function testConstruct() {
		$this->assertInstanceOf( 'DTP2\DateTimePicker2', $this->datetimepicker2 );
	}


	public function testGetHtmlText(){

		$expected_result = '<span class="inputSpan"><input name="Issue[Start Date]_DTP2" class="datetimepicker2" value="" type="text" id="input_DTP2_7" /><button type="button" id="btn_trigger_input_DTP2_7"   class="ui-datepicker-trigger" tabindex="7">
             <img src="/wiki01/extensions/PageForms/images/DatePickerButton.gif" alt="..." title="..."></button><input name="Issue[Start Date]" type="hidden" id="input_DTP2_7_hidden" /></span>';

		$this->assertEquals(
			$expected_result, $this->datetimepicker2->getHtmlText()
		);
	}

	public function testGetName(){

		$this->assertEquals(
			'datetimepicker2', $this->datetimepicker2->getName()
		);

	}

	public function testGetResourceModuleNames(){
		$this->assertEquals( array( 'ext.datetimepicker2'), $this->datetimepicker2->getResourceModuleNames() );

	}

	public function testGetParameters(){

		$this->assertArrayHasKey('property', $this->datetimepicker2->getParameters() );

		$this->assertArrayHasKey('default', $this->datetimepicker2->getParameters() );

		$this->assertArrayHasKey('mandatory', $this->datetimepicker2->getParameters() );

		$this->assertArrayHasKey('restricted', $this->datetimepicker2->getParameters() );

		$this->assertArrayHasKey('class', $this->datetimepicker2->getParameters() );

	}

}