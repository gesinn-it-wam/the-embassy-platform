<?php
/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 28.06.2017
 * Time: 12:00
 */

namespace DTP2\Tests;

use DTP2\ DateTimePickerUtils;
use Preferences, RequestContext, DateTimeZone;

/**
 * @covers \DTP2\DateTimePickerUtils
 * Created by PhpStorm.
 * User: Felix
 * Date: 27.06.2017
 * Time: 14:38
 */

class DateTimePickerUtilsTest extends \PHPUnit_Framework_TestCase {

	protected function setUp() {
		parent::setUp();
		$userOffset ="Offset|-240";
		$other_args = [ "property"          => "Start Date",
		                "input type"        => "datetimepicker2",
		                'include_date'      => "false",
		                'include_second'    => "true",
		                "include timezone"  => "true",
		                'step_minute'      => 30,
		                'step_hour'        => 2,
		                "delimiter"         => ";",
		                "possible_values"   => [],
		                "value_labels"      => null,
		                "is_list"           => null,
		                "semantic_property" => "Start Date",
		                "property_type"     => "_dat" ];

		$this->datepickerutils = new DateTimePickerUtils( 7, $other_args, $userOffset );
	}

	protected function tearDown() {
		unset( $this->datepickerutils );
		parent::tearDown();
	}

	public function testConstruct() {
		$this->assertInstanceOf(
			'DTP2\DateTimePickerUtils', $this->datepickerutils
		);
	}

	public function testGetDefinedParams_wgPageForms24HourTimeFalse_includeTimezoneTrue_IncludeSeconds_True() {

		global $wgPageForms24HourTime;
		$wgPageForms24HourTime = false;
		$defaultParams = [ 	'include_date'     => true,
		                      'include_second'   => false,
		                      'include_timezone' => false,
		                      'step_minute'      => 15,
		                      'step_hour'        => 1
		];

		$resultParams = $this->datepickerutils->getDefinedParams();
		// Make Sure define Params exist and has no been change.
		$this->assertEquals( 0, count( array_diff_key( $defaultParams, $resultParams ) ) );

		// Test return values. check vaule supply by constructor
		$this->assertFalse($resultParams['include_date']);

		// Include Seconds is True
		$this->assertTrue($resultParams['include_second']);

		// Include TimeZone is True
		$this->assertTrue($resultParams['include_timezone']);

		$this->assertEquals($resultParams['step_minute'], 30);
		$this->assertEquals($resultParams['step_hour'], 2);

		$this->assertEquals($resultParams['time_format'], "hh:mm:ss tt z");

	}
	public function testGetDefinedParams_wgPageForms24HourTimeFalse_includeTimezoneTrue_IncludeSeconds_False() {

		global $wgPageForms24HourTime;
		$wgPageForms24HourTime = false;
		$userOffset ="Offset|-240";
		$other_args = [ "property"          => "Start Date",
		                "input type"        => "datetimepicker2",
		                'include_date'      => "false",
		                'include_second'    => "false",
		                "include timezone"  => "true",
		                'step_minute'      => 30,
		                'step_hour'        => 2,
		                "delimiter"         => ";",
		                "possible_values"   => [],
		                "value_labels"      => null,
		                "is_list"           => null,
		                "semantic_property" => "Start Date",
		                "property_type"     => "_dat" ];

		$this->dpu = new DateTimePickerUtils( 7, $other_args, $userOffset );
		$resultParams = $this->dpu->getDefinedParams();

		// Test return values. check vaule supply by constructor
		// Include Seconds is True
		$this->assertFalse($resultParams['include_second']);

		// Include TimeZone is True
		$this->assertTrue($resultParams['include_timezone']);


		$this->assertEquals($resultParams['time_format'], "hh:mm tt z");

	}
	public function testGetDefinedParams_wgPageForms24HourTimeFalse_includeTimezoneFalse_IncludeSeconds_False() {

		global $wgPageForms24HourTime;
		$wgPageForms24HourTime = false;
		$userOffset ="Offset|-240";
		$other_args = [ "property"          => "Start Date",
		                "input type"        => "datetimepicker2",
		                'include_date'      => "false",
		                'include_second'    => "false",
		                "include timezone"  => "false",
		                'step_minute'      => 30,
		                'step_hour'        => 2,
		                "delimiter"         => ";",
		                "possible_values"   => [],
		                "value_labels"      => null,
		                "is_list"           => null,
		                "semantic_property" => "Start Date",
		                "property_type"     => "_dat" ];

		$this->dpu = new DateTimePickerUtils( 7, $other_args, $userOffset );
		$resultParams = $this->dpu->getDefinedParams();

		// Test return values. check vaule supply by constructor
		// Include Seconds is True
		$this->assertFalse($resultParams['include_second']);

		// Include TimeZone is False
		$this->assertFalse($resultParams['include_timezone']);


		$this->assertEquals($resultParams['time_format'], "hh:mm tt");

	}

	public function testGetDefinedParams_wgPageForms24HourTimeFalse_includeTimezoneFalse_IncludeSeconds_True() {

		global $wgPageForms24HourTime;
		$wgPageForms24HourTime = false;
		$userOffset ="Offset|-240";
		$other_args = [ "property"          => "Start Date",
		                "input type"        => "datetimepicker2",
		                'include_date'      => "false",
		                'include_second'    => "true",
		                "include timezone"  => "false",
		                'step_minute'      => 30,
		                'step_hour'        => 2,
		                "delimiter"         => ";",
		                "possible_values"   => [],
		                "value_labels"      => null,
		                "is_list"           => null,
		                "semantic_property" => "Start Date",
		                "property_type"     => "_dat" ];

		$this->dpu = new DateTimePickerUtils( 7, $other_args, $userOffset );
		$resultParams = $this->dpu->getDefinedParams();

		// Test return values. check vaule supply by constructor
		// Include Seconds is True
		$this->assertTrue($resultParams['include_second']);

		// Include TimeZone is False
		$this->assertFalse($resultParams['include_timezone']);


		$this->assertEquals($resultParams['time_format'], "hh:mm:ss tt");

	}


