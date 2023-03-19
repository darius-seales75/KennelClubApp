<?php
/**
 * Listing archives
 */

$content = elgg_view_menu('listing_archive', [
	'page' => elgg_extract('page', $vars),
	'entity' => elgg_extract('entity', $vars, elgg_get_page_owner_entity()),
	'class' => 'elgg-menu-page',
	'show_listing_archive' => elgg_extract('show_listing_archive', $vars),
	'listing_archive_options' => elgg_extract('listing_archive_options', $vars),
	'listing_archive_url' => elgg_extract('listing_archive_url', $vars),
]);

if (!$content) {
	return;
}

echo elgg_view_module('aside', elgg_echo('listing:archives'), $content);
