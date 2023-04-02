<?php

namespace Elgg\Listing;

/**
 * @group Plugins
 * @group listing
 */
class GroupToolContainerLogicIntegrationTest extends \Elgg\Plugins\GroupToolContainerLogicIntegrationTest {

	/**
	 * {@inheritDoc}
	 */
	public function getContentType(): string {
		return 'object';
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getContentSubtype(): string {
		return 'listing';
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getGroupToolOption(): string {
		return 'listing';
	}
}
