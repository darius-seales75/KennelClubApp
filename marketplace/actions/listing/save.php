<?php
/**
 * Save listing entity
 *
 * Can be called by clicking save button or preview button. If preview button,
 * we automatically save as draft. The preview button is only available for
 * non-published drafts.
 *
 * Drafts are saved with the access set to private.
 */
 
$servername = "localhost";
$username = "User";
$password = "816014270";
$db2name = "pedigree";

// Create a new MySQLi object to connect to the database
$conn = mysqli_connect($servername, $username, $password, $db2name);

// start a new sticky form session in case of failure
elgg_make_sticky_form('listing');

// save or preview
$save = (bool) get_input('save');

// edit or create a new entity
$guid = (int) get_input('guid');

if ($guid) {
	$entity = get_entity($guid);
	if ($entity instanceof ElggListing && $entity->canEdit()) {
		$listing = $entity;
	} else {
		return elgg_error_response(elgg_echo('listing:error:listing_not_found'));
	}

	// save data for revisions once we save the new edit
	$revision_text = $listing->description;
	$new_post = (bool) $listing->new_post;
} else {
	$listing = new \ElggListing();
	$new_post = true;
}

// set the previous status for the hooks to update the time_created and river entries
$old_status = $listing->status;

// set defaults and required values.
$values = [
	'title' => '',
	'description' => '',
	'status' => 'draft',
	'access_id' => ACCESS_DEFAULT,
	'comments_on' => 'On',
	'breed' => '',
	'date_of_birth' => '',
	'sex' => '',
	'color' => '',
	'price' => '',
	'medical_history' => '',
	'tags' => '',
	'container_guid' => (int) get_input('container_guid'),
];

// fail if a required entity isn't set
$required = ['title', 'description'];

// load from POST and do sanity and access checking
foreach ($values as $name => $default) {
	if ($name === 'title') {
		$value = elgg_get_title_input();
	} else {
		$value = get_input($name, $default);
	}

	if (in_array($name, $required) && empty($value)) {
		return elgg_error_response(elgg_echo("listing:error:missing:{$name}"));
	}

	switch ($name) {
		case 'tags':
			$values[$name] = elgg_string_to_array((string) $value);
			break;

		case 'container_guid':
			// this can't be empty or saving the base entity fails
			if (!empty($value)) {
				$container = get_entity($value);
				if ($container && (!$new_post || $container->canWriteToContainer(0, 'object', 'listing'))) {
					$values[$name] = $value;
				} else {
					return elgg_error_response(elgg_echo('listing:error:cannot_write_to_container'));
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
	$listing->$name = $value;
}

// Prepare an INSERT query to insert the data into a table called dog
$query = "INSERT INTO dog (`Dog Name`, `Description`, `Breed`, `Date of Birth`, `Sex`, `Color`, `Price`, `Medical History`, `Owner`) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);

// Bind the values to the query parameters
$stmt->bind_param('sssssssss', $values['title'], $values['description'], $values['breed'], $values['date_of_birth'], $values['sex'], $values['color'], $values['price'], $values['medical_history'], $values['access_id']);

// Execute the query
$stmt->execute();

// Close the statement and connection
$stmt->close();
$conn->close();

if (!$listing->save()) {
	return elgg_error_response(elgg_echo('listing:error:cannot_save'));
}

// remove sticky form entries
elgg_clear_sticky_form('listing');

// remove autosave draft if exists
$listing->deleteAnnotations('listing_auto_save');

// no longer a brand new post.
$listing->deleteMetadata('new_post');

// if this was an edit, create a revision annotation
if (!$new_post && $revision_text) {
	$listing->annotate('listing_revision', $revision_text);
}

$status = $listing->status;

// add to river if changing status or published, regardless of new post
// because we remove it for drafts.
if (($new_post || $old_status == 'draft') && $status == 'published') {
	elgg_create_river_item([
		'view' => 'river/object/marketplace/create',
		'action_type' => 'create',
		'subject_guid' => $listing->owner_guid,
		'object_guid' => $listing->getGUID(),
	]);

	elgg_trigger_event('publish', 'object', $listing);

	// reset the creation time for posts that move from draft to published
	if ($guid) {
		$listing->time_created = time();
		$listing->save();
	}
} elseif ($old_status == 'published' && $status == 'draft') {
	elgg_delete_river([
		'object_guid' => $listing->guid,
		'action_type' => 'create',
		'limit' => false,
	]);
}

if ($listing->status == 'published' || !$save) {
	$forward_url = $listing->getURL();
} else {
	$forward_url = elgg_generate_url('edit:object:listing', [
		'guid' => $listing->guid,
	]);
}

return elgg_ok_response([
	'guid' => $listing->guid,
	'url' => $listing->getURL(),
], elgg_echo('listing:message:saved'), $forward_url);
