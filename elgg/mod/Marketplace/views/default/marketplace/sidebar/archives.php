<?php
/**
 * marketplace archives
 */

$content = elgg_view_menu('marketplace_archive', [
	'page' => elgg_extract('page', $vars),
	'entity' => elgg_extract('entity', $vars, elgg_get_page_owner_entity()),
	'class' => 'elgg-menu-page',
	'show_marketplace_archive' => elgg_extract('show_marketplace_archive', $vars),
	'marketplace_archive_options' => elgg_extract('marketplace_archive_options', $vars),
	'marketplace_archive_url' => elgg_extract('marketplace_archive_url', $vars),
]);

if (!$content) {
	return;
}

echo elgg_view_module('aside', elgg_echo('marketplace:archives'), $content);
