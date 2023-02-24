<?php
/**
 * Edit marketplace form
 */

elgg_require_js('elgg/marketplace/save_draft');

$marketplace = get_entity($vars['guid']);
$vars['entity'] = $marketplace;

$draft_warning = elgg_extract('draft_warning', $vars);
if ($draft_warning) {
	echo '<span class="mbm elgg-text-help">' . $draft_warning . '</span>';
}

$categories_vars = $vars;
$categories_vars['#type'] = 'categories';

$fields = [
	[
		'#label' => elgg_echo('dog_name'),
		'#type' => 'text',
		'name' => 'dog_name',
		'required' => true,
		'id' => 'marketplace_dog_name',
		'value' => elgg_extract('dog_name', $vars),
	],
	[
		'#label' => elgg_echo('marketplace:breed'),
		'#type' => 'text',
		'name' => 'breed',
		'id' => 'marketplace_breed',
		'value' => elgg_html_decode(elgg_extract('breed', $vars)),
	],
	[
		'#label' => elgg_echo('marketplace:date_of_birth'),
		'#type' => 'date',
		'name' => 'date_of_birth',
		'required' => true,
		'id' => 'marketplace_date_of_birth',
		'value' => elgg_extract('date_of_birth', $vars),
	],
	[
		'#label' => elgg_echo('marketplace:sex'),
		'#type' => 'char',
		'name' => 'sex',
		'required' => true,
		'id' => 'marketplace_sex',
		'value' => elgg_extract('sex', $vars),
	],
	[
		'#label' => elgg_echo('marketplace:color'),
		'#type' => 'text',
		'name' => 'color',
		'required' => true,
		'id' => 'color',
		'value' => elgg_extract('color', $vars),
	],
	[
		'#label' => elgg_echo('marketplace:cost'),
		'#type' => 'integer',
		'name' => 'cost',
		'required' => true,
		'id' => 'cost',
		'value' => elgg_extract('cost', $vars),
	],
	[
		'#label' => elgg_echo('tags'),
		'#type' => 'tags',
		'name' => 'tags',
		'id' => 'marketplace_tags',
		'value' => elgg_extract('tags', $vars),
	],
	$categories_vars,
	[
		'#label' => elgg_echo('comments'),
		'#type' => 'select',
		'name' => 'comments_on',
		'id' => 'marketplace_comments_on',
		'value' => elgg_extract('comments_on', $vars),
		'options_values' => [
			'On' => elgg_echo('on'),
			'Off' => elgg_echo('off'),
		],
	],
	[
		'#label' => elgg_echo('access'),
		'#type' => 'access',
		'name' => 'access_id',
		'id' => 'marketplace_access_id',
		'value' => elgg_extract('access_id', $vars),
		'entity' => elgg_extract('entity', $vars),
		'entity_type' => 'object',
		'entity_subtype' => 'marketplace',
	],
	[
		'#label' => elgg_echo('status'),
		'#type' => 'select',
		'name' => 'status',
		'id' => 'marketplace_status',
		'value' => elgg_extract('status', $vars),
		'options_values' => [
			'draft' => elgg_echo('status:draft'),
			'published' => elgg_echo('status:published'),
		],
	],
	[
		'#type' => 'container_guid',
		'entity_type' => 'object',
		'entity_subtype' => 'marketplace',
	],
	[
		'#type' => 'hidden',
		'name' => 'guid',
		'value' => elgg_extract('guid', $vars),
	],
];

foreach ($fields as $field) {
	echo elgg_view_field($field);
}

$save_status = elgg_echo('marketplace:save_status');
if ($marketplace) {
	$saved = date('F j, Y @ H:i', $marketplace->time_updated);
} else {
	$saved = elgg_echo('never');
}

$footer = <<<___HTML
<div class="elgg-subtext mbm">
	$save_status <span class="marketplace-save-status-time">$saved</span>
</div>
___HTML;

$footer .= elgg_view('input/submit', [
	'value' => elgg_echo('save'),
	'name' => 'save',
]);

// published marketplaces do not get the preview button
if (!$marketplace || $marketplace->status != 'published') {
	$footer .= elgg_view('input/button', [
		'value' => elgg_echo('preview'),
		'name' => 'preview',
		'class' => 'elgg-button-action mls',
	]);
}

if ($marketplace) {
	// add a delete button if editing
	$footer .= elgg_view('output/url', [
		'href' => elgg_generate_action_url('entity/delete', [
			'guid' => $marketplace->guid,
		]),
		'text' => elgg_echo('delete'),
		'class' => 'elgg-button elgg-button-delete float-alt',
		'confirm' => true,
	]);
}

elgg_set_form_footer($footer);
