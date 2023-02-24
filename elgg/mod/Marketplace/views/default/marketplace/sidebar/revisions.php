<?php
/**
 * marketplace sidebar menu showing revisions
 */

use Elgg\Database\Clauses\OrderByClause;

//If editing a post, show the previous revisions and drafts.
$marketplace = elgg_extract('entity', $vars, false);
if (!$marketplace instanceof Elggmarketplace) {
	return;
}

if (!$marketplace->canEdit()) {
	return;
}

$revisions = [];

$auto_save_annotations = $marketplace->getAnnotations([
	'annotation_name' => 'marketplace_auto_save',
	'limit' => 1,
]);
if ($auto_save_annotations) {
	$revisions[] = $auto_save_annotations[0];
}

$saved_revisions = $marketplace->getAnnotations([
	'annotation_name' => 'marketplace_revision',
	'order_by' => [
		new OrderByClause('n_table.time_created', 'DESC'),
		new OrderByClause('n_table.id', 'DESC'),
	],
	'limit' => false,
]);

$revisions = array_merge($revisions, $saved_revisions);
/* @var ElggAnnotation[] $revisions */

if (empty($revisions)) {
	return;
}

$load_base_url = elgg_generate_url('edit:object:marketplace', [
	'guid' => $marketplace->guid,
]);

// show the "published revision"
$published_item = '';
if ($marketplace->status == 'published') {
	$load = elgg_view_url($load_base_url, elgg_echo('status:published'));
	$time = elgg_format_element('span', ['class' => 'elgg-subtext'], elgg_view_friendly_time($marketplace->time_created));

	$published_item = elgg_format_element('li', [], "$load: $time");
}

$n = count($revisions);
$revisions_list = '';
foreach ($revisions as $revision) {
	$time = elgg_format_element('span', ['class' => 'elgg-subtext'], elgg_view_friendly_time($revision->time_created));

	if ($revision->name == 'marketplace_auto_save') {
		$revision_lang = elgg_echo('marketplace:auto_saved_revision');
	} else {
		$revision_lang = elgg_echo('marketplace:revision') . " $n";
	}
	
	$load = elgg_view_url("{$load_base_url}/{$revision->id}", $revision_lang);

	$revisions_list .= elgg_format_element('li', ['class' => 'auto-saved'], "$load: $time");
	
	$n--;
}

$body = elgg_format_element('ul', ['class' => 'marketplace-revisions'], $published_item . $revisions_list);

echo elgg_view_module('aside', elgg_echo('marketplace:revisions'), $body);
