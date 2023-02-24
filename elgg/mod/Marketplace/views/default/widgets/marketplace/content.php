<?php
/**
 * User marketplace widget display view
 */

/* @var $widget \ElggWidget */
$widget = elgg_extract('entity', $vars);

$num_display = (int) $widget->num_display ?: 4;

$options = [
	'type' => 'object',
	'subtype' => 'marketplace',
	'limit' => $num_display,
	'pagination' => false,
	'distinct' => false,
	'no_results' => elgg_echo('marketplace:none'),
];

$owner = $widget->getOwnerEntity();
if ($owner instanceof \ElggUser) {
	$options['owner_guid'] = $owner->guid;
	$url = elgg_generate_url('collection:object:marketplace:owner', ['username' => $owner->username]);
} elseif ($owner instanceof \ElggGroup) {
	$options['container_guid'] = $widget->owner_guid;
	$url = elgg_generate_url('collection:object:marketplace:group', ['guid' => $owner->guid]);
} else {
	$url = elgg_generate_url('collection:object:marketplace:all');
}

$options['widget_more'] = elgg_view_url($url, elgg_echo('marketplace:moremarketplaces'));

echo elgg_list_entities($options);
