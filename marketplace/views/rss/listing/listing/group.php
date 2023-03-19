<?php
/**
 * List group listings
 *
 * Note: this view has a corresponding view in the default view type, changes should be reflected
 */

$entity = elgg_extract('entity', $vars);

$vars['options'] = [
	'container_guids' => (int) $entity->guid,
	'preload_containers' => false,
];

echo elgg_view('listing/listing/all', $vars);
