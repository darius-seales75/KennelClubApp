<?php
/**
 * List friends' listings
 *
 * Note: this view has a corresponding view in the default rss type, changes should be reflected
 *
 * @uses $vars['entity'] User
 */

$entity = elgg_extract('entity', $vars);

$vars['options'] = [
	'relationship' => 'friend',
	'relationship_guid' => (int) $entity->guid,
	'relationship_join_on' => 'owner_guid',
];

echo elgg_view('listing/listing/all', $vars);
