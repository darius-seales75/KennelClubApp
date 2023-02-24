<?php

use Elgg\Exceptions\Http\EntityPermissionsException;

$guid = elgg_extract('guid', $vars);
if (!$guid) {
	$guid = elgg_get_logged_in_user_guid();
}

elgg_entity_gatekeeper($guid);

$container = get_entity($guid);

if (!$container->canWriteToContainer(0, 'object', 'marketplace')) {
	throw new EntityPermissionsException();
}

elgg_push_collection_breadcrumbs('object', 'marketplace', $container);

$form_vars = [
	'prevent_double_submit' => false, // action is using the submit buttons to determine type of submission, disabled buttons are not submitted
];

$content = elgg_view_form('marketplace/save', $form_vars, marketplace_prepare_form_vars());

echo elgg_view_page(elgg_echo('add:object:marketplace'), [
	'content' => $content,
	'filter_id' => 'marketplace/edit',
]);
