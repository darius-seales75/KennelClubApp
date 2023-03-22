<?php
/**
 * List user listings
 */

$entity = elgg_extract('entity', $vars);

$vars['options'] = [
	'owner_guids' => (int) $entity->guid,
	'preload_owners' => false,
];

echo elgg_view('listing/listing/all', $vars);
