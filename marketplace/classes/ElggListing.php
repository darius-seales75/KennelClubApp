<?php
/**
 * Extended class to override the time_created
 *
 * @property string $status      The published status of the listing post (published, draft)
 * @property string $comments_on Whether commenting is allowed (Off, On)
 * @property int    $new_post    Whether this is an auto-save (not fully saved) (1 = yes, "" = no)
 */
class ElggListing extends ElggObject {

	/**
	 * {@inheritDoc}
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = "listing";
	}

	/**
	 * Can a user's listing be commented on?
	 *
	 * @see ElggObject::canComment()
	 *
	 * @param int  $user_guid User guid (default is logged in user)
	 * @param bool $default   Default permission
	 *
	 * @return bool
	 *
	 * @since 1.8.0
	 */
	public function canComment($user_guid = 0, $default = null) {
		$result = parent::canComment($user_guid, $default);
		if (!$result) {
			return $result;
		}

		if ($this->comments_on === 'Off' || $this->status !== 'published') {
			return false;
		}
		
		return true;
	}

}
