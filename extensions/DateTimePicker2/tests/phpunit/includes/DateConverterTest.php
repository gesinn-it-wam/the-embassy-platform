<?php

namespace DTP2\Tests;

use DTP2\DateConverter;

/**
 * @covers \DTP2\DateConverter
 * Created by PhpStorm.
 * User: Felix
 * Date: 27.06.2017
 * Time: 14:38
 */
class DateConverterTest extends \PHPUnit_Framework_TestCase {

	/*************************************************************************************
	 * Testing Constructor
	 */
	public function testConstruct() {
		$constructor = new DateConverter(
			"", false, true, true, "ZoneInfo|120|Europe/Berlin"
		);
		$this->assertInstanceOf( '\DTP2\DateConverter', $constructor );
		$this->assertEquals( "", $constructor->getDateTime() );
	}

	/*************************************************************************************
	 * Testing setDateTimeFormat
	 * setDateTimeFormat( $includeTimezone, $hourTime24, $includeSecond ) includeTimeZone True
	 */
	public function testSetDateTimeFormat_includeSecondTrue_includeTimezoneTrue_hourTime24True_userOffsetNull_inputHH(
	) {

		$expected_result = "2017-08-02 14:30:30 +0200";

		$dc = new DateConverter(
			"2017-08-02 14:30:30+0200", true, true, true, null
		);

		$this->assertEquals( $expected_result, $dc->getDateTime() );
	}

	public function testSetDateTimeFormat_includeSecondFalse_includeTimezoneTrue_hourTime24True_userOffsetNull_inputHH(
	) {

		$expected_result = "2017-08-02 14:30 +0200";

		$dc = new DateConverter(
			"2017-08-02 14:30:30+0200", false, true, true, null
		);

		$this->assertEquals( $expected_result, $dc->getDateTime() );
	}

	public function testSetDateTimeFormat_includeSecondFalse_includeTimezoneTrue_hourTime24False_userOffsetNull_inputHH(
	) {

		$expected_result = "2017-08-02 02:30 pm +0200";

		$dc = new DateConverter(
			"2017-08-02 14:30:30+0200", false, true, false, null
		);

		$this->assertEquals( $expected_result, $dc->getDateTime() );
	}

	public function testSetDateTimeFormat_includeSecondTrue_includeTimezoneTrue_hourTime24False_userOffsetNull_inputHH(
	) {

		$expected_result = "2017-08-02 02:30:30 pm +0200";

		$dc = new DateConverter(
			"2017-08-02 14:30:30+0200", true, true, false, null
		);

		$this->assertEquals( $expected_result, $dc->getDateTime() );
	}

	public function testSetDateTimeFormat_includeSecondTrue_includeTimezoneTrue_hourTime24True_userOffsetNull_inputAmPm(
	) {

		$expected_result = "2017-08-02 14:30:30 +0200";

		$dc = new DateConverter(
			"2017-08-02 02:30:30 pm +0200", true, true, true, null
		);

		$this->assertEquals( $expected_result, $dc->getDateTime() );
	}

	public function testSetDateTimeFormat_includeSecondFalse_includeTimezoneTrue_hourTime24True_userOffsetNull_inputAmPm(
	) {

		$expected_result = "2017-08-02 14:30 +0200";

		$dc = new DateConverter(
			"2017-08-02 02:30 pm +0200", false, true, true, null
		);

		$this->assertEquals( $expected_result, $dc->getDateTime() );
	}

	public function testSetDateTimeFormat_includeSecondFalse_includeTimezoneTrue_hourTime24False_userOffsetNull_inputAmPm(
	) {

		$expected_result = "2017-08-02 02:30 pm +0200";

		$dc = new DateConverter(
			"2017-08-02 02:30 pm +0200", false, true, false, null
		);

		$this->assertEquals( $expected_result, $dc->getDateTime() );
	}

	public function testSetDateTimeFormat_includeSecondTrue_includeTimezoneTrue_hourTime24False_userOffsetNull_inputAmPm(
	) {

		$expected_result = "2017-08-02 02:30:30 pm +0200";

		$dc = new DateConverter(
			"2017-08-02 02:30:30 pm +0200", true, true, false, null
		);

		$this->assertEquals( $expected_result, $dc->getDateTime() );
	}


