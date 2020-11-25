<?php

namespace EmbassySkin;

use OutputPage, Skin, Bootstrap\BootstrapManager;

class Hooks {

	public static function initExtension() {
		global $wgScriptPath, $wgFavicon, $wgLogo;

		// Favicon
		$wgFavicon = $wgScriptPath . '/extensions/EmbassySkin/resources/images/favicon-16x16.png';

		// Logo
		if ( file_exists( __DIR__ . '/../../_custom/logo.png' ) ) {
			$wgLogo = $wgScriptPath . '/_custom/logo.png';
		} else {
			$wgLogo = $wgScriptPath . '/extensions/EmbassySkin/resources/images/the-embassy-logo.png';
		}

		// Load Stylesheets
		Util::loadStylesheets();

	}

	// Load Javascript Modules
	public static function EmbassySkinOnBeforePageDisplay( OutputPage &$out, Skin &$skin ) {
		global $egChameleonLayoutFile;
		// main.css will be loaded per default.
		// TODO: Load main.css as external chameleon styleheet ($egChameleonExternalStyleModules)

		// This external lib is needed for Rubens (momkai) Masonry layout
		$out->addScriptFile('https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js');
		$out->addModules( 'ext.EmbassySkin' );

		// Layout
		$egChameleonLayoutFile = Util::getLayout($out, $skin);

		return true;
	}
}