<?php
/**
 * Send purge requests for listed pages to squid
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @ingroup Maintenance
 */

require_once __DIR__ . '/Maintenance.php';

/**
 * Maintenance script that sends purge requests for pages.
 *
 * @ingroup Maintenance
 */
class PurgeList extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->addDescription( 'Purge list of pages' );
		$this->addOption( 'pages', 'list of pages you want to purge' );
		$this->setBatchSize( 100 );
	}

	public function execute() {
#		$this->output( $this->getOption('pages') );

		$this->doPurge();
		$this->output( "Done!\n" );
	}

	/**
	 * Purge URL coming from stdin
	 */
	private function doPurge() {
		$stdin = $this->getStdin();
		$urls = [];

		$pages = explode(',', $this->getOption('pages') );

		#while ( !feof( $stdin ) ) {
		foreach ( $pages as $page){
			#$page = trim( fgets( $stdin ) );

			 $this->output($page);			

			if ( preg_match( '%^https?://%', $page ) ) {
				$urls[] = $page;
			} elseif ( $page !== '' ) {
				$title = Title::newFromText( $page );
				if ( $title ) {
					$url = $title->getInternalURL();
					$this->output( "$url\n" );
					$urls[] = $url;
					$page = WikiPage::newFromID( $title->getArticleId() );
					$text = $page->getText( Revision::RAW );
					$page->doEdit( $text, " Null edit." );
					$page->doPurge();			
				}
			}
		}
		$this->output( "Purging " . count( $urls ) . " urls\n" );
		$this->sendPurgeRequest( $urls );
	}
	
	/**
	 * Helper to purge an array of $urls
	 * @param array $urls List of URLS to purge from squids
	 */
	private function sendPurgeRequest( $urls ) {
		$u = new CdnCacheUpdate( $urls );
		$u->doUpdate();
	}
}

$maintClass = "PurgeList";
require_once RUN_MAINTENANCE_IF_MAIN;
