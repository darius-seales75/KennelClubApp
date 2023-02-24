<?php
/**
 * marketplace river view.
 */

$item = elgg_extract('item', $vars);
if (!$item instanceof ElggRiverItem) {
	return;
}

$marketplace = $item->getObjectEntity();
if (!$marketplace instanceof Elggmarketplace) {
	return;
}

$vars['message'] = $marketplace->getBreed();

echo elgg_view('river/elements/layout', $vars);
