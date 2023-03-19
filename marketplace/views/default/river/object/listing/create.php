<?php
/**
 * Listing river view.
 */

$item = elgg_extract('item', $vars);
if (!$item instanceof ElggRiverItem) {
	return;
}

$listing = $item->getObjectEntity();
if (!$listing instanceof ElggBlog) {
	return;
}

$vars['message'] = $listing->getExcerpt();

echo elgg_view('river/elements/layout', $vars);
