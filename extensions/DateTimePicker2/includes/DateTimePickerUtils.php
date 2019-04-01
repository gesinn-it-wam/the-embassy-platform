<?php
/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 28.06.2017
 * Time: 12:00
 */

namespace DTP2;

use Preferences, RequestContext, DateTimeZone, DateTime;

class DateTimePickerUtils {

	private $mOtherArgs = [];
	private $mInputNumber;
	private $mUserOffset;

	public function __construct( $mInputNumber, $otherArgs, $userOffset ) {
		// Set Values to Member
		$this->mOtherArgs = $otherArgs;
		$this->mInputNumber = $mInputNumber;
		$this->mUserOffset = $userOffset;
	}

	/*
	 * generates and returns a array of defaultParams
	 * if parameters are set in the field-definition,
	 * than it will overwrite it
	 *
	 * @return array $defaultParams
	 */
	public function getDefinedParams() {
		global $wgPageForms24HourTime;
		// Default Params
		$defaultParams = [
			'include_second'   => false,
			'include_timezone' => false,
			'step_minute'      => 15,
			'step_hour'        => 1
		];

		if ( is_array( $this->mOtherArgs ) ) {
			foreach ( $this->mOtherArgs as $param => $value ) {
				$param = str_replace( ' ', '_', trim( $param ) );
				if ( array_key_exists( $param, $defaultParams ) ) {
					$defaultParams[$param] = $this->castString( $value );
				}
			}
		}

		// Add TimeFormat to Array
		$defaultParams['time_format'] =
			$this->getFieldDefTimeFormat( $defaultParams['include_timezone'], $defaultParams['include_second'],
				$wgPageForms24HourTime );

		return $defaultParams;
	}


	/*
	 * Cast String To Boolean / Int
	 * @param string $string passing string to function
	 *
	 * @return boolean / int $boolean
	 */
	public function castString( $string ) {

		if ( is_numeric( $string ) ) {
			return intval( $string );
		} else {
			return ( $string == 'false' || $string == null ) ? false : true;
		}
	}


	/*
	 *  Configure javascript variables to be used in datetimepicker2.js script
	 */
	public function addJsVars() {
		global $wgOut;
		// Get Options of field def lice  "...| include date = true | ..."
		$definedParams = $this->getDefinedParams();

		$wgOut->addJsConfigVars( "input_DTP2_" . $this->mInputNumber, $definedParams );
		$wgOut->addJsConfigVars( "wgTimezones", $this->getTimezones() );
		$this->mUserOffset = explode( "|", $this->mUserOffset );
		$wgOut->addJsConfigVars( "wgUserOffset", $this->mUserOffset[1] );
	}


	/*
	 * Return a json Object with all possible Timezones
	 *
	 * @return object $tz
	 */
	public static function getTimezones() {

		$tz = [
			[ "value" => "-720", "label" => "UTC-12" ],
			[ "value" => "-660", "label" => "UTC-11" ],
			[ "value" => "-600", "label" => "UTC-10" ],
			[ "value" => "-540", "label" => "UTC-9" ],
			[ "value" => "-480", "label" => "UTC-8" ],
			[ "value" => "-420", "label" => "UTC-7" ],
			[ "value" => "-360", "label" => "UTC-6" ],
			[ "value" => "-300", "label" => "UTC-5" ],
			[ "value" => "-240", "label" => "UTC-4" ],
			[ "value" => "-180", "label" => "UTC-3" ],
			[ "value" => "-120", "label" => "UTC-2" ],
			[ "value" => "-60", "label" => "UTC-1" ],
			[ "value" => "0", "label" => "UTC±0" ],
			[ "value" => "60", "label" => "UTC+1" ],
			[ "value" => "120", "label" => "UTC+2" ],
			[ "value" => "180", "label" => "UTC+3" ],
			[ "value" => "240", "label" => "UTC+4" ],
			[ "value" => "300", "label" => "UTC+5" ],
			[ "value" => "360", "label" => "UTC+6" ],
			[ "value" => "420", "label" => "UTC+7" ],
			[ "value" => "480", "label" => "UTC+8" ],
			[ "value" => "540", "label" => "UTC+9" ],
			[ "value" => "600", "label" => "UTC+10" ],
			[ "value" => "660", "label" => "UTC+11" ],
			[ "value" => "720", "label" => "UTC+12" ],

		];

		$tzOptions = Preferences::getTimezoneOptions( new RequestContext() );

		foreach ( $tzOptions as $label ) {

			if ( is_array( $label ) ) {
				foreach ( $label as $label => $timezone ) {
					$timezone = explode( '|', $timezone );
					array_push( $tz, [ "value" => $timezone[1], "label" => $label ] );
				}
			}
		}

		return $tz;
	}

	/*
	* This function is almoust the same as DateConverter::setDateTimeFormat()
	* but it returns a different TimeFormat because the datetimepicker2-js work with this format
	*
	* @param boolean $includeTimezone
	* @param boolean $includeSecond
	* @param boolean $hourTime24
	*
	* @return string (e.g. HH:mm z)
	*/
	public function getFieldDefTimeFormat( $includeTimezone, $includeSecond, $hourTime24 ) {

		//Get Values of {{{field}}}-definition
		$includeSeconds = ( $includeSecond ) ? ':ss' : '';
		$dateTimeFomat = "";
		if ( $hourTime24 ) {
			// 24 hours
			$dateTimeFomat = "HH:mm";
			$dateTimeFomat .= $includeSeconds;
			$dateTimeFomat .= ( $includeTimezone ) ? " z" : "";
		} else {
			// 12 hours
			$dateTimeFomat = "hh:mm";
			$dateTimeFomat .= $includeSeconds;
			$dateTimeFomat .= ( $includeTimezone ) ? " tt z" : " tt";
		}

		return $dateTimeFomat;
	}


}