<?php
/**
 * Converts a given DateTime based on a Format-String
 *
 * @author Sebastian Schmid
 * @file
 * @group  GesinnIT
 *
 * Date: 27.06.2017
 */

namespace DTP2;

use DateTime, User, DateTimeZone, DTP2\DateTimePickerUtils, SMW\DataValues\Time\LocalTime;

class DateConverter {

	private $mDateTime = '';
	private $mDateTimeFormat = 'Y-m-d ';
	private $mcurValue;
	private $mincludeSecond;
	private $mincludeTimezone;
	private $mhourTime24;
	private $muserOffset;

	/*
	 * @param string $curValue DateTimeString
	 * @param boolean $includeSecond
	 * @param boolean $includeTimezone
	 * @param boolean $hourTime24 switch between 12h and 24h
	 */

	public function __construct( $curValue, $includeSecond, $includeTimezone, $hourTime24, $userOffset ) {

		if ( ! empty( $curValue ) ) {
			$this->mcurValue = $curValue;
			$this->mincludeSecond = $includeSecond;
			$this->mincludeTimezone = $includeTimezone;
			$this->mhourTime24 = $hourTime24;
			$this->muserOffset = $userOffset;
			$this->setDateTimeFormat();
			$this->setDateTime();
		}
	}


	/*
	 * Return TimeFormat 'e.g. H:i O' based on field definition
	 *
	 * @code
	 * {{{field | Start Date | input type = datetimepicker2 | include timezone = true | hour time24 = false | ... }}}
	 * @endcode
	 *
	 * @since 1.27
	 *
	 * @return string e.g. "H:i:s a O"
	 */
	private function setDateTimeFormat() {

		if ( $this->mhourTime24 ) {
			// 24 hours
			$this->mDateTimeFormat .= "H:i";
			$this->mDateTimeFormat .= ( $this->mincludeSecond ) ? ':s' : '';
			$this->mDateTimeFormat .= ( $this->mincludeTimezone ) ? " O" : "";
		} else {
			// 12 Hours
			$this->mDateTimeFormat .= "h:i";
			$this->mDateTimeFormat .= ( $this->mincludeSecond ) ? ':s' : '';
			$this->mDateTimeFormat .= " a";
			$this->mDateTimeFormat .= ( $this->mincludeTimezone ) ? " O" : "";
		}
	}


	/* This is the Main-Function of DateConverter
	 * Get a DateTimeString and reformate it based on the set DateTimeFormat
	 *
	 * @param string $curValue
	 * @param boolean $includeTimezone
	 * @param string $userOffset
	 *
	 */
	private function setDateTime() {

		$currDateTime = new DateTime( $this->mcurValue );

		$minDiff = null;
		if ( $this->mincludeTimezone == false ) {
			// If Timezone is set than take it as it is

			$userOffset = explode( "|", $this->muserOffset );

			if ( $userOffset[0] == "ZoneInfo" ) {
				$tz = $userOffset[2];
			} else {
				if ( $userOffset[0] == 'System' || $userOffset[0] == 'Offset' ) {
					$minDiff = intval( $userOffset[1] );
				} else {
					$userOffset = explode( ':', $this->muserOffset );
					if ( count( $userOffset ) == 2 ) {
						$userOffset[0] = intval( $userOffset[0] );
						$userOffset[1] = intval( $userOffset[1] );
						$minDiff = abs( $userOffset[0] ) * 60 + $userOffset[1];
						if ( $userOffset[0] < 0 ) {
							$minDiff = -$minDiff;
						}
					} else {
						$minDiff = intval( $userOffset[0] ) * 60;
					}
				}
				$tz = self::getFormatedUserOffset( $minDiff );
			}

			$currDateTime->setTimezone( new DateTimeZone( $tz ) );
		}

		$this->mDateTime = $currDateTime->format( $this->getDateTimeFormat() );
	}

	private function getDateTimeFormat() {
		return $this->mDateTimeFormat;
	}

	public function getDateTime() {
		return $this->mDateTime;
	}

	/*

	•DateTime Zone accept format such as "+0200" or "Europe/Paris"


	•@author Felix Ashu Aba


	•@Param string $userOffset in minutes


	•@return string $uoffs_result in format "+0200" or "+02:00"
	 */
	public static function getFormatedUserOffset( $userOffset ) {
		// if userOffset is -150, return string should be -02:30
		$uoffs_result = ( intval($userOffset ) > 0 ) ? "+"
			: ( ( $userOffset < 0 ) ? "-" : '' );
		// remove the sign
		$userOffset = abs( $userOffset );

		$uoffs_result .= ( floor( $userOffset / 60 ) < 10 ) ? "0" . floor(
				$userOffset / 60
			) : '0' . floor( $userOffset / 60 );

		$uoffs_result .= ':';

		$uoffs_result .= ( floor( $userOffset % 60 ) < 10 ) ? '0' . floor(
				$userOffset % 60
			) : floor( $userOffset % 60 );

		 var_dump ( $uoffs_result );

		return $uoffs_result;
	}
}