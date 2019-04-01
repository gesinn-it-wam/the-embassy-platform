<?php

/**
 * Displays a datetime picker form input, if declear as query string
 *
 * @authors Sebastian Schmid, Felix Ashu Aba
 * @file
 * @group GesinnIT
 */
namespace DTP2;

use PFFormInput, Xml;

class DateTimePicker2 extends PFFormInput {

	public $mDatetime;

	/**
	 * Constructor.
	 *
	 * @param String $input_number
	 *        The number of the input in the form.
	 * @param String $cur_value
	 *        The current value of the input field.
	 * @param String $input_name
	 *        The name of the input.
	 * @param String $disabled
	 *        Is this input disabled?
	 * @param Array $other_args
	 *        An associative array of other parameters that were present in the
	 *        input definition.
	 */

	// $curValue = '2017-07-27 20:00 +0200'

	public function __construct( $inputNumber, $curValue, $inputName, $disabled, $otherArgs ) {

		parent::__construct( $inputNumber, $curValue , $inputName, $disabled, $otherArgs );

		global $wgPageForms24HourTime;

		// Provides functions for the ext.datetimepicker2
		$utils = new DateTimePickerUtils( $inputNumber, $otherArgs, $GLOBALS['wgUser']->getOption( 'timecorrection' ) );
		$utils->addJsVars();
		$definedParams = $utils->getDefinedParams();

		//DateConverter converts ISO 8601 to the format which is set in the {{{field}}}-def
		$datetime = new DateConverter( $curValue, $definedParams['include_second'], $definedParams['include_timezone'], $wgPageForms24HourTime, $GLOBALS['wgUser']->getOption( 'timecorrection' ) );

		$this->mDatetime = $datetime->getDateTime();

	}

	public static function getName() {
		return 'datetimepicker2';
	}

	public static function getParameters() {
		$params = parent::getParameters();

		return $params;
	}

	public function getResourceModuleNames() {

		return array(
			'ext.datetimepicker2'
		);
	}
	/**
	 * Returns the HTML code to be included in the output page for this input.
	 *
	 * Ideally this HTML code should provide a basic functionality even if the
	 * browser is not JavaScript capable. I.e. even without JavaScript the user
	 * should be able to input values.
	 *
	 */
	public function getHtmlText() {
		 // attached mandatoryField class
		$class_fields =  array_key_exists( 'mandatory', $this->mOtherArgs ) ? 'datetimepicker2 mandatoryField' : 'datetimepicker2';
		// array of attributes to bind the datePicker
		$attribs = array(
			'name'  => $this->mInputName . '_DTP2',
			'class' => $class_fields,
			'value' => $this->mDatetime,
			'type'  => 'text',
			'id'    => 'input_DTP2_' . $this->mInputNumber
		);

		// array of hidden attributes to pass to the input field
		$attribs_hidden = array(
			//'name'  => $this->mInputName . '_alt',
			'name'  => $this->mInputName,
			'type'  => 'hidden',
			'id'    => 'input_DTP2_' . $this->mInputNumber . '_hidden',
		);

		$button_id = 'btn_trigger_input_DTP2_' . $this->mInputNumber;
		$button_class = 'ui-datepicker-trigger';
		$dtp2_alt_title = wfMessage( 'dtp2-show-picker')->parse();

		$html =
			'<span class="inputSpan' .( array_key_exists( 'mandatory', $this->mOtherArgs ) ? ' mandatoryFieldSpan' : '' ) . '">' .
			Xml::element( 'input', $attribs ) . '<button type="button" id="' . $button_id . '" class="' . $button_class . '" tabindex="' .
			$this->mInputNumber . '"> <img src="' . $GLOBALS["wgExtensionAssetsPath"] . '/DateTimePicker2/res/images/DatePickerButton.gif" 
			alt="' . $dtp2_alt_title . '" title="' . $dtp2_alt_title . '"></button>' . Xml::element( 'input', $attribs_hidden ) . '</span>';

		return $html;
	}

}