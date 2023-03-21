<?php
/**
 * Translation file
 *
 * Note: don't change the return array to short notation because Transifex can't handle those during `tx push -s`
 */

return array(
	'item:object:listing' => 'Listing',
	'collection:object:listing' => 'Marketplace',
	'collection:object:listing:all' => 'All site listings',
	'collection:object:listing:owner' => '%s\'s listings',
	'collection:object:listing:group' => 'Group listings',
	'collection:object:listing:friends' => 'Friends\' listings',
	'add:object:listing' => 'Add marketplace listing',
	'edit:object:listing' => 'Edit listing',
	'notification:object:listing:publish' => "Send a notification when a listing is published",
	'notifications:mute:object:listing' => "about the listing '%s'",

	'listing:revisions' => 'Revisions',
	'listing:archives' => 'Archives',

	'groups:tool:listing' => 'Enable group listing',
	'groups:tool:listing:description' => 'Allow group members to write listings in this group.',

	// Editing
	'listing:breed' => 'breed',
	'listing:date_of_birth' => 'date_of_birth',
	'listing:sex' => 'sex',
	'listing:color' => 'color',
	'listing:cost' => 'cost',
	'listing:medical_history' => 'medical_history',
	'listing:save_status' => 'Last saved: ',

	'listing:revision' => 'Revision',
	'listing:auto_saved_revision' => 'Auto Saved Revision',

	// messages
	'listing:message:saved' => 'marketplace listing saved.',
	'listing:error:cannot_save' => 'Cannot save marketplace listing.',
	'listing:error:cannot_auto_save' => 'Cannot automatically save marketplace listing.',
	'listing:error:cannot_write_to_container' => 'Insufficient access to save marketplace to group.',
	'listing:messages:warning:draft' => 'There is an unsaved draft of this listing!',
	'listing edit_revision_notice' => '(Old version)',
	'listing:none' => 'No marketplace listings',
	'listing:error:missing:dog_name' => 'Please enter a dog name!',
	'listing:error:missing:breed' => 'Please enter the breed of your listing!',
	'listing:error:listing_not_found' => 'Cannot find specified marketplace listing.',
	'listing:error:revision_not_found' => 'Cannot find this revision.',

	// river
	'river:object:listing:create' => '%s published a marketplace listing %s',
	'river:object:listing:comment' => '%s commented on the marketplace %s',

	// notifications
	'listing:notify:summary' => 'New marketplace listing called %s',
	'listing:notify:subject' => 'New marketplace listing: %s',
	'listing:notify:body' => '%s published a new marketplace listing: %s

%s

View and comment on the listing listing:
%s',

	// widget
	'widgets:listing:name' => 'marketplace listings',
	'widgets:listing:description' => 'Display your latest marketplace listings',
	'listing:morelistings' => 'More marketplace listings',
	'listing:numbertodisplay' => 'Number of marketplace listings to display',
);
