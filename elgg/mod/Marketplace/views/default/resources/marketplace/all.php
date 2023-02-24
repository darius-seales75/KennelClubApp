<?php

$lower = elgg_extract('lower', $vars);
$upper = elgg_extract('upper', $vars);

elgg_register_title_button('marketplace', 'add', 'object', 'marketplace');

elgg_push_collection_breadcrumbs('object', 'marketplace');

$title = elgg_echo('collection:object:marketplace:all');
if ($lower) {
	$title .= ': ' . elgg_echo('date:month:' . date('m', $lower), [date('Y', $lower)]);
}

$content = elgg_view('marketplace/listing/all', [
	'created_after' => $lower,
	'created_before' => $upper,
]);

echo elgg_view_page($title, [
	'content' => $content,
	'sidebar' => elgg_view('marketplace/sidebar', ['page' => 'all']),
	'filter_value' => 'all',
]);
