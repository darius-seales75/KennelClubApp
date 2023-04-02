<?php

namespace Elgg\Listing\Menus;

/**
 * Hook callbacks for menus
 *
 * @since 4.0
 * @internal
 */
class OwnerBlock {

	/**
	 * Register user item to menu
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:owner_block'
	 *
	 * @return void|\Elgg\Menu\MenuItems
	 */
	public static function registerUserItem(\Elgg\Hook $hook) {
		$entity = $hook->getEntityParam();
		if (!$entity instanceof \ElggUser) {
			return;
		}
		
		$return = $hook->getValue();
		
		$return[] = \ElggMenuItem::factory([
			'name' => 'listing',
			'text' => elgg_echo('collection:object:listing'),
			'href' => elgg_generate_url('collection:object:listing:owner', [
				'username' => $entity->username,
			]),
		]);
		
		return $return;
	}

	/**
	 * Register group item to menu
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:owner_block'
	 *
	 * @return void|\Elgg\Menu\MenuItems
	 */
	public static function registerGroupItem(\Elgg\Hook $hook) {
		$entity = $hook->getEntityParam();
		if (!$entity instanceof \ElggGroup) {
			return;
		}
		
		if (!$entity->isToolEnabled('listing')) {
			return;
		}
		
		$return = $hook->getValue();
	
		$return[] = \ElggMenuItem::factory([
			'name' => 'listing',
			'text' => elgg_echo('collection:object:listing:group'),
			'href' => elgg_generate_url('collection:object:listing:group', [
				'guid' => $entity->guid,
				'subpage' => 'all',
			]),
		]);
		
		return $return;
	}
}