	/***********************************************************************************************************************/
	public function testGetDefinedParams_wgPageForms24HourTimeTrue_includeTimezoneTrue_IncludeSeconds_True() {

		global $wgPageForms24HourTime;
		$wgPageForms24HourTime = true;

		$resultParams = $this->datepickerutils->getDefinedParams();
		// Include Seconds is True
		$this->assertTrue($resultParams['include_second']);

		// Include TimeZone is True
		$this->assertTrue($resultParams['include_timezone']);

		$this->assertEquals($resultParams['time_format'], "HH:mm:ss z");

	}
	public function testGetDefinedParams_wgPageForms24HourTimeTrue_includeTimezoneTrue_IncludeSeconds_False() {

		global $wgPageForms24HourTime;
		$wgPageForms24HourTime = true;
		$userOffset ="Offset|-240";
		$other_args = [ "property"          => "Start Date",
		                "input type"        => "datetimepicker2",
		                'include_date'      => "false",
		                'include_second'    => "false",
		                "include timezone"  => "true",
		                'step_minute'      => 30,
		                'step_hour'        => 2,
		                "delimiter"         => ";",
		                "possible_values"   => [],
		                "value_labels"      => null,
		                "is_list"           => null,
		                "semantic_property" => "Start Date",
		                "property_type"     => "_dat" ];

		$this->dpu = new DateTimePickerUtils( 7, $other_args, $userOffset );
		$resultParams = $this->dpu->getDefinedParams();

		// Test return values. check vaule supply by constructor
		// Include Seconds is True
		$this->assertFalse($resultParams['include_second']);

		// Include TimeZone is True
		$this->assertTrue($resultParams['include_timezone']);


		$this->assertEquals($resultParams['time_format'], "HH:mm z");

	}
	public function testGetDefinedParams_wgPageForms24HourTimeTrue_includeTimezoneFalse_IncludeSeconds_False() {

		global $wgPageForms24HourTime;
		$wgPageForms24HourTime = true;
		$userOffset ="Offset|-240";
		$other_args = [ "property"          => "Start Date",
		                "input type"        => "datetimepicker2",
		                'include_date'      => "false",
		                'include_second'    => "false",
		                "include timezone"  => "false",
		                'step_minute'      => 30,
		                'step_hour'        => 2,
		                "delimiter"         => ";",
		                "possible_values"   => [],
		                "value_labels"      => null,
		                "is_list"           => null,
		                "semantic_property" => "Start Date",
		                "property_type"     => "_dat" ];

		$this->dpu = new DateTimePickerUtils( 7, $other_args, $userOffset );
		$resultParams = $this->dpu->getDefinedParams();

		// Test return values. check vaule supply by constructor
		// Include Seconds is True
		$this->assertFalse($resultParams['include_second']);

		// Include TimeZone is False
		$this->assertFalse($resultParams['include_timezone']);


		$this->assertEquals($resultParams['time_format'], "HH:mm");

	}

	public function testGetDefinedParams_wgPageForms24HourTimeTrue_includeTimezoneFalse_IncludeSeconds_True() {

		global $wgPageForms24HourTime;
		$wgPageForms24HourTime = true;
		$userOffset ="Offset|-240";
		$other_args = [ "property"          => "Start Date",
		                "input type"        => "datetimepicker2",
		                'include_date'      => "false",
		                'include_second'    => "true",
		                "include timezone"  => "false",
		                'step_minute'      => 30,
		                'step_hour'        => 2,
		                "delimiter"         => ";",
		                "possible_values"   => [],
		                "value_labels"      => null,
		                "is_list"           => null,
		                "semantic_property" => "Start Date",
		                "property_type"     => "_dat" ];

		$this->dpu = new DateTimePickerUtils( 7, $other_args, $userOffset );
		$resultParams = $this->dpu->getDefinedParams();

		// Test return values. check vaule supply by constructor
		// Include Seconds is True
		$this->assertTrue($resultParams['include_second']);

		// Include TimeZone is False
		$this->assertFalse($resultParams['include_timezone']);


		$this->assertEquals($resultParams['time_format'], "HH:mm:ss");

	}


	public function testGetTimezones(){
		global $wgOut;

		$tzs = DateTimePickerUtils::getTimezones();

		$this->datepickerutils->addJsVars();

		$this->assertEquals( $wgOut->getJsConfigVars()['wgTimezones'] ,$tzs );

	}

	public function testAddJsVars() {
		global $wgOut;
		$this->datepickerutils->addJsVars();

		$this->assertTrue( $wgOut->getJsConfigVars()['input_DTP2_7']["include_timezone"] );

		$this->assertFalse( $wgOut->getJsConfigVars()['input_DTP2_7']["include_date"] );

		$this->assertTrue( $wgOut->getJsConfigVars()['input_DTP2_7']["include_second"] );
		$this->assertTrue( $wgOut->getJsConfigVars()['input_DTP2_7']["include_timezone"] );


		$this->assertEquals( -240, $wgOut->getJsConfigVars()['wgUserOffset'] );
	}


	public function testCastString_isNumeric(){

		$this->assertEquals( 20, $this->datepickerutils->castString( "20" ) );
	}

	public function testCastString_isBoolean(){

		$this->assertEquals( false, $this->datepickerutils->castString( "false" ) );
	}

}