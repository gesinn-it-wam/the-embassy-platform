<?php
/**
 * File holding the PersonalTools class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2015, Stephan Gambke
 * @license   GNU General Public License, version 3 (or any later version)
 *
 * The Chameleon skin is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by the Free
 * Software Foundation, either version 3 of the License, or (at your option) any
 * later version.
 *
 * The Chameleon skin is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @file
 * @ingroup   Skins
 */

namespace Skins\Chameleon\Components;

use Linker;
use Parser;
use ParserOptions;
use Skins\Chameleon\Components\SemanticCoreIconBar;
use Skins\Chameleon\ChameleonTemplate;
use Skins\Chameleon\IdRegistry;

/**
 * Embassy Background
 *
 * @author Sebastian Schmid
 * @since 1.0
 * @ingroup Skins
 */
class Background extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 */
	public function getHtml() {
		global $wgEmbassySkinBackgroundSVG, $IP, $wgTitle, $wgExtraNamespaces;

		foreach ($wgEmbassySkinBackgroundSVG as $skinDefinition) {

			$pathToSVG = $IP . '/_custom/' . $skinDefinition['svg'];

			// Check if an svg is defiend
			if ( array_key_exists( 'svg', $skinDefinition ) ) {

				// check if file exists
				if ( file_exists( $pathToSVG ) ) {

					if(array_key_exists('page', $skinDefinition)){ //page rule
						// check if current page matches the array definition
						if(in_array($wgTitle->getFullText(), $skinDefinition['page'])){
							return "<div class='background-seperator'></div>".file_get_contents($pathToSVG);
						}
					}

					else if(array_key_exists('namespace', $skinDefinition)) { //namespace rule
						// check if current namespace matches the array definition
						if(in_array($wgTitle->getNamespace(),
							$skinDefinition['namespace'], true)){
							return "<div class='background-seperator'></div>".file_get_contents($pathToSVG);
						}
					}

					else if(array_key_exists('category', $skinDefinition)) { //category rule

						// get current NS id
						$nsID = $wgTitle->getNamespace(); //e.g. 5002

						//get NS Value based on the NS Key
						$nsValue = $wgExtraNamespaces[$nsID];

						// check if current cateory matches the array definition
						if(in_array($nsValue, $skinDefinition['category'])){
							return "<div class='background-seperator'></div>".file_get_contents
							($pathToSVG);
						}
					}
				}
			}
		}
		return "<div class='background-seperator'></div>";
	}
}