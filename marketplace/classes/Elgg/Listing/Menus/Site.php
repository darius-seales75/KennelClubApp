<?php

namespace Elgg\Listing\Menus;

/**
 * Hook callbacks for menus
 *
 * @since 4.0
 * @internal
 */
class Site {

	/**
	 * Register item to menu
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:site'
	 *
	 * @return \Elgg\Menu\MenuItems
	 */
	public static function register(\Elgg\Hook $hook) {
		$return = $hook->getValue();
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'listing',
			'icon' => 'edit-regular',
			'text' => elgg_echo('collection:object:listing'),
			'href' => elgg_generate_url('default:object:listing'),
		]);
		
		return $return;
	}
}
