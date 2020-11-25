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
 * SemanticCore Footer
 *
 * @author Simon Heimler
 * @since 1.0
 * @ingroup Skins
 */
class Footer extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 */
	public function getHtml() {

		global $wgEmbassySkinParseFooter, $wgScriptPath;

		$ret = '<div class="footer">';
		$ret .= '<div class="container">';
		$ret .= '<div class="row justify-content-center">';
		$ret .= '<div class="footer-content col col-lg-10">';

		// Header line with svg in its middle
		$ret .= '<div class="footer-head">
					<svg width="42" height="41" viewBox="0 0 42 41" xmlns="http://www.w3.org/2000/svg">
            			<path d="M41.6954 20.4999L21.1953 41 .6954 20.4999 41.6954 0z" fill="#D1E2E5"></path>
        			</svg>
        			<p>Your platform for research integrity and ethics</p>
        		</div>';

		// ARBITRARY FOOTER CONTENT
		// Get the wikitext of MediaWiki:Footer
		$title = \Title::newFromText( 'MediaWiki:Footer' );
		$page = \WikiPage::factory( $title );

		$ret .= '<div class="footer-columns row">';

		if ( $page->exists() ) {
			$MediaWikiFooterContent = $page->getContent()->serialize();
			if ( $wgEmbassySkinParseFooter ) {
				// with parsing
				$parser = new Parser();

				// Remove "mw-parser-out"
				$options = new ParserOptions();
				if( method_exists( $options, 'setOption' ) )
					$options->setOption('wrapclass', false);
				$MediaWikiFooterContent = $parser->parse( $MediaWikiFooterContent, $this->getSkin()->getTitle(), $options, true, true )->getText();

			}
			$ret .= $MediaWikiFooterContent;
		}

		// close "footer-columns row"
		$ret .= '</div>';

		// Close "footer-content col col-lg-10"
		$ret .= '</div>';

		// Close "row justify-content-center"
		$ret .= '</div>';

		// Close "container"
		$ret .= '</div>';

		$ret .= '<div class="footer-copyright">
					<img class="flag-eu" src="' . $wgScriptPath . '/extensions/EmbassySkin/resources/images/flag-eu.png">
					<p>The EnTIRE and VIRT2UE projects have received funding from the European Union’s Horizon 2020 research programme under grant agreements N 741782 and N 787580.</p> 
				</div>';

		// Close "footer
		$ret .= '</div>';

		return $ret;
	}
}