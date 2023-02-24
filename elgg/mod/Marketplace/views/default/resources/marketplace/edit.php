<?php

use Elgg\Exceptions\Http\EntityNotFoundException;

$guid = elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', 'marketplace', true);

$marketplace = get_entity($guid);

$vars['entity'] = $marketplace;

elgg_push_entity_breadcrumbs($marketplace);

$revision = elgg_extract('revision', $vars);

$title = elgg_echo('edit:object:marketplace');

if ($revision) {
	$revision = elgg_get_annotation_from_id((int) $revision);
	$vars['revision'] = $revision;
	$title .= ' ' . elgg_echo('marketplace:edit_revision_notice');

	if (!$revision || !($revision->entity_guid == $guid)) {
		throw new EntityNotFoundException(elgg_echo('marketplace:error:revision_not_found'));
	}
}

$body_vars = marketplace_prepare_form_vars($marketplace, $revision);

$form_vars = [
	'prevent_double_submit' => false, // action is using the submit buttons to determine type of submission, disabled buttons are not submitted
];

$content = elgg_view_form('marketplace/save', $form_vars, $body_vars);

$sidebar = elgg_view('marketplace/sidebar/revisions', $vars);

echo elgg_view_page($title, [
	'content' => $content,
	'sidebar' => $sidebar,
	'filter_id' => 'marketplace/edit',
]);
