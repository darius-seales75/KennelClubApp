<?php
/**
 * Listing river view.
 */

$item = elgg_extract('item', $vars);
if (!$item instanceof ElggRiverItem) {
	return;
}

$listing = $item->getObjectEntity();
if (!$listing instanceof ElggListing) {
	return;
}


echo elgg_view('river/elements/layout', $vars);
