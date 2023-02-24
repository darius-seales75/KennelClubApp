<?php
/**
 * Save marketplace listing entity
 *
 * Can be called by clicking save button or preview button. If preview button,
 * we automatically save as draft. The preview button is only available for
 * non-published drafts.
 *
 * Drafts are saved with the access set to private.
 */

// start a new sticky form session in case of failure
elgg_make_sticky_form('marketplace');

// save or preview
$save = (bool) get_input('save');

// edit or create a new entity
$guid = (int) get_input('guid');

if ($guid) {
	$entity = get_entity($guid);
	if ($entity instanceof Elggmarketplace && $entity->canEdit()) {
		$marketplace = $entity;
	} else {
		return elgg_error_response(elgg_echo('marketplace:error:listing_not_found'));
	}

	// save some data for revisions once we save the new edit
	$revision_text = $marketplace->description;
	$new_listing = (bool) $marketplace->new_listing;
} else {
	$marketplace = new \Elggmarketplace();
	$new_listing = true;
}

// set the previous status for the hooks to update the time_created and river entries
$old_status = $marketplace->status;

// set defaults and required values.
$values = [
	'dog_name' => null,
	'breed' => null,
	'date_of_birth' => null,
	'sex' => null,
	'color' => null,
	'cost' => null,
	'gallery' => null,
	'status' => 'draft',
	'access_id' => ACCESS_DEFAULT,
	'comments_on' => 'On',
	'tags' => '',
	'container_guid' => (int) get_input('container_guid'),
];

// fail if a required entity isn't set
$required = ['dog_name', 'breed'];

// load from listing and do sanity and access checking
foreach ($values as $name => $default) {
	if ($name === 'dog_name') {
		$value = elgg_get_dog_name_input();
	} else {
		$value = get_input($name, $default);
	}

	if (in_array($name, $required) && empty($value)) {
		return elgg_error_response(elgg_echo("marketplace:error:missing:{$name}"));
	}

	switch ($name) {
		case 'tags':
			$values[$name] = elgg_string_to_array((string) $value);
			break;

		case 'container_guid':
			// this can't be empty or saving the base entity fails
			if (!empty($value)) {
				$container = get_entity($value);
				if ($container && (!$new_listing || $container->canWriteToContainer(0, 'object', 'marketplace'))) {
					$values[$name] = $value;
				} else {
					return elgg_error_response(elgg_echo('marketplace:error:cannot_write_to_container'));
				}
			} else {
				unset($values[$name]);
			}
			break;

		default:
			$values[$name] = $value;
			break;
	}
}

// if preview, force status to be draft
if (!$save) {
	$values['status'] = 'draft';
}

// if draft, set access to private and cache the future access
if ($values['status'] == 'draft') {
	$values['future_access'] = $values['access_id'];
	$values['access_id'] = ACCESS_PRIVATE;
}

// assign values to the entity
foreach ($values as $name => $value) {
	$marketplace->$name = $value;
}

if (!$marketplace->save()) {
	return elgg_error_response(elgg_echo('marketplace:error:cannot_save'));
}

// remove sticky form entries
elgg_clear_sticky_form('marketplace');

// remove autosave draft if exists
$marketplace->deleteAnnotations('marketplace_auto_save');

// no longer a brand new listing.
$marketplace->deleteMetadata('new_listing');

// if this was an edit, create a revision annotation
if (!$new_listing && $revision_text) {
	$marketplace->annotate('marketplace_revision', $revision_text);
}

$status = $marketplace->status;

// add to river if changing status or published, regardless of new listing
// because we remove it for drafts.
if (($new_listing || $old_status == 'draft') && $status == 'published') {
	elgg_create_river_item([
		'view' => 'river/object/marketplace/create',
		'action_type' => 'create',
		'subject_guid' => $marketplace->owner_guid,
		'object_guid' => $marketplace->getGUID(),
	]);

	elgg_trigger_event('publish', 'object', $marketplace);

	// reset the creation time for listings that move from draft to published
	if ($guid) {
		$marketplace->time_created = time();
		$marketplace->save();
	}
} elseif ($old_status == 'published' && $status == 'draft') {
	elgg_delete_river([
		'object_guid' => $marketplace->guid,
		'action_type' => 'create',
		'limit' => false,
	]);
}

if ($marketplace->status == 'published' || !$save) {
	$forward_url = $marketplace->getURL();
} else {
	$forward_url = elgg_generate_url('edit:object:marketplace', [
		'guid' => $marketplace->guid,
	]);
}

return elgg_ok_response([
	'guid' => $marketplace->guid,
	'url' => $marketplace->getURL(),
], elgg_echo('marketplace:message:saved'), $forward_url);
