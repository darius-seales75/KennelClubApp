<?php

namespace Elgg\Marketplace;

/**
 * @group Router
 * @group BlogRoutes
 */
class RouteResponseTest extends \Elgg\Plugins\RouteResponseTest {

	public function getSubtype() {
		return 'marketplace';
	}
	
	public function groupRoutesProtectedByToolOption() {
		return [
			[
				'route' => "collection:object:{$this->getSubtype()}:group",
				'tool' => 'marketplace',
			],
		];
	}
}