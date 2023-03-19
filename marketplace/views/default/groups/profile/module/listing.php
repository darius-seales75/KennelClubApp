<?php
/**
 * Group listing module
 */

$params = [
	'entity_type' => 'object',
	'entity_subtype' => 'listing',
	'no_results' => elgg_echo('listing:none'),
];
$params = $params + $vars;

echo elgg_view('groups/profile/module', $params);
