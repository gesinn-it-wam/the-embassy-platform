<?php

/**
 * Created by PhpStorm.
 * User: Sebastian
 * Date: 18.05.2017
 * Time: 11:02
 */
class TreeAndMenuHooks {


	// Register any render callbacks with the parser
	public static function onParserSetup( &$parser ) {

		// Add parser hooks
		$parser->setFunctionHook( 'tree', 'TAMExpand::expandTree' );
		$parser->setFunctionHook( 'menu', 'TAMExpand::expandMenu' );
	}

	public static function onBeforePageDisplay( OutputPage &$out, Skin &$skin ) {

		global  $wgExtensionAssetsPath, $wgAutoloadClasses, $IP;

		// This gets the remote path even if it's a symlink (MW1.25+)
		$path = $wgExtensionAssetsPath . str_replace( "$IP/extensions", '', dirname( $wgAutoloadClasses[__CLASS__] ) );
		$out->addJsConfigVars( 'fancytree_path', "$path/modules/fancytree/" );

		$out->addModules( 'ext.fancytree' );
		$out->addModules( 'ext.suckerfish' );

		return true;
	}

}