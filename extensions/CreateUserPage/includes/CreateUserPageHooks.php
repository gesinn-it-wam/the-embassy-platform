<?php

class CreateUserPageHooks {

	/**
	 * Implements UserLoginComplete hook.
	 * See https://www.mediawiki.org/wiki/Manual:Hooks/UserLoginComplete
	 * Check for existence of user page if $wgCreateUserPage_OnLogin is true
	 *
	 * @param User &$user the user object that was create on login
	 * @param string &$inject_html any HTML to inject after the login success message
	 */
	public static function onUserLoginComplete( User &$user, &$inject_html ) {
		if ( $GLOBALS["wgCreateUserPage_OnLogin"] ) {
			self::checkForUserPage( $user );
		}
	}

	/**
	 * Implements OutputPageParserOutput hook.
	 * See https://www.mediawiki.org/wiki/Manual:Hooks/OutputPageParserOutput
	 * Check for existence of user page if $wgCreateUserPage_OnLogin is fale
	 *
	 * @param OutputPage &$out the OutputPage object to which wikitext is added
	 * @param ParserOutput $parseroutput a PaerserOutput object
	 */
	public static function onOutputPageParserOutput( OutputPage &$out, ParserOutput $parseroutput ) {
		if ( !$GLOBALS["wgCreateUserPage_OnLogin"] ) {
			self::checkForUserPage( $out->getUser() );
		}
	}

	private static function checkForUserPage( User $user ) {
		$title = Title::newFromText( 'User:' . $user->mName );
		//if ( !is_null( $title ) && !$title->exists() ) {
			$page = new WikiPage( $title );

			$pageContent = self::setTemplateAttributes($user);

			$pageContent = new WikitextContent( $pageContent );
			$page->doEditContent( $pageContent, 'create user page', EDIT_NEW );
		//}
	}

	private static function setTemplateAttributes( User $user ){
		$pageContent = $GLOBALS['wgCreateUserPage_PageContent'];

		if($GLOBALS['wgCreateUserPage_useRealName']){
			$userName = $user->getRealName();
		} else {
			$userName = $user->getName();
		}

		if( $GLOBALS['wgCreateUserPage_FirstNameRegex'] ){
			preg_match($GLOBALS['wgCreateUserPage_FirstNameRegex'], $userName, $match);
			// replace placeholders
			$pageContent = str_replace("{{{firstname}}}", $match[0], $pageContent);
		}

		if( $GLOBALS['wgCreateUserPage_FirstNameRegex'] ){
			preg_match($GLOBALS['wgCreateUserPage_LastNameRegex'], $userName, $match);
			$pageContent = str_replace("{{{lastname}}}", $match[0], $pageContent);
		}
		
		if(count($user->getEmail()) > 0){
			$pageContent = str_replace("{{{email}}}", $user->getEmail(), $pageContent);
		}

		return $pageContent;
	}
}