	/*************************************************************************************
	 * Testing setDateTimeFormat
	 * setDateTimeFormat( $includeTimezone, $hourTime24, $includeSecond, $userOffset ="ZoneInfo|120|Europe/Berlin" ) includeTimeZone False
	 */
	public function testSetDateTimeFormat_includeSecondTrue_includeTimezoneFalse_hourTime24True_userOffsetZoneInfo_inputHH(
	) {

		$expected_result = "2017-08-02 12:30:30";
		$userOffset = "ZoneInfo|120|Europe/Berlin";

		$dc = new DateConverter(
			"2017-08-02 14:30:30 +0400", true, false, true, $userOffset
		);

		$this->assertEquals( $expected_result, $dc->getDateTime() );
	}

	public function testSetDateTimeFormat_includeSecondFalse_includeTimezoneFalse_hourTime24True_userOffsetZoneInfo_inputHH(
	) {

		$expected_result = "2017-08-02 20:30";
		$userOffset = "ZoneInfo|120|Europe/Berlin";

		$dc = new DateConverter(
			"2017-08-02 14:30:30 -0400", false, false, true, $userOffset
		);

		$this->assertEquals( $expected_result, $dc->getDateTime() );
	}

	public function testSetDateTimeFormat_includeSecondFalse_includeTimezoneFalse_hourTime24False_userOffsetZoneInfo_inputHH(
	) {

		$expected_result = "2017-08-02 08:30 pm";
		$userOffset = "ZoneInfo|120|Europe/Berlin";

		$dc = new DateConverter(
			"2017-08-02 14:30:30 -0400", false, false, false, $userOffset
		);

		$this->assertEquals( $expected_result, $dc->getDateTime() );
	}

	public function testSetDateTimeFormat_includeSecondTrue_includeTimezoneFalse_hourTime24False_userOffsetZoneInfo_inputHH(
	) {

		$expected_result = "2017-08-02 08:30:30 pm";
		$userOffset = "ZoneInfo|120|Europe/Berlin";

		$dc = new DateConverter(
			"2017-08-02 14:30:30 -0400", true, false, false, $userOffset
		);

		$this->assertEquals( $expected_result, $dc->getDateTime() );
	}

	/***********************************************************************************************************************************************/
	public function testSetDateTimeFormat_includeSecondTrue_includeTimezoneFalse_hourTime24True_userOffsetZoneInfo_inputAmPm(
	) {

		$expected_result = "2017-08-02 00:30:30";
		$userOffset = "ZoneInfo|120|Europe/Berlin";

		$dc = new DateConverter(
			"2017-08-02 02:30:30 am +0400", true, false, true, $userOffset
		);

		$this->assertEquals( $expected_result, $dc->getDateTime() );
	}

	public function testSetDateTimeFormat_includeSecondFalse_includeTimezoneFalse_hourTime24True_userOffsetZoneInfo_inputAmPm(
	) {

		$expected_result = "2017-08-02 20:30";
		$userOffset = "ZoneInfo|120|Europe/Berlin";

		$dc = new DateConverter(
			"2017-08-02 02:30:30 pm -0400", false, false, true, $userOffset
		);

		$this->assertEquals( $expected_result, $dc->getDateTime() );
	}

	public function testSetDateTimeFormat_includeSecondFalse_includeTimezoneFalse_hourTime24False_userOffsetZoneInfo_inputAmPm(
	) {

		$expected_result = "2017-08-02 08:30 pm";
		$userOffset = "ZoneInfo|120|Europe/Berlin";

		$dc = new DateConverter(
			"2017-08-02 02:30:30 pm -0400", false, false, false, $userOffset
		);

		$this->assertEquals( $expected_result, $dc->getDateTime() );
	}

	public function testSetDateTimeFormat_includeSecondTrue_includeTimezoneFalse_hourTime24False_userOffsetZoneInfo_inputAmPm(
	) {

		$expected_result = "2017-08-02 08:30:30 pm";
		$userOffset = "ZoneInfo|120|Europe/Berlin";

		$dc = new DateConverter(
			"2017-08-02 02:30:30 pm -0400", true, false, false, $userOffset
		);

		$this->assertEquals( $expected_result, $dc->getDateTime() );
	}


