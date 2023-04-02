<?php

use Elgg\Exceptions\Http\EntityNotFoundException;

$guid = elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', 'listing', true);

$listing = get_entity($guid);

$vars['entity'] = $listing;

elgg_push_entity_breadcrumbs($listing);

$revision = elgg_extract('revision', $vars);

$title = elgg_echo('edit:object:listing');

if ($revision) {
	$revision = elgg_get_annotation_from_id((int) $revision);
	$vars['revision'] = $revision;
	$title .= ' ' . elgg_echo('listing:edit_revision_notice');

	if (!$revision || !($revision->entity_guid == $guid)) {
		throw new EntityNotFoundException(elgg_echo('listing:error:revision_not_found'));
	}
}

$body_vars = listing_prepare_form_vars($listing, $revision);

$form_vars = [
	'prevent_double_submit' => false, // action is using the submit buttons to determine type of submission, disabled buttons are not submitted
];

$content = elgg_view_form('listing/save', $form_vars, $body_vars);

$sidebar = elgg_view('listing/sidebar/revisions', $vars);

echo elgg_view_page($title, [
	'content' => $content,
	'sidebar' => $sidebar,
	'filter_id' => 'listing/edit',
]);
