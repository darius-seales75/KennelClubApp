<?php
/**
 * List user marketplaces
 *
 * Note: this view has a corresponding view in the default view type, changes should be reflected
 *
 * @uses $vars['entity'] User
 * @uses $vars['created_after']  Only show marketplaces created after a date
 * @uses $vars['created_before'] Only show marketplaces created before a date
 * @uess $vars['status'] Filter by status
 */

$entity = elgg_extract('entity', $vars);

$vars['options'] = [
	'owner_guids' => (int) $entity->guid,
	'preload_owners' => false,
];

echo elgg_view('marketplace/listing/all', $vars);
