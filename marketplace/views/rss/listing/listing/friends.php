<?php
/**
 * List friends' listings

 */

$entity = elgg_extract('entity', $vars);

$vars['options'] = [
	'relationship' => 'friend',
	'relationship_guid' => (int) $entity->guid,
	'relationship_join_on' => 'owner_guid',
];

echo elgg_view('listing/listing/all', $vars);
