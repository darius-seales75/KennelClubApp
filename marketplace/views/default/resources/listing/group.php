<?php

$group_guid = elgg_extract('guid', $vars, elgg_extract('group_guid', $vars)); // group_guid for BC
$lower = elgg_extract('lower', $vars);
$upper = elgg_extract('upper', $vars);

elgg_entity_gatekeeper($group_guid, 'group');

elgg_group_tool_gatekeeper('listing', $group_guid);

$group = get_entity($group_guid);

elgg_register_title_button('listing', 'add', 'object', 'listing');

elgg_push_collection_breadcrumbs('object', 'listing', $group);

$title = elgg_echo('collection:object:listing:group');
if ($lower) {
	$title .= ': ' . elgg_echo('date:month:' . date('m', $lower), [date('Y', $lower)]);
}

$content = elgg_view('listing/listing/group', [
	'entity' => $group,
	'created_after' => $lower,
	'created_before' => $upper,
]);

echo elgg_view_page($title, [
	'content' => $content,
	'sidebar' => elgg_view('listing/sidebar', [
		'page' => 'group',
		'entity' => $group,
	]),
	'filter_id' => 'listing/group',
	'filter_value' => 'all',
]);
