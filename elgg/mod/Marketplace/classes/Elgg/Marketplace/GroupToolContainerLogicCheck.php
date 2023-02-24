<?php

namespace Elgg\Marketplace;

use Elgg\Groups\ToolContainerLogicCheck;

/**
 * Prevent marketplaces from being created if the group tool option is disabled
 */
class GroupToolContainerLogicCheck extends ToolContainerLogicCheck {

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
		return 'marketplace';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getToolName(): string {
		return 'marketplace';
	}
}
