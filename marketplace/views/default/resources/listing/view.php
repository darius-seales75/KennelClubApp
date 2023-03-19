<?php

$guid = elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', 'listing');

$entity = get_entity($guid);

elgg_push_entity_breadcrumbs($entity, false);

$content = elgg_view_entity($entity, [
	'full_view' => true,
	'show_responses' => true,
]);

echo elgg_view_page($entity->getDisplayName(), [
	'content' => $content,
	'filter_id' => 'listing/view',
	'entity' => $entity,
	'sidebar' => elgg_view('object/listing/elements/sidebar', [
		'entity' => $entity,
	]),
], 'default', [
	'entity' => $entity,
]);