	/*************************************************************************************
	 * Testing setDateTimeFormat
	 * setDateTimeFormat( $includeTimezone, $hourTime24, $includeSecond $userOffset = "Offset|120") includeTimeZone False
	 */
	public function testSetDateTimeFormat_includeSecondTrue_includeTimezoneFalse_hourTime24True_userOffsetOffset_inputHH(
	) {

		$expected_result = "2017-08-02 12:30:30";
		$userOffset = "Offset|120";

		$dc = new DateConverter(
			"2017-08-02 14:30:30 +0400", true, false, true, $userOffset
		);

		$this->assertEquals( $expected_result, $dc->getDateTime() );
	}

	public function testSetDateTimeFormat_includeSecondFalse_includeTimezoneFalse_hourTime24True_userOffsetOffset_inputHH(
	) {

		$expected_result = "2017-08-02 20:30";
		$userOffset = "Offset|120";

		$dc = new DateConverter(
			"2017-08-02 14:30:30 -0400", false, false, true, $userOffset
		);

		$this->assertEquals( $expected_result, $dc->getDateTime() );
	}

	public function testSetDateTimeFormat_includeSecondFalse_includeTimezoneFalse_hourTime24False_userOffsetOffset_inputHH(
	) {

		$expected_result = "2017-08-02 08:30 pm";
		$userOffset = "Offset|120";

		$dc = new DateConverter(
			"2017-08-02 14:30:30 -0400", false, false, false, $userOffset
		);

		$this->assertEquals( $expected_result, $dc->getDateTime() );
	}

	public function testSetDateTimeFormat_includeSecondTrue_includeTimezoneFalse_hourTime24False_userOffsetOffset_inputHH(
	) {

		$expected_result = "2017-08-02 08:30:30 pm";
		$userOffset = "Offset|120";

		$dc = new DateConverter(
			"2017-08-02 14:30:30 -0400", true, false, false, $userOffset
		);

		$this->assertEquals( $expected_result, $dc->getDateTime() );
	}

	public function testSetDateTimeFormat_includeSecondTrue_includeTimezoneFalse_hourTime24True_userOffsetOffset_inputAmPm(
	) {

		$expected_result = "2017-08-02 00:30:30";
		$userOffset = "Offset|120";

		$dc = new DateConverter(
			"2017-08-02 02:30:30 am +0400", true, false, true, $userOffset
		);

		$this->assertEquals( $expected_result, $dc->getDateTime() );
	}

	public function testSetDateTimeFormat_includeSecondFalse_includeTimezoneFalse_hourTime24True_userOffsetOffset_inputAmPm(
	) {

		$expected_result = "2017-08-02 20:30";
		$userOffset = "Offset|120";

		$dc = new DateConverter(
			"2017-08-02 02:30:30 pm -0400", false, false, true, $userOffset
		);

		$this->assertEquals( $expected_result, $dc->getDateTime() );
	}

	public function testSetDateTimeFormat_includeSecondFalse_includeTimezoneFalse_hourTime24False_userOffsetOffset_inputAmPm(
	) {

		$expected_result = "2017-08-02 08:30 pm";
		$userOffset = "Offset|120";

		$dc = new DateConverter(
			"2017-08-02 02:30:30 pm -0400", false, false, false, $userOffset
		);

		$this->assertEquals( $expected_result, $dc->getDateTime() );
	}

	public function testSetDateTimeFormat_includeSecondTrue_includeTimezoneFalse_hourTime24False_userOffsetOffset_inputAmPm(
	) {

		$expected_result = "2017-08-02 08:30:30 pm";
		$userOffset = "Offset|120";

		$dc = new DateConverter(
			"2017-08-02 02:30:30 pm -0400", true, false, false, $userOffset
		);

		$this->assertEquals( $expected_result, $dc->getDateTime() );
	}

	public function testGetFormatedUserOffse_returnNull() {

		$this->assertEquals("+00:30", DateConverter::getFormatedUserOffset( "+30" ) );
		$this->assertEquals("-02:30", DateConverter::getFormatedUserOffset( "-150" ) );

	}




}