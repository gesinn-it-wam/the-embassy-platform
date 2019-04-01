<?php
/**
 * Set dependency on PF and register the new Input Type
 *
 * @author Sebastian Schmid
 * @file
 * @group GesinnIT
 */
namespace DTP2;

use DTP2\DateTimePicker2;

class Hooks {

	// PF need to be loaded first
	public static function onSetup() {
		if ( !defined( 'PF_VERSION' ) ) {
			die( '<b>Error:</b><a href="">DateTimePicker2</a> requires the <a href="https://www.mediawiki.org/wiki/Extension:PageForms">Page Forms</a> extension. Please install and activate this extension first.' );
		}

		// register new input type
		if ( isset( $GLOBALS['wgPageFormsFormPrinter'] ) ) {
			$GLOBALS['wgPageFormsFormPrinter']->registerInputType( '\DTP2\DateTimePicker2' );
		}

		return true;
	}

	/**
	 * @param array &$testModules
	 * @param ResourceLoader $resourceLoader
	 * @return bool
	 */
	public static function onResourceLoaderTestModules( &$testModules, &$resourceLoader ) {

		$testModules[ 'qunit' ][ 'ext.datetimepicker2.test' ] = array(
			'scripts' => array( 'res/js/datetimepicker2.js', 'tests/qunit/ext.datetimepicker2.test.js'  ),
			//'dependencies' => array( 'add if you need' ),
			'localBasePath' => __DIR__,
			'remoteExtPath' => 'DateTimePicker2',
		);
		return true;
	}
}