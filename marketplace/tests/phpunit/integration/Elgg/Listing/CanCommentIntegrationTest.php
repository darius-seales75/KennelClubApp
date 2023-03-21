<?php

namespace Elgg\Listing;

use Elgg\Plugins\PluginTesting;

/**
 * @group Plugins
 */
class CanCommentIntegrationTest extends \Elgg\IntegrationTestCase {
	
	use PluginTesting;
	
	/**
	 * @dataProvider listingCommentStatusProvider
	 */
	public function testCanComment($enable_comments, $status, $expected) {
		$listing = $this->createObject([
			'subtype' => 'listing',
		], [
			'comments_on' => $enable_comments,
			'status' => $status,
		]);
		
		$this->assertInstanceOf(\ElggListing::class, $listing);
		$this->assertFalse($listing->canComment());
		
		$user = $this->createUser();
		$session = _elgg_services()->session;
		
		$session->setLoggedInUser($user);
		
		$this->assertEquals($expected, $listing->canComment());
	}
	
	public function listingCommentStatusProvider() {
		return [
			['On', 'published', true],
			['On', 'draft', false],
			['Off', 'published', false],
			['Off', 'draft', false],
		];
	}
}
