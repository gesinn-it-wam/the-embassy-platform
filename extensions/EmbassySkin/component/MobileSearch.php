<?php

namespace Skins\Chameleon\Components;
use Skins\Chameleon\IdRegistry;

class MobileSearch extends Component {

	public function getHtml() {

		$idRegistry = IdRegistry::getRegistry();

		return $this->indent() . $idRegistry->element(
				'button',
				[ 'class' => 'search-trigger'],
				"<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 19 18\"><path fill=\"currentColor\" fill-rule=\"evenodd\" d=\"M15.3912 16.1264l-3.328-4.1323h.0002l-1.1031-1.37c-.9708 1.0635-2.365 1.7225-3.9045 1.7225a5.445 5.445 0 01-.577-.031c-1.4071-.1519-2.671-.8426-3.5588-1.945-.8876-1.1024-1.293-2.4844-1.1411-3.8916.2908-2.6975 2.552-4.7315 5.2597-4.7315.191 0 .3852.0107.5767.0315 2.905.313 5.0136 2.9314 4.7002 5.8364-.047.4364-.1507.853-.2945 1.249l1.4822 1.0062a7.0388 7.0388 0 00.55-2.0678c.417-3.8693-2.3813-7.3441-6.2503-7.7614a7.1198 7.1198 0 00-.7643-.0415C3.4858-.0001.4309 2.679.0413 6.2916c-.4174 3.869 2.381 7.3443 6.2502 7.7616.2568.0275.512.041.7643.041 1.342 0 2.612-.3835 3.6948-1.0543l3.839 4.7668.0002-.0004v.0004h4.2999v-1.6803h-3.4985z\"></path></svg>"
			);
	}
}