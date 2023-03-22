<?php

namespace Elgg\Listing\Notifications;

use Elgg\Notifications\NotificationEventHandler;

/**
 * Notification Event Handler for 'object' 'listing' 'publish' action
 */
class PublishListingEventHandler extends NotificationEventHandler {

	/**
	 * {@inheritDoc}
	 */
	protected function getNotificationSubject(\ElggUser $recipient, string $method): string {
		return elgg_echo('listing:notify:subject', [$this->event->getObject()->getDisplayName()], $recipient->getLanguage());
	}
	
	/**
	 * {@inheritDoc}
	 */
	protected function getNotificationSummary(\ElggUser $recipient, string $method): string {
		return elgg_echo('listing:notify:summary', [$this->event->getObject()->getDisplayName()], $recipient->getLanguage());
	}
	
	/**
	 * {@inheritDoc}
	 */
	protected function getNotificationBody(\ElggUser $recipient, string $method): string {
		$entity = $this->event->getObject();
		
		return elgg_echo('listing:notify:body', [
			$this->event->getActor()->getDisplayName(),
			$entity->getDisplayName(),
			$entity->getURL(),
		], $recipient->getLanguage());
	}
	
	/**
	 * {@inheritDoc}
	 */
	protected static function isConfigurableForGroup(\ElggGroup $group): bool {
		return $group->isToolEnabled('listing');
	}
}
