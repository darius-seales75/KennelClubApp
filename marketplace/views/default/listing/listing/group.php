<?php
/**
 * List group listings
 */

$entity = elgg_extract('entity', $vars);

$vars['options'] = [
	'container_guids' => (int) $entity->guid,
	'preload_containers' => false,
];

echo elgg_view('listing/listing/all', $vars);
