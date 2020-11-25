<?php
/**
 * File holding the PersonalTools class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2018, Stephan Gambke
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

use Skins\Chameleon\IdRegistry;
use User;

/**
 * The PersonalTools class.
 *
 * An unordered list of personal tools: <ul id="p-personal" >...
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */
class CustomLogin extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 * @throws \MWException
	 */
	public function getHtml() {

		$ret = $this->indent() . '<!-- personal tools -->' .
			   $this->indent() . '<div class="profile '. $this->getClassString() . '" data-dropdown-trigger >';

		$user = $this->getSkinTemplate()->getSkin()->getUser();

		// add acronym if logged in otherwise a general user icon
		if ($user->isLoggedIn()){
			if($user->mRealName){
				$initial = substr($user->mRealName, 0, 1 );
			} else {
				$initial = substr($user->mName, 0, 1 );
			}

			$ret .= '<span class="profile-initials">' . $initial . '</span>';
		} else {
			$ret .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 21">
						<g fill="currentColor" fill-rule="evenodd">
							<path d="M2.9715 20.6666H0v-1.5803h1.7937l1.4382-4.8212c.2371-.795.9818-1.3497 1.811-1.3497h8.1329c.829 0 1.5739.5547 1.811 1.3494l1.7805 5.94-1.5139.4536-1.7807-5.9406a.3119.3119 0 00-.297-.222H5.043a.3117.3117 0 00-.2967.2212l-1.7747 5.9496zM8.9776 11.4083c-3.091 0-5.6057-2.5148-5.6057-5.6057 0-.5997.0942-1.19.2802-1.7552l1.501.4946a4.0253 4.0253 0 00-.2009 1.2606c0 2.2197 1.8057 4.0254 4.0254 4.0254 2.2196 0 4.0253-1.8057 4.0253-4.0254 0-2.2196-1.8057-4.0255-4.0253-4.0255H4.8659V.1965h4.1117c3.0909 0 5.6057 2.515 5.6057 5.6061 0 3.091-2.5148 5.6057-5.6057 5.6057"></path>
						</g>
					</svg>';
		}

		$ret .= $this->indent( 1 ) . '<div class="te-dropdown-menu" >';

		$this->indent( 1 );

		if ($user->isLoggedIn()) {
			// add personal tools (links to user page, user talk, prefs, ...)
			foreach ( $this->getSkinTemplate()->getPersonalTools() as $key => $item ) {

				if($key === "userpage"){
					$userID = false;

					// Get link information to create user object
					if(count($item) > 0){
						if(isset($item['links']) && count($item['links']) === 1) {
							$link = $item['links'][0];
							if ( isset( $link['text'] ) ) {
								$userID = $link['text'];
							}
						}
					}

					if($userID){
						$user = User::newFromName($userID);

						// change link text from username to realname if is set
						//$item['links'][0]['text'] = ($user->getRealName()) ? $user->getRealName() : $user->getName();

						// Add User name as plain text
						$username = ($user->getRealName()) ? $user->getRealName() : $user->getName();
						$ret .= '<span class="profile-name">' . $username .'</span>';
					}
					//$ret .= $this->makeLink( $item );
				}

				if ( $key === "logout") {
					$ret .= $this->makeLink( $item );
				}
			}
		}

		// If is not logged in we will display a "Login" and "Sign up" link
		// This is nothing chameleon/mediawiki provides as a default so we have to
		// hardcode those 2 links here
		if(!$user->isLoggedIn()){
			$returnTo = "";

			if( $this->getSkin()->getTitle()->getPrefixedDBkey() ){
				$returnTo = '?returnto=' . $this->getSkin()->getTitle()->getPrefixedDBkey();
			}

			$ret .= '<a href="' . $_SERVER['SCRIPT_NAME'] . '/Special:UserLogin'. $returnTo .'"><span>Login</span></a>';
			$ret .= '<a href="' . $_SERVER['SCRIPT_NAME'] . '/Special:UserLogin"><span>Sign up</span></a>';
		}

		$ret .= $this->indent( -1 ) . '</div>' .
		        $this->indent( -1 ) . '</div>' . "\n";

		return $ret;
	}

	private function makeLink($item = []){
		$idRegistry = IdRegistry::getRegistry();

		$ret = "";
		if(count($item) > 0){
			if(isset($item['links']) && count($item['links']) === 1){
				$link = $item['links'][0];
				//$linkText = $idRegistry->element('span', [], $link['text']);
				$ret = $idRegistry->element( 'a', [ 'href' => $link['href'] ], $link['text']);
			}
		}

		return $ret;
	}
}
