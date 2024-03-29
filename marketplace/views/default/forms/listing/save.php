<?php
/**
 * Edit listing form
 */

elgg_require_js('elgg/listing/save_draft');

$listing = get_entity($vars['guid']);
$vars['entity'] = $listing;

$draft_warning = elgg_extract('draft_warning', $vars);
if ($draft_warning) {
	echo '<span class="mbm elgg-text-help">' . $draft_warning . '</span>';
}

$categories_vars = $vars;
$categories_vars['#type'] = 'categories';

$fields = [
	[ //dog name
		'#label' => elgg_echo('Dog Name'),
		'#type' => 'text',
		'name' => 'title',
		'required' => true,
		'id' => 'listing_title',
		'value' => elgg_extract('title', $vars),
	],
	
	[// dog description
		'#label' => elgg_echo('Dog Description'),
		'#type' => 'longtext',
		'name' => 'description',
		'required' => true,
		'id' => 'listing_description',
		'value' => elgg_extract('description', $vars),
	],
	
	[// dog breed
		'#label' => elgg_echo('Breed'),
		'#type' => 'text',
		'name' => 'breed',
		'id' => 'listing_breed',
		'value' => elgg_html_decode(elgg_extract('breed', $vars)),
	],
	
	[// dog date of birth
		'#label' => elgg_echo('Date of Birth'),
		'#type' => 'date',
		'name' => 'date_of_birth',
		'required' => true,
		'id' => 'listing_date_of_birth',
		'value' => elgg_extract('date_of_birth', $vars),
	],
	
	[// dog gender 
		'#label' => elgg_echo('Sex'),
		'#type' => 'text',
		'name' => 'sex',
		'required' => true,
		'id' => 'listing_sex',
		'value' => elgg_extract('sex', $vars),
	],
	
	[// dog color
		'#label' => elgg_echo('Color'),
		'#type' => 'text',
		'name' => 'color',
		'required' => true,
		'id' => 'color',
		'value' => elgg_extract('color', $vars),
	],
	
	[// dog price
		'#label' => elgg_echo('Price'),
		'#type' => 'number',
		'step' => '0.01',
		'name' => 'price',
		'id' => 'listing-price',
		'value' => elgg_extract('price', $vars),
		'#help' => elgg_echo('listing:price:help', [$currency]),
	],
	
	[//
		'#label' => elgg_echo('Medical History'),
		'#type' => 'longtext',
		'name' => 'medical_history',
		'required' => true,
		'id' => 'medical_history',
		'value' => elgg_extract('medical_history', $vars),
	],
	[
		'#label' => elgg_echo('tags'),
		'#type' => 'tags',
		'name' => 'tags',
		'id' => 'listing_tags',
		'value' => elgg_extract('tags', $vars),
	],
	$categories_vars,
	[
		'#label' => elgg_echo('comments'),
		'#type' => 'select',
		'name' => 'comments_on',
		'id' => 'listing_comments_on',
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
		'id' => 'listing_access_id',
		'value' => elgg_extract('access_id', $vars),
		'entity' => elgg_extract('entity', $vars),
		'entity_type' => 'object',
		'entity_subtype' => 'listing',
	],
	[
		'#label' => elgg_echo('status'),
		'#type' => 'select',
		'name' => 'status',
		'id' => 'listing_status',
		'value' => elgg_extract('status', $vars),
		'options_values' => [
			'draft' => elgg_echo('status:draft'),
			'published' => elgg_echo('status:published'),
		],
	],
	[
		'#type' => 'container_guid',
		'entity_type' => 'object',
		'entity_subtype' => 'listing',
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

$save_status = elgg_echo('listing:save_status');
if ($listing) {
	$saved = date('F j, Y @ H:i', $listing->time_updated);
} else {
	$saved = elgg_echo('never');
}

$footer = <<<___HTML
<div class="elgg-subtext mbm">
	$save_status <span class="listing-save-status-time">$saved</span>
</div>
___HTML;

$footer .= elgg_view('input/submit', [
	'value' => elgg_echo('save'),
	'name' => 'save',
]);

// published listings do not get the preview button
if (!$listing || $listing->status != 'published') {
	$footer .= elgg_view('input/button', [
		'value' => elgg_echo('preview'),
		'name' => 'preview',
		'class' => 'elgg-button-action mls',
	]);
}

if ($listing) {
	// add a delete button if editing
	$footer .= elgg_view('output/url', [
		'href' => elgg_generate_action_url('entity/delete', [
			'guid' => $listing->guid,
		]),
		'text' => elgg_echo('delete'),
		'class' => 'elgg-button elgg-button-delete float-alt',
		'confirm' => true,
	]);
}

elgg_set_form_footer($footer);
