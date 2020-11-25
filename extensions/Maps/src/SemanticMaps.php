<?php

namespace Maps;

use Maps\SemanticMW\ResultPrinters\KmlPrinter;
use Maps\SemanticMW\ResultPrinters\MapPrinter;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SemanticMaps {

	private $mwGlobals;

	private function __construct( array &$mwGlobals ) {
		$this->mwGlobals =& $mwGlobals;
	}

	public static function newFromMediaWikiGlobals( array &$mwGlobals ) {
		return new self( $mwGlobals );
	}

	public function initExtension() {
		// Hook for initializing the Geographical Data types.
		$this->mwGlobals['wgHooks']['SMW::DataType::initTypes'][] = 'Maps\MediaWiki\SemanticMapsHooks::initGeoDataTypes';

		// Hook for defining the default query printer for queries that ask for geographical coordinates.
		$this->mwGlobals['wgHooks']['SMWResultFormat'][] = 'Maps\MediaWiki\SemanticMapsHooks::addGeoCoordsDefaultFormat';

		// Hook for adding a Semantic Maps links to the Admin Links extension.
		$this->mwGlobals['wgHooks']['AdminLinks'][] = 'Maps\MediaWiki\SemanticMapsHooks::addToAdminLinks';

		$this->registerGoogleMaps();
		$this->registerLeaflet();

		$this->mwGlobals['smwgResultFormats']['kml'] = KmlPrinter::class;

		$this->mwGlobals['smwgResultAliases'][$this->mwGlobals['egMapsDefaultService']][] = 'map';
		MapPrinter::registerDefaultService( $this->mwGlobals['egMapsDefaultService'] );

		// Internationalization
		$this->mwGlobals['wgMessagesDirs']['SemanticMaps'] = __DIR__ . '/i18n';
	}

	private function registerGoogleMaps() {
		// TODO: inject
		$services = MapsFactory::globalInstance()->getMappingServices();

		if ( $services->nameIsKnown( 'googlemaps3' ) ) {
			$googleMaps = $services->getService( 'googlemaps3' );

			MapPrinter::registerService( $googleMaps );

			$this->mwGlobals['smwgResultFormats'][$googleMaps->getName()] = MapPrinter::class;
			$this->mwGlobals['smwgResultAliases'][$googleMaps->getName()] = $googleMaps->getAliases();
		}
	}

	private function registerLeaflet() {
		// TODO: inject
		$services = MapsFactory::globalInstance()->getMappingServices();

		if ( $services->nameIsKnown( 'leaflet' ) ) {
			$leaflet = $services->getService( 'leaflet' );

			MapPrinter::registerService( $leaflet );

			$this->mwGlobals['smwgResultFormats'][$leaflet->getName()] = MapPrinter::class;
			$this->mwGlobals['smwgResultAliases'][$leaflet->getName()] = $leaflet->getAliases();
		}
	}

}
