<?php
/**
 * Group marketplace module
 */

$params = [
	'entity_type' => 'object',
	'entity_subtype' => 'marketplace',
	'no_results' => elgg_echo('marketplace:none'),
];
$params = $params + $vars;

echo elgg_view('groups/profile/module', $params);
