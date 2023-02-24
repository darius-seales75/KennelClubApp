<?php

$group_guid = elgg_extract('guid', $vars, elgg_extract('group_guid', $vars)); // group_guid for BC
$lower = elgg_extract('lower', $vars);
$upper = elgg_extract('upper', $vars);

elgg_entity_gatekeeper($group_guid, 'group');

elgg_group_tool_gatekeeper('marketplace', $group_guid);

$group = get_entity($group_guid);

elgg_register_title_button('marketplace', 'add', 'object', 'marketplace');

elgg_push_collection_breadcrumbs('object', 'marketplace', $group);

$title = elgg_echo('collection:object:marketplace:group');
if ($lower) {
	$title .= ': ' . elgg_echo('date:month:' . date('m', $lower), [date('Y', $lower)]);
}

$content = elgg_view('marketplace/listing/group', [
	'entity' => $group,
	'created_after' => $lower,
	'created_before' => $upper,
]);

echo elgg_view_page($title, [
	'content' => $content,
	'sidebar' => elgg_view('marketplace/sidebar', [
		'page' => 'group',
		'entity' => $group,
	]),
	'filter_id' => 'marketplace/group',
	'filter_value' => 'all',
]);
