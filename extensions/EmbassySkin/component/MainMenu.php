<?php


namespace Skins\Chameleon\Components;

class MainMenu extends Component {
	/**
	 * Builds the HTML code for this component
	 *
	 * @return string the HTML code
	 * @throws \MWException
	 */
	public function getHtml() {

		$ret = '';

		$sidebar = $this->getSkinTemplate()->getSidebar(
			[
				'search' => false,
				'toolbox' => false,
				'languages' => false,
			]
		);

		// create a dropdown for each sidebar box
		foreach ( $sidebar as $menuName => $menuDescription ) {
			// if navigation array holds a set of Menu Item (content)
			if($menuName === "navigation" && array_key_exists('content', $menuDescription)){
				foreach( $menuDescription['content'] as $item){
					$ret .= $this->getMenuItem( $item );
				}
			}
		}

		return $ret;
	}

	/**
	 * Create a single Menu Items
	 *
	 * @param string $menuName
	 * @param mixed[] $menuDescription
	 *
	 * @return string
	 * @throws \MWException
	 */
	protected function getMenuItem( $item ) {

		$ret = "<a href='" . $item[ 'href' ] . "' title='" . $item[ 'text' ] . "' id='" . $item['id'] . "'>" . $item['text'] . "</a>";

		return $ret;
	}
}